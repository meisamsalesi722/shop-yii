<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\VendorProduct $model */

$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['/admin/product/index']];
$this->params['breadcrumbs'][] = ['label' => 'Product Variant', 'url' => ['/admin/product-variant/index' ,  'product_id' => $product_id]];

$this->title = 'Create Vendor Product';
$this->params['breadcrumbs'][] = ['label' => 'Vendor Products', 'url' => ['index' , 'product_variant_id' => $product_variant_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="vendor-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_variant_id' => $product_variant_id,
        'discountModel' => $discountModel,
    ]) ?>

</div>
