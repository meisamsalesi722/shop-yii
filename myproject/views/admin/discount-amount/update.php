<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DiscountAmount $model */

$this->title = 'Update Discount Amount: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Discount Amounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discount-amount-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
