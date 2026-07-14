<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gallery $model */

$this->title = 'Update Gallery: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => ' / Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => ' Product Gallery', 'url' => ['gallery-index' ,  'product_id' => $product_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['gallery-view', 'id' => $model->id , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gallery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_id' => $product_id,
    ]) ?>

</div>
