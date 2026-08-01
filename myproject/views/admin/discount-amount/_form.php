<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DiscountAmount $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="discount-amount-form col-6">

    <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'product_id')->dropDownList(
            $products, ['prompt' => 'انتخاب کنید' , 'id' => 'product-level1']
        )->label('محصول') ?>


    <?=
    $form->field($model, 'product_variant_id')->widget(DepDrop::class, [
        'options' => ['id'=>'product-variant'],
        'pluginOptions'=>[
            'depends'=>['product-level1'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/product-variant-list'])
        ]
    ])->label('مشخصات محصول');
    ?>

    <?=
    $form->field($model, 'vendor_product_id')->widget(DepDrop::class, [
        'options' => ['id'=>'vendor-product'],
        'pluginOptions'=>[
            'depends'=>['product-variant'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/vendor-product-list'])
        ]
    ])->label('قیمت، فروشنده');
    ?>

    <?= $form->field($model, 'percentage')->textInput() ?>




    <?= $form->field($model, 'start_date')->input('date') ?>

    <?= $form->field($model, 'end_date')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
