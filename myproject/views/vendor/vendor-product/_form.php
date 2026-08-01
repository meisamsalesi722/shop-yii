<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\VendorProduct $model */
/** @var app\models\ProductDiscount $discountModel */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="vendor-product-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_variant_id')->hiddenInput(['value' => $product_variant_id])->label('') ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marketable_number')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <!-- فیلد hidden برای مشخص کردن فعال بودن تخفیف (فقط برای ارسال مقدار) -->
    <input type="hidden" name="is_discount_active" id="is_discount_active" value="<?= $discountModel->is_discount_active ?? 0 ?>">

    <!-- دکمه برای نمایش/مخفی کردن فیلدهای تخفیف -->
    <div class="form-group">
        <button type="button" id="toggle-discount-fields" class="btn btn-primary">
            <i class="glyphicon glyphicon-plus"></i> 
            <?= (!empty($discountModel->is_discount_active) || !empty($discountModel->percentage)) ? 'غیرفعال کردن تخفیف' : 'افزودن تخفیف' ?>
        </button>
    </div>

    <!-- بخش فیلدهای تخفیف -->
    <div id="discount-fields" style="<?= (!empty($discountModel->is_discount_active) || !empty($discountModel->percentage)) ? 'display: block;' : 'display: none;' ?> margin-top: 15px; padding: 15px; border: 1px solid #ddd; border-radius: 4px; background-color: #f9f9f9;">
        <h4>اطلاعات تخفیف</h4>
        
        <?= $form->field($discountModel, 'percentage')->textInput(['maxlength' => true, 'placeholder' => 'مثلاً: 10']) ?>

        <?= $form->field($discountModel, 'start_date')->textInput(['type' => 'date']) ?>

        <?= $form->field($discountModel, 'end_date')->textInput(['type' => 'date']) ?>

        <?= $form->field($discountModel, 'status')->dropDownList(
            [
                '0' => 'غیر فعال',
                '1' => 'فعال'
            ]
        ) ?>

        <?= $form->field($discountModel, 'discount_ceiling')->textInput()->label('حداکثر تخفیف') ?>
        
        <div class="alert alert-info" style="margin-top: 10px;">
            <small>توجه: با غیرفعال کردن تخفیف، مقادیر وارد شده پاک خواهند شد.</small>
        </div>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function() {
        var discountFields = $('#discount-fields');
        var toggleButton = $('#toggle-discount-fields');
        var isDiscountActiveInput = $('#is_discount_active');
        
        // تنظیم مقدار اولیه
        if (discountFields.is(':visible')) {
            isDiscountActiveInput.val(1);
            toggleButton.html('<i class="glyphicon glyphicon-minus"></i> غیرفعال کردن تخفیف');
            toggleButton.removeClass('btn-primary').addClass('btn-warning');
        } else {
            isDiscountActiveInput.val(0);
            toggleButton.html('<i class="glyphicon glyphicon-plus"></i> افزودن تخفیف');
            toggleButton.removeClass('btn-warning').addClass('btn-primary');
        }

        $('#toggle-discount-fields').click(function() {
            var button = $(this);
            
            if (discountFields.is(':visible')) {
                // مخفی کردن فیلدها و غیرفعال کردن تخفیف
                discountFields.slideUp(function() {
                    // پاک کردن تمام مقادیر فیلدهای تخفیف
                    $('#discountamount-percentage').val('');
                    $('#discountamount-start_date').val('');
                    $('#discountamount-end_date').val('');
                    $('#discountamount-status').val('0'); // تنظیم به غیر فعال
                    $('#discountamount-discount_ceiling').val('');
                });
                isDiscountActiveInput.val(0);
                button.html('<i class="glyphicon glyphicon-plus"></i> افزودن تخفیف');
                button.removeClass('btn-warning').addClass('btn-primary');
            } else {
                // نمایش فیلدها و فعال کردن تخفیف
                discountFields.slideDown();
                isDiscountActiveInput.val(1);
                button.html('<i class="glyphicon glyphicon-minus"></i> غیرفعال کردن تخفیف');
                button.removeClass('btn-primary').addClass('btn-warning');
            }
        });
        
        // هنگام ارسال فرم، اگر تخفیف فعال نیست، مقادیر خالی ارسال شوند
        $('form').on('beforeSubmit', function() {
            if (isDiscountActiveInput.val() == 0) {
                $('#discountamount-percentage').val('');
                $('#discountamount-start_date').val('');
                $('#discountamount-end_date').val('');
                $('#discountamount-status').val('0');
                $('#discountamount-discount_ceiling').val('');
            }
            return true;
        });
    });
</script>

<style>
    #discount-fields {
        transition: all 0.3s ease;
    }
    #discount-fields .form-group {
        margin-bottom: 15px;
    }
    #discount-fields h4 {
        margin-top: 0;
        color: #333;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    #toggle-discount-fields {
        margin: 10px 0;
    }
</style>