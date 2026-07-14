<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Color $model */

$this->title = 'Update Color: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => ' / Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Colors', 'url' => ['color-index' , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['color-view', 'product_id' => $product_id , 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="color-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_id' => $product_id,
    ]) ?>

</div>
