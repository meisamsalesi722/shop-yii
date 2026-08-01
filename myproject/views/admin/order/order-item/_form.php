<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CartItem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cart-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'user_id')->textInput() ?>


        <?= $form->field($orderItemModel, 'product_id')->dropDownList(
            $products, ['prompt' => 'انتخاب کنید' , 'id' => 'product-level1']
        ) ?>


    <?=
    $form->field($orderItemModel, 'product_variant_id')->widget(DepDrop::class, [
        'options' => ['id'=>'product-variant'],
        'pluginOptions'=>[
            'depends'=>['product-level1'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/product-variant-list'])
        ]
    ]);
    ?>

    <?=
    $form->field($orderItemModel, 'vendor_product_id')->widget(DepDrop::class, [
        'options' => ['id'=>'vendor-product'],
        'pluginOptions'=>[
            'depends'=>['product-variant'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/vendor-product-list'])
        ]
    ]);
    ?>

    <?=
        $form->field($orderItemModel, 'number')->widget(DepDrop::class, [
        'options' => ['id'=>'number-level2'],
        'pluginOptions'=>[
            'depends'=>['vendor-product'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/product-count'])
        ]
    ]);
    ?>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
