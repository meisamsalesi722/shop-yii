<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gullery $model */

$this->title = 'Update Gullery: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gulleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gullery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
