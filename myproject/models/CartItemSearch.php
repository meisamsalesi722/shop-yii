<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CartItem;

/**
 * CartItemSearch represents the model behind the search form of `app\models\CartItem`.
 */
class CartItemSearch extends CartItem
{
    public $user;
    public $product;
    public $colro;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id', 'number', 'color_id', 'created_at', 'updated_at'], 'integer'],
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
        $query = CartItem::find();

        $query->joinWith(['user' , 'product' , 'color']);

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
            'product_id' => $this->product_id,
            'number' => $this->number,
            'color_id' => $this->color_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'color.name', $this->color])
            ->andFilterWhere(['like', 'product.name', $this->product])
            ->andFilterWhere(['like', 'user.uesrname', $this->user]);

        return $dataProvider;
    }
}
