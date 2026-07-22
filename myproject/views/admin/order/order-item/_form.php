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

    <?php if ($model->isNewRecord){ ?>

        <?= $form->field($model, 'product_id')->dropDownList(
            $products, ['prompt' => 'انتخاب کنید' , 'id' => 'product-level1']
        ) ?>


    <?=
    $form->field($model, 'color_id')->widget(DepDrop::class, [
        'options' => ['id'=>'product-level2'],
        'pluginOptions'=>[
            'depends'=>['product-level1'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/color-list'])
        ]
    ]);
    ?>

    <?=
        $form->field($model, 'number')->widget(DepDrop::class, [
        'options' => ['id'=>'number-level2'],
        'pluginOptions'=>[
            'depends'=>['product-level1'],
            'placeholder' => 'Select...',
            'url' => Url::to(['/admin/order/product-count'])
        ]
    ]);
    ?>
    
<?php }else{ ?>
    <?= $form->field($model, 'color_id')->dropDownList($colors) ?>

    <?= $form->field($model, 'number')->textInput(['type' => 'number' , 'min' => '1' , 'max' => ($model->product->marketable_number + $model->number)]) ?>
<?php } ?>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
