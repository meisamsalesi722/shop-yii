<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Order;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'address_id', 'copan_id', 'order_status'], 'integer'],
            [['original_price', 'order_final_amount', 'order_discount_amount', 'order_copan_discount_amount', 'order_total_products_discount_amount', 'created_at', 'updated_at'], 'safe'],
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
    public function search($params, $formName = null)
    {
        $query = Order::find();

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
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'copan_id' => $this->copan_id,
            'order_status' => $this->order_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'original_price', $this->original_price])
            ->andFilterWhere(['like', 'order_final_amount', $this->order_final_amount])
            ->andFilterWhere(['like', 'order_discount_amount', $this->order_discount_amount])
            ->andFilterWhere(['like', 'order_copan_discount_amount', $this->order_copan_discount_amount])
            ->andFilterWhere(['like', 'order_total_products_discount_amount', $this->order_total_products_discount_amount]);

        return $dataProvider;
    }
}
