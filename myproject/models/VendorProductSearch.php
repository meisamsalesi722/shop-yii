<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\VendorProduct;
use yii\data\ActiveDataProvider;

/**
 * VendorProductSearch represents the model behind the search form of `app\models\VendorProduct`.
 */
class VendorProductSearch extends VendorProduct
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'marketable_number', 'frozen_number', 'sold_number', 'status'], 'integer'],
            [[ 'price', 'created_at', 'updated_at'], 'safe'],
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
        $vendor = Vendor::findOne(['user_id' => Yii::$app->user->id]);
        $query = VendorProduct::find()->where(['vendor_id' => $vendor->id]);

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
            'marketable_number' => $this->marketable_number,
            'frozen_number' => $this->frozen_number,
            'sold_number' => $this->sold_number,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'price', $this->price]);

        return $dataProvider;
    }
}
