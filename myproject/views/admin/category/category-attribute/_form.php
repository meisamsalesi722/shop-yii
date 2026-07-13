<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CategoryAttribute $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
        $form->field($model, 'category_id')->hiddenInput([

                'value' => $category_id,
        ])->label('');
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
