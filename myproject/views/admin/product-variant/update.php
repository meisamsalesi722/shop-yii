<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductVariant $model */

$this->title = 'Update Product Variant: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Variants', 'url' => ['index' , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'product_id' => $product_id ,'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-variant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_id' => $product_id
    ]) ?>

</div>
