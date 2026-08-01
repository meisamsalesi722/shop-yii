<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'ویرایش دسترسی';
?>

<div class="permission-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::label('نام دسترسی', 'name') ?>
<?= Html::textInput('name', $permission->name, [
    'class' => 'form-control',
    'readonly' => true,
]) ?>

    <br>

    <?= Html::label('توضیحات', 'description') ?>
    <?= Html::textInput('description', $permission->description, [
        'class' => 'form-control'
    ]) ?>

    <br>

    <?= Html::submitButton('ذخیره تغییرات', [
        'class' => 'btn btn-success'
    ]) ?>

    <?= Html::a('انصراف', ['index'], [
        'class' => 'btn btn-default'
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>