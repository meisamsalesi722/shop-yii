<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VendorProduct $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="vendor-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_variant_id')->hiddenInput(['value' => $product_variant_id])->label('') ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marketable_number')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
