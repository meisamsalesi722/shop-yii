<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\VendorProduct $model */

$this->title = 'Update Vendor Product: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vendor Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vendor-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_variant_id' => $product_variant_id
    ]) ?>

</div>
