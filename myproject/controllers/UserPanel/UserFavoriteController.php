<?php

declare(strict_types=1);    

namespace app\controllers\userpanel;


use Yii;
use yii\web\Controller;
use app\models\ProductUser;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class UserFavoriteController extends Controller
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
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }
    
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $query = $user->getProductUser();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        return $this->render('/user-panel/userFavorites/user-favorites',[
            'dataProvider' => $dataProvider,
        ]);
    }

        public function actionToggleFavorite($id){

        
        $isGuest = Yii::$app->user->isGuest;
        
        if(!$isGuest){
        $model = new ProductUser();
        $user_id = Yii::$app->user->identity->id ;
        $product = ProductUser::find()->where(['user_id' => $user_id , 'product_id' => $id])->one();
        if($product){
            $product->delete();
            return $this->redirect(['/userpanel/user-favorite']);
        }
        $model->product_id = $id;
        $model->user_id = $user_id;
        $model->save();
        return $this->redirect(['/userpanel/user-favorite']);
        }else{
            return $this->redirect(['/login']);
        }
    }

}
