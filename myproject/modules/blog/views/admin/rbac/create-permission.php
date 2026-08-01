<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'ایجاد دسترسی';
?>

<div class="permission-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::label('نام دسترسی', 'name') ?>
    <?= Html::textInput('name', '', [
        'class' => 'form-control',
        'placeholder' => 'مثلاً product.create'
    ]) ?>

    <br>

    <?= Html::label('توضیحات', 'description') ?>
    <?= Html::textInput('description', '', [
        'class' => 'form-control'
    ]) ?>

    <br>

    <?= Html::submitButton('ذخیره', [
        'class' => 'btn btn-success'
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>