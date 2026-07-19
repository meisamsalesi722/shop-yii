<?php

declare(strict_types=1);    

namespace app\controllers\userpanel;


use Yii;
use yii\base\Model;
use app\models\User;
use yii\base\Security;
use yii\web\Controller;
use yii\web\ErrorAction;
use app\models\SignupForm;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;

class UserInfoController extends Controller
{

    public $layout = 'user-panel/main';

            public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        private readonly Security $security,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }
    
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $userModel = Yii::$app->user->identity;

        return $this->render('/user-panel/userInfo/user-info',[
            'userModel' => $userModel,
        ]);
    }

    public function actionUpdate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $userModel = Yii::$app->user->identity;
        $user_id = $userModel->id;
        $model = new SignupForm();
        $model->scenario = 'update';
        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())) {

                if ($user = $model->edit($user_id)) {
                        Yii::$app->user->login($user);
                        return $this->redirect(['/userpanel/user-info','userModel' => $userModel]);
                    }
            }
        }
        return $this->render('/user-panel/userInfo/update',[
            'userModel' => $userModel,
            'model' => $model,

        ]);
    }

    

}