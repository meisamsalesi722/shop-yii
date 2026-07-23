    <?= \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user',
                'value' => function($model){
                    return $model->user->username;
                }
            ],
            [
                'attribute' => 'address',
                'value' => function($model){
                    return $model->address->address;
                }
            ],
            [
                'attribute' => 'copan',
                'value' => function($model){
                    return $model->copan ? $model->copan->code : 'کوپنی وارد نشده است';
                }
            ],
            'original_price',
            'order_final_amount',
            'order_discount_amount',
            'order_copan_discount_amount',
            'order_total_products_discount_amount',
            // [
            //     'attribute' => 'order_status',
            //     'value' => function($model){
            //         return $model->order_status ? '' :;
            //     }
            // ],
            'created_at',
            'updated_at',
        ],
    ]) ?>