<?php

use yii\helpers\Url;
use app\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\OrderItem;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\OrderItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Order Items';
$this->params['breadcrumbs'][] = ['label' => '/ Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <p>
    <?php 
        Modal::begin([
            'toggleButton' => ['label' => 'افزودن محصول'  , 'class' => 'btn btn-success'],
        ]);

    ?>
    </p>
    <div class="cart-item-form">

    <?php $form = ActiveForm::begin([
        'action' => Url::to(['/admin/order/order-item-create' , 'order_id' =>  $order_id])
    ]); ?>



        <?= $form->field($orderItemModel, 'product_id')->dropDownList(
            $products, ['prompt' => 'انتخاب کنید' , 'id' => 'product-level1']
        ) ?>


    <?=
    $form->field($orderItemModel, 'color_id')->widget(DepDrop::class, [
        'options' => ['id'=>'product-level2'],
        'pluginOptions'=>[
            'depends'=>['product-level1'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/color-list'])
        ]
    ]);
    ?>

    <?=
        $form->field($orderItemModel, 'number')->widget(DepDrop::class, [
        'options' => ['id'=>'number-level2'],
        'pluginOptions'=>[
            'depends'=>['product-level1'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/product-count'])
        ]
    ]);
    ?>
    




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


    
<?php 
Modal::end();
?>
    <?php if($model != null){?>
        <?= \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'attribute' => 'قیمت مجموع',
                'value' => function($model){
                    return $model->original_price . ' تومان ';
                }
            ],
            [
                'attribute' => 'مجموع تخفیف',
                'value' => function($model){
                    return $model->order_discount_amount . ' تومان ';
                }
            ],
            [
                'attribute' => 'قیمت نهایی ',
                'value' => function($model){
                    return $model->order_final_amount . ' تومان ';
                }
            ],

        ],
    ]) ?>

        <?= \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'آدرس محصول',
                'format' => 'raw',
                'value' => function($model) use($order_id){
                    $url = Url::to(["/admin/order/edit-address", 'order_id' => $order_id]);
                    return $model->address->address .'<a value="' .$url. '" class="change-address" id="add-to-factor-modal-order'.$model->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom"><i class="fa fa-edit"></i></a>';
                }
            ],

        ],
    ]) ?>

    <?php }?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/') . ($model->product->image ?? '') .'" alt="" style="max-width:100px;">';
                }
            ],
            [
                'attribute'=> 'product',
                'label' => 'محصول',
                'value' => 'product.persian_name',
            ],

            
            [
                'attribute' => 'number',
                'label' => 'تعداد',
                'value' => 'number'
            ],
            [
                'attribute' => 'final_product_price',
                'label' => 'قیمت محصول',
                'value' => function($model){
                    return $model->final_product_price . 'تومان';
                }
            ],
            [
                'attribute' => 'final_total_price',
                'label' => 'قیمت نهایی محصول',
                'value' => function($model){
                    return $model->final_total_price . 'تومان';
                }
            ],
            [
                'attribute' => 'final_discount',
                'label' => 'تخفیف نهایی محصول',
                'value' => function($model){
                    return $model->final_discount . 'تومان';
                }
            ],
            [
                'label' => 'رنگ',
                'attribute' => 'color',
                'value' => 'color.name'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete} {update}',
                 'buttons' => [
                    'view' => function ($url, $model, $key) use($order_id){
                        return Html::a(
                            '<i class="fas fa-eye"></i>',
                            ['admin/order/order-item-view', 'id' => $model->id , 'order_id' => $order_id]
                        );
                    },
                    'update' => function ($url, $model, $key) use($order_id){
                        $url = Url::to(["/admin/order/get-info", 'id' => $model->id, 'order_id' => $order_id]);
                        return '<a value="' .$url. '" class="item-more add-to-factor-modal" id="add-to-factor-modal-'.$model->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="افزودن به سبد خرید مشتری" aria-label="افزودن به سبد خرید مشتری"><i class="fa fa-edit"></i></a>';
                    },
                ],
                'urlCreator' => function ($action, OrderItem $model, $key, $index, $column) use($order_id) {
                    return Url::toRoute([ 'admin/order/order-item-' . $action, 'id' => $model->id , 'order_id' => $order_id]);
                 }
            ],
        ],
    ]); ?>

</div>


<script>
    
    $(document).on("click", '.add-to-factor-modal',function() {
        $('#modal-up').addClass('in');
        $('#modal-up').modal('show')
            .find('#modalAddToFactor')
            .load($(this).attr('value'));
    });

    $(document).on("click", '.change-address',function() {
        $('#modal-up').addClass('in');
        $('#modal-up').modal('show')
            .find('#modalAddToFactor')
            .load($(this).attr('value'));
    });
    
</script>


<?php
    Modal::begin([
        // 'header'=>'<h4>تعداد محصول را انتخاب کنید</h4>',
        'id'=>'modal-up',
        'size'=>'modal-md',
        'closeButton' => ['data-bs-dismiss' => 'modal']
    ]);
    
    echo '<div id="modalAddToFactor"></div>';
    
    Modal::end();
    ?>
