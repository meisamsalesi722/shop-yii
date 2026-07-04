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

    <?= $form->field($model, 'category1_id')->dropDownList(
        $categories, ['prompt' => 'انتخاب کنید' , 'id' => 'cat-level1']
    ) ?>


    <?=
    $form->field($model, 'category2_id')->widget(DepDrop::class, [
        'options' => ['id'=>'cat-level2'],
        'pluginOptions'=>[
            'depends'=>['cat-level1'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/product/cat-list'])
        ]
    ]);
    ?>
    <?=
        $form->field($model, 'category3_id')->widget(DepDrop::class, [
            'options' => ['id' => 'cat-level3'],
            'pluginOptions' => [
                'depends' => ['cat-level2'],
                'placeholder' => 'دسته سطح سوم را انتخاب کنید',
                'url' => Url::to(['/admin/product/cat-list'])
            ]
        ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
