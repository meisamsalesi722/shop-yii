<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::hiddenInput('step', 2) ?>
    <?= Html::hiddenInput('product_id', $product_id) ?>

    <?php foreach ($attributes as $key => $attribute) {

?>

    <?= $form->field($model, "meta_key[]")->hiddenInput(['maxlength' => true , 'class' => 'col-3 m-2' , 'value' => $attribute->name ?? $attribute->meta_key])->label('') ?>
    <?= $form->field($model, "meta_value[]")->textInput(['maxlength' => true , 'class' => 'col-3 m-2' , 'value' => $attribute->meta_value ,  'placeholder' => $attribute->unit ?? ''])->label($attribute->name ?? $attribute->meta_key) ?>

    
 <?php }?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
