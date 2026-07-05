<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Gallery $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'product_id')->dropDownList(
        $products , ['prompt' => 'انتخاب کنید']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
