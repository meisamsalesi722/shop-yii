<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true])->label('موضوع' , ['class' => 'my-3']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('متن تیکت', ['class' => 'my-3']) ?>

    <?= $form->field($model, 'user_id')->hiddenInput([
        'value' => Yii::$app->user->id,
    ])->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
