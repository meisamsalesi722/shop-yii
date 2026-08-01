<?php

declare(strict_types=1);    

namespace app\controllers\userpanel;


use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Vendor;
use yii\base\Security;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\UploadedFile;
use app\models\SignupForm;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;

class LoginVendorController extends Controller
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
        $request = Yii::$app->request;
        $userModel = Yii::$app->user->identity;
        $user_id = $userModel->id;
        $model = new SignupForm();
        $model->scenario = 'update';

        $vendorModel = Vendor::find()->where(['user_id' => $user_id])->one();

        if(!$vendorModel){
            $vendorModel = new Vendor();
        }

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if($request->isPost){


            if($vendorModel->load($request->post()) && $model->load(Yii::$app->request->post())){
                $vendorModel->imageFile = UploadedFile::getInstance($vendorModel, 'imageFile');
                $vendorModel->user_id = Yii::$app->user->id;
                $vendorModel->status = 0;


                if($vendorModel->validate() && $user = $model->edit($user_id)){
                    if($vendorModel->imageFile){
                        $vendorModel->deleteImage();
                        $imageName = time() . '.' . $vendorModel->imageFile->extension;
                        if (!file_exists('uploads/images/vendor')) {
                            mkdir('uploads/images/vendor', 0777, true);
                        }
                        $vendorModel->imageFile->saveAs('uploads/images/vendor/' . $imageName);
                        $vendorModel->image = $imageName;   
                    }
                    if($vendorModel->save(false)){

                        Yii::$app->session->setFlash('success' , 'ثبت نام شما با موفقیت انجام شد و پس از تایید کارشناسان میتوانید وارد پنل خود شوید');
                        Yii::$app->user->login($user);
                        return $this->refresh();
                    }
                }else{
                    $vendorModel->addErrors($vendorModel->getErrors());
                    $model->addErrors($model->getErrors());
                    return $this->render('/user-panel/login-vendor/index',[
                        'model' => $model,
                        'userModel' => $userModel,
                        'vendorModel' => $vendorModel,
                    ]);
                }
            } 
        }
        
        return $this->render('/user-panel/login-vendor/index',[
            'model' => $model,
            'userModel' => $userModel,
            'vendorModel' => $vendorModel,
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