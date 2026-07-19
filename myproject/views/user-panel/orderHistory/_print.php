    <?= \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'نام مشتری',
                'value' => function($model){
                    return $model->user->username;
                }
            ],
            [
                'attribute' => 'آدرس',
                'value' => function($model){
                    return $model->address->address;
                }
            ],
            [
                'attribute' => 'کوپن تخفیف',
                'value' => function($model){
                    return $model->copan->code ?? 'کوپنی وارد نشده است';
                }
            ],
            [
                'attribute' => 'قیمت محصول',
                'value' => function($model){
                    return $model->original_price;
                }
            ],
            [
                'attribute' => 'قیمت نهایی محصول',
                'value' => function($model){
                    return $model->order_final_amount;
                }
            ],
            [
                'attribute' => 'مقدار تخفیف محصول',
                'value' => function($model){
                    return $model->order_discount_amount;
                }
            ],
            [
                'attribute' => 'قیمت کسر شده کوپن',
                'value' => function($model){
                    return $model->order_copan_discount_amount ?? 'کوپنی وارد نشده است';
                }
            ],
            [
                'attribute' => 'مقدار کل کسر شده',
                'value' => function($model){
                    return $model->order_total_products_discount_amount;
                }
            ],
            [
                'attribute' => 'تاریخ ثبت سفارش',
                'value' => function($model){
                    return $model->created_at;
                }
            ],

            // [
            //     'attribute' => 'order_status',
            //     'value' => function($model){
            //         return $model->order_status ? '' :;
            //     }
            // ],

        ],
    ]) ?>