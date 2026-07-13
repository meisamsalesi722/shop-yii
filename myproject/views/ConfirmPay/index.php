<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\FrontendAsset;

$this->registerCssFile(
    '@web/css/confirmpay-style.css',
    ['depends' => [\app\assets\FrontendAsset::class]]
);
?>
<div class="clearfix"></div>
    <section id="confirm-pay-section" class="mb-4 mt-5 pt-3 mt-lg-3">
        <div class="container">
            <div class="row text-right">
                <div class="col-12 col-md-6">
                    <div class="add-new-address-box h-100 p-3 bg-white border-radius">
                        <h5 class="mb-3 text-dark">افزودن آدرس پستی جدید</h5>
                        <?php $form = ActiveForm::begin() ?>

                            <?= $form->field($addressModel, 'recipient_name')->textInput([ 'placeholder' => 'نام و نام خانوادگی گیرنده' ,'maxlength' => true, 'class' => 'w-100 mb-3 px-3 py-1'])->label('') ?>
                            <?= $form->field($addressModel, 'mobile')->textInput([ 'placeholder' => 'تلفن همراه' ,'class' => 'w-100 mb-3 px-3 py-1'])->label('') ?>
                            <?= $form->field($addressModel, 'city')->textInput([ 'placeholder' => 'شهر' ,'maxlength' => true , 'class' => 'w-100 mb-3 px-3 py-1'])->label('') ?>
                            <?= $form->field($addressModel, 'postal_code')->textInput([ 'placeholder' => 'کد پستی' ,'maxlength' => true, 'class' => 'w-100 mb-3 px-3 py-1'])->label('') ?>
                            <?= $form->field($addressModel, 'address')->textarea(['rows' => 6 , 'class' => 'w-100 mb-3 px-3 py-2'])->label('') ?>
                            <?= Html::submitButton('ثبت آدرس جدید', [ 'value' => '1' ,'name' => 'save_address','class' => 'new-address-btn d-block buy-btn1 mr-auto px-3 py-2  btn btn-primary w-100']) ?>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="old-address-box h-100 mt-4 mt-md-0 p-3 bg-white border-radius">
                        <h5 class="mb-3">لیست آدرس های پستی که برای شما ثبت شده</h5>
                        <?php $form = ActiveForm::begin([
                            'options' => [
                                'id' => 'confirmForm'
                            ]
                        ]) ?>
                        <?php foreach ($addresses as $key => $address) { ?>
                            <label class="d-block" for="<?= $key ?>address">
                                <div role="link" href="#" class="address-item p-3 text-right my-2">
                                    <div class="address-header d-flex">
                                        <h6 class="selected-item d-none px-3 py-1 font-weight-light">آدرس منتخب</h6>
                                        <span class="px-2 py-1 font-weight-bold">گیرنده:</span>
                                        <p class="pt-1"><?= $address->recipient_name ?? $address->user->username ?></p>
                                    </div>
                                    <div class="address-body d-flex flex-md-column flex-lg-row justify-content-between pt-3">
                                        <p><span>آدرس:</span><?= $address->address ?></p>
                                        <div class="code-box mt-md-3 mt-lg-0 pr-3">
                                            <h6 class="font-weight-light text-dark"><span class="ml-2">موبایل:</span><?= $address->mobile ?></h6>
                                            <h6 class="font-weight-light text-dark"><span class="ml-2">کد پستی:</span><?= $address->postal_code ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <input type="radio" name="address_id" value="<?= $address->id ?>" class="d-none" id="<?= $key ?>address">
                            <input type="text" name="confirm_order" value="1" class="d-none">
                            <input type="text" name="copan_id" value="<?= $copan_id ?>" class="d-none">

                        <?php } ?>
                        <?php  ActiveForm::end() ?>

                    </div>
                </div>
            </div>
            <div class="off-code-box d-flex flex-column flex-lg-row justify-content-between my-3 p-3">
                <p class="text-right text-white"><i class="fal fa-badge-percent ml-2"></i>در صورت داشتن کد تخفیف در فیلد روبرو وارد نمایید.</p>

                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'd-flex mt-3 mt-lg-0' 
                        ]
                    ])?>

                    <input class="pr-2" name="copan_code" type="text" placeholder="کد تخفیف را وارد نمایید">
                    <?= Html::submitButton('اعمال کد تخفیف', [ 'value' => '1' ,'name' => 'copan','class' => 'px-auto btn btn-primary border-white']) ?>

                    <?php ActiveForm::end()?>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="total-price d-flex justify-content-between p-3">
                        <p>هزینه کل سفارش شما:</p>
                        <p class="price"><span><?= $totalPrice ?></span><span class="mr-2">تومان</span></p>
                    </div>
                    <?php if($totalDiscount != 0){?>  
                        <div class="pay-price d-flex justify-content-between mt-2 p-3">
                            <p>هزینه کسر شده تخفیف محصول:</p>
                            <p class="price"><span><?= $totalDiscount ?></span><span class="mr-2">تومان</span></p>
                        </div>  
                    <?php }?>
                    <?php if($copan_discount != 0){?>      
                        <div class="pay-price d-flex justify-content-between mt-2 p-3">
                            <p>هزینه کسر شده کوپن تخفیف:</p>
                            <p class="price"><span><?= $copan_discount ?></span><span class="mr-2">تومان</span></p>
                        </div>   
                    <?php }?>
                    <div class="pay-price d-flex justify-content-between mt-2 p-3">
                        <p>هزینه قابل پرداخت:</p>
                        <p class="price"><span><?= $finalPrice ?></span><span class="mr-2">تومان</span></p>
                    </div>        
                </div>
                <div class="col-md-6">
                    <button onclick="$('#confirmForm').submit();" class="confirm-pay-btn d-block w-100 buy-btn1 mr-auto mt-3 mt-md-0 py-3 text-center text-white">
                        <i class="fal fa-clipboard-check ml-2"></i>تایید و پرداخت سفارش</button>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>