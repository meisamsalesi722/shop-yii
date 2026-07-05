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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'persian_name')->textInput() ?>

    <?= $form->field($model, 'introduction')->textarea(['rows' => 6]) ?>

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
    
    <?= $form->field($model, 'status')->dropDownList(
        [
            '0' => 'غیر فعال',
            '1' => 'فعال'
        ]
    ) ?>

    <?= $form->field($model, 'sold_number')->textInput() ?>

    <?= $form->field($model, 'frozen_number')->textInput() ?>

    <?= $form->field($model, 'marketable_number')->textInput() ?>

    <?= $form->field($model, 'color_id')->dropDownList($colors,
    ['prompt' => 'انتخاب کنید']) ?>

    <?= $form->field($model, 'brand_id')->dropDownList($brands,
    ['prompt' => 'انتخاب کنید']) ?>

    <?= $form->field($model, 'guarantee_id')->dropDownList($guarantee,
    ['prompt' => 'انتخاب کنید']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
