<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductVariant $model */

$this->title = 'Create Product Variant';
$this->params['breadcrumbs'][] = ['label' => 'Product Variants', 'url' => ['index' , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-variant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_id' => $product_id,
    ]) ?>

</div>
