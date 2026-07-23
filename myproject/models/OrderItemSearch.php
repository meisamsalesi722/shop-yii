<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderItem;

/**
 * OrderItemSearch represents the model behind the search form of `app\models\OrderItem`.
 */
class OrderItemSearch extends OrderItem
{
    public $color;
    public $product;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'number', 'color_id', 'guarantee_id'], 'integer'],
            [['color' , 'product'], 'string'],
            [['final_product_price' , 'final_discount' , 'final_total_price', 'created_at', 'updated_at' , 'color'], 'safe'],
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
    public function search($params , $order_id , $formName = null)
    {
        $query = OrderItem::find()->where(['order_id' => $order_id]);

        // add conditions that should always apply here

        $query->joinWith(['color c']);
        $query->joinWith(['product p']);

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
            'product_id' => $this->product_id,
            'number' => $this->number,
            'color_id' => $this->color_id,
            'guarantee_id' => $this->guarantee_id,
            'final_discount' => $this->final_discount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'final_product_price', $this->final_product_price])
            ->andFilterWhere(['like', 'final_total_price', $this->final_total_price])
            ->andFilterWhere(['like', 'c.name', $this->color])
            ->andFilterWhere(['like', 'p.persian_name', $this->product])
            ->orFilterWhere(['like', 'p.name', $this->product]);

        return $dataProvider;
    }
}
