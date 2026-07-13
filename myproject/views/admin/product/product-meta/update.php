<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductMeta $model */

$this->title = 'Update Product Meta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => ' / Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => ' Product Metas', 'url' => ['meta-index' ,  'product_id' => $product_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['meta-view', 'id' => $model->id , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-meta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_id' => $product_id,
    ]) ?>

</div>
