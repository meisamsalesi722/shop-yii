<?php

namespace app\controllers\userpanel;

use Yii;
use app\models\Ticket;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\TicketSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    public $layout = 'user-panel/main';

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Ticket models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $ticket = Ticket::find()->where(['user_id' => Yii::$app->user->id , 'ticket_id' => null]);
        $dataProvider = new ActiveDataProvider([
            'query' => $ticket,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        return $this->render('/user-panel/ticket/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

        /**
     * Creates a new Copan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ticket();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['userpanel/ticket', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/user-panel/ticket/create', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $children = Ticket::find()
            ->where(['ticket_id' => $id]) 
            ->orderBy(['created_at' => SORT_ASC])
            ->all();

        return $this->render('/user-panel/ticket/view', [
            'children' => $children,
            'model' => $this->findModel($id),
        ]);
    }

public function actionReply($id)
{
    $parent = $this->findModel($id);
    
    if ($parent->status == Ticket::STATUS_CLOSE) {
        Yii::$app->session->setFlash('error', 'این تیکت بسته شده است.');
        return $this->redirect(['/userpanel/ticket', 'id' => $id]);
    }
    
    $reply = new Ticket();
    $reply->subject = 'پاسخ به: ' . $parent->subject;
    $reply->description = Yii::$app->request->post('reply_content');
    $reply->ticket_id = $id; 
    $reply->user_id = Yii::$app->user->id;
    $reply->status = '1';
    
    if ($reply->save()) {
        Yii::$app->session->setFlash('success', 'پاسخ شما با موفقیت ثبت شد.');
    } else {
        Yii::$app->session->setFlash('error', 'خطا در ثبت پاسخ.');
    }
    
    return $this->redirect(['view', 'id' => $id]);
}

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
