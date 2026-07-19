<?php

namespace app\controllers\admin;

use Yii;
use app\models\Ticket;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\TicketSearch;
use yii\web\NotFoundHttpException;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
            public $layout = 'admin/admin';

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
        
        $stats = [
            'total' => Ticket::find()->where(['ticket_id' => null])->count(),
            'pending' => Ticket::find()->where(['status' => Ticket::STATUS_UNSEEN , 'ticket_id' => null])->count(),
            'approved' => Ticket::find()->where(['status' => Ticket::STATUS_OPEN, 'ticket_id' => null])->count(),
            'rejected' => Ticket::find()->where(['status' => Ticket::STATUS_CLOSE, 'ticket_id' => null])->count(),
        ];
        $tickets = Ticket::find()
            ->where(['ticket_id' => null])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();


        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'stats' => $stats,
            'tickets' => $tickets,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $modelNew = new Ticket();
        $model = $this->findModel($id);

        

        
        if ($this->request->isPost) {

                $modelNew->subject = 'پاسخ به: ' .  $model->subject;
                $modelNew->status = Ticket::STATUS_OPEN;
                $modelNew->user_id  = Yii::$app->user->id;
                $modelNew->ticket_id  = $id;
                $modelNew->is_admin = 1;
                $modelNew->description = Yii::$app->request->post('reply_content');
                if ($modelNew->save()) {
                    Yii::$app->session->setFlash('success', 'پاسخ شما با موفقیت ثبت شد.');
                } else {
                    Yii::$app->session->setFlash('error', 'خطا در ثبت پاسخ.');
                }
            }
                $children = Ticket::find()
                    ->where(['ticket_id' => $id]) 
                    ->orderBy(['created_at' => SORT_ASC])
                    ->all();

        return $this->render('create', [
            'children' => $children,
            'model' => $model,
        ]);
    }

        /**
     * تایید کامنت (برای ادمین)
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = Ticket::STATUS_OPEN;
        
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'تیکت با موفقیت باز شد.');
        } else {
            Yii::$app->session->setFlash('error', 'خطا در باز کردن تیکت.');
        }

    if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'message' => 'تیکت با موفقیت باز شد.'
        ];
    }
            
        return $this->redirect(Yii::$app->request->referrer ?: ['admin/ticket']);
    }

    /**
     * رد کامنت (برای ادمین)
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = Ticket::STATUS_CLOSE;
        
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'تیکت با موفقیت بسته شد.');
        } else {
            Yii::$app->session->setFlash('error', 'خطا در بستن تکیت.');
        }

            if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'message' => 'تیکت با موفقیت بسته شد.'
        ];
    }
        
        return $this->redirect(Yii::$app->request->referrer ?: ['admin/ticket']);
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
