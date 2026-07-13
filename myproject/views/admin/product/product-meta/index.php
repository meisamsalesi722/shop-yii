<?php

use app\models\ProductMeta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductMetaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Product Metas';
$this->params['breadcrumbs'][] = ['label' => ' / Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="product-meta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product Meta', ['admin/product/meta-' . 'create'  , 'product_id' => $product_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'meta_key',
            'meta_value',
            [
                'attribute' => 'product_id',
                'value' => 'product.name',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProductMeta $model, $key, $index, $column) use ($product_id) {
                    return Url::toRoute(['admin/product/meta-' .$action, 'product_id' => $product_id , 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
