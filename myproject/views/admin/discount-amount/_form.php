<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DiscountAmount $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="discount-amount-form col-6">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'product_id')->dropDownList($products,
    ['prompt' => 'انتخاب کنید']) ?>

    <?= $form->field($model, 'percentage')->textInput() ?>


    <?= $form->field($model, 'status')->dropDownList(
        [
            '0' => 'غیر فعال',
            '1' => 'فعال'
        ]
    ) ?>

    <?= $form->field($model, 'discount_ceiling')->textInput() ?>

    <?= $form->field($model, 'start_date')->input('date') ?>

    <?= $form->field($model, 'end_date')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
