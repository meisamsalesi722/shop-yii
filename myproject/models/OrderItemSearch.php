<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\OrderItem;
use GuzzleHttp\Psr7\Query;
use yii\data\ActiveDataProvider;

/**
 * OrderItemSearch represents the model behind the search form of `app\models\OrderItem`.
 */
class OrderItemSearch extends OrderItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'vendor_product_id', 'number'], 'integer'],
            [['final_product_price', 'final_discount', 'final_total_price', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $order_id , $admin = null , $formName = null)
    {
        $query = OrderItem::find()->where(['order_id' => $order_id]);

        // if(Yii::$app->user->can('vendor') && $admin == null){
            
        // }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'vendor_product_id' => $this->vendor_product_id,
            'number' => $this->number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'final_product_price', $this->final_product_price])
            ->andFilterWhere(['like', 'final_discount', $this->final_discount])
            ->andFilterWhere(['like', 'final_total_price', $this->final_total_price]);

        return $dataProvider;
    }
}
