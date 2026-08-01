<?php

namespace app\controllers\userpanel;

use Yii;
use app\models\Ticket;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\TicketSearch;
use yii\filters\AccessControl;
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['vendor'],
                        ],
                    ],
                ],
            ],
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
               
            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->id;
                $model->department_id = (int)Yii::$app->request->post('Ticket')['department_id'];
                if( $model->save()){
                    return $this->redirect(['userpanel/ticket', 'id' => $model->id]);
                }
            }
            dd($model->errors);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/user-panel/ticket/department', [
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

                    $reply->imageInput = UploadedFile::getInstances($reply, 'imageInput');
                    $reply->fileInput = UploadedFile::getInstances($reply, 'fileInput');
                    $fileName = [];
                    $imageNames = [];
                    if ($reply->validate()) {
                        
                    if($reply->imageInput){
                        if (!file_exists('uploads/images/ticket')) {
                            mkdir('uploads/images/ticket', 0777, true);
                        }
                        foreach ($reply->imageInput as $key => $image) {
                            $imageName = time() . '_' . $key . '.' . $image->extension;
                            $image->saveAs('uploads/images/ticket/' . $imageName);
                            $imageNames[] = $imageName;
                        }
                        $reply->image = json_encode($imageNames);
                    }
                    if($reply->fileInput){
                        if (!file_exists('uploads/file/ticket')) {
                            mkdir('uploads/file/ticket', 0777, true);
                        }
                        foreach ($reply->fileInput as $key => $file) {
                            $pdfName = time() . '_' . $key . '.' . $file->extension;
                            $file->saveAs('uploads/file/ticket/' . $pdfName);
                            $fileName[] = $pdfName;
                        }
                        $reply->file = json_encode($fileName);
                    }
                    

                    
                    if ($reply->save(false)) {
        Yii::$app->session->setFlash('success', 'پاسخ شما با موفقیت ثبت شد.');
    } else {
        Yii::$app->session->setFlash('error', 'خطا در ثبت پاسخ.');
    }
    }else{
        dd($reply->errors);
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
