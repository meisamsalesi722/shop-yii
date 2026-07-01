<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Banner $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            '1' => 'فعال',
            '0' => 'غیر فعال'
        ]
    ) ?>

    <?= $form->field($model, 'position')->dropDownList(
        [
            '1' => 'اسلایدر',
            '2' => 'بنر پایین راست',
            '3' => 'بنر پایین چپ',
            '4' => 'بنر چپ پایین',
            '5' => 'بنر چپ بالا',
            '6' => 'چهار بنر وسط',
            '7' => 'دو بنر وسط',
            '8' => 'بنر تک اخر',
            ]
        ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
