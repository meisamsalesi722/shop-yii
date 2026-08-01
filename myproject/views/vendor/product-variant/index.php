<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use app\models\ProductVariant;

/** @var yii\web\View $this */
/** @var app\models\ProductVariantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['/vendor/product/index']];
$this->params['breadcrumbs'][] = 'Product Variant';

?>
<div class="product-variant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product Variant', ['create' , 'product_id' => $product_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'محصول',
                'attribute' => 'product_id',
                'value' => 'product.name'
            ],
            'color',
            [
                'attribute' => 'color_code',
                'format' => 'raw',
                'value' => function($model){
                    return ' <span class="status-product mt-2 text-muted"><i class="fas fa-circle " style="color: ' . $model->color_code . ';"></i></span>';
                }
            ],
            'guarantee',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}  {vendore-product}',
                 'buttons' => [
                    'vendore-product' => function ($url, $model, $key) use($product_id) {
                        return Html::a(
                            '<i class="fa fa-plus-circle"> این محصول را دارم </i>',
                            ['/vendor/vendor-product/create' , 'product_variant_id' => $model->id , 'product_id' => $product_id]
                        );
                    },
                    'view' => function ($url, $model, $key) {
                         $url = Url::to(["/vendor/vendor-product/vendors", 'id' => $model->id,]);
                        return '<a value="' .$url. '" class="item-more show-vendor" id="show-vendor-'.$model->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="دیگر فروشندگان" aria-label="دیگر فروشندگان"><i class="fa fa-edit"> دیگر فروشندگان </i></a>';
                    },
                ],
                // 'urlCreator' => function ($action, ProductVariant $model, $key, $index, $column) use($product_id) {
                //     return Url::toRoute([$action, 'product_id' => $product_id  ,'id' => $model->id]);
                //  }
            ],
        ],
    ]); ?>

    
<script>
    
    $(document).on("click", '.show-vendor',function() {
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



</div>
