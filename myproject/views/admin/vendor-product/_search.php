<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VendorProductSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="vendor-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?php  echo $form->field($model, 'price') ?>

    <?php  echo $form->field($model, 'marketable_number') ?>

    <?php // echo $form->field($model, 'frozen_number') ?>

    <?php // echo $form->field($model, 'sold_number') ?>

    <?php  echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
