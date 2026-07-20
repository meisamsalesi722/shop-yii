<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Signup</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<div>
    <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>