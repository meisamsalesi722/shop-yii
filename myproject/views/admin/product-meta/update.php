<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductMeta $model */

$this->title = 'Update Product Meta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-meta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
