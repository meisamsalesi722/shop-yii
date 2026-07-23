<?php

use app\models\CartItem;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerCssFile(
    '@web/css/bill-style.css',
    ['depends' => [\app\assets\FrontendAsset::class]]
);
$count = 0;
?>

<div class="clearfix"></div>
    <section id="bills-section" class="mt-4 mb-4 mb-lg-5 pt-3 overflow-hidden">
        <div class="container">
            <div class="row div-card">
                    <div class="col-xl-9 col-lg-6 col-md-12 col-sm-12 col-12 text-right">

                    <?php if(count($cartItems) > 0){?>
                    <?php foreach($cartItems as $key => $item){ ?>
                        <div class="row all-item-card py-3 border-radius" data-aos="fade-up" data-aos-duration="2000">
                            <div class="img-item-box col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12 position-relative text-center">
                                <img class="img-image-card img-fluid border-radius" src="<?= Yii::getAlias('@web/uploads/images/' . $item->product->image) ?>" alt="product" title="<?= $item->product->name ?>" />
                            </div>
                            <div class="col-xl-5 col-lg-9 col-md-4 hidden-sm hidden-xs col-card mt-3 mt-lg-0">
                                <p class="p-in-card item-comment text-center text-md-right text-dark">
                                    <?= $item->product->name ?> <br />
                                    <span class="status-product mt-2 text-muted"> گروه محصول : <?= $item->product->category->name ?> </span>
                                    <br>
                                    <?php if($item->color){ ?>
                                        <span class="status-product mt-2 text-muted"> رنگ محصول : <?= $item->color->name ?> </span>
                                        <span class="status-product mt-2 text-muted"><i class="fas fa-circle " style="color: <?= $item->color->color_code ?>;"></i></span>  
                                        <br>
                                        <span class="status-product mt-2 text-muted"> قیمت : <?= $item->product->price + ($item->color->price_increase ?? 0) ?> </span>
                                        <br>
                                    <?php } ?>
                                    <a href="<?= Url::to(['cart-item/delete' , 'id' => $item->id]) ?>" class="delete-btn btn btn-sm mt-2"><i class="fad fa-trash ml-2"></i>حذف کالا</a>
                                </p>
                            </div>
                            <div class="col-xl-2 col-lg-12 col-md-2 col-sm-12 col-12 my-center col-card">
                                <span class="counter-item text-dark">تعداد</span>
                            <?php $form = ActiveForm::begin([
                                'action' => Url::to(['/cart-item/index' , 'cartItemId' => $item->id]),
                                'options' => [
                                    'id' => 'number_form'.$key
                                ]
                                ]) ?>
                                <select class="count-drop text-dark mx-auto" name="number" id="drop-63" onchange="$('#number_form'+<?= $key ?>).submit();">
                                    <?php for( $i = 0 ; $i < $item->product->marketable_number + $item->number ; $i++) {
                                    ?>
                                    <option value="<?= $i + 1 ?>" <?= $item->number == $i + 1 ? 'selected' : '' ?> ><?= $i+1 ?></option>
                                    <?php }?>

                                </select>
                                <?php ActiveForm::end() ?>
                            </div>
                            <div class="col-xl-3 col-lg-12 col-md-3 col-sm-12 col-12 my-center col-card">
                                <?php if($item->product->discountAmounts){?>

                                    <?php 
                                        $singlePrice = $item->product->price;
                                        if($item->color){
                                            $singlePrice += $item->color->price_increase;
                                        }
                                        $singleCount = $item->number;
                                        
                                        $SingleIemTotal = $singlePrice * $singleCount;
                                        
                                        $singleDiscount = 0;
                                        
                                        if ($item->product->discountAmounts) {
                                            
                                            $singleDiscount = ($SingleIemTotal * $item->product->discountAmounts->percentage) / 100;
                                            
                                            if ($singleDiscount > $item->product->discountAmounts->discount_ceiling) {
                                                $singleDiscount = $item->product->discountAmounts->discount_ceiling;
                                            }
                                        }
                                        
                                        

                                        $SingleTotalDiscount = $singleDiscount;
                                        $SingleFinalPrice = $SingleIemTotal - $singleDiscount;    
                                    ?>

                                    <s class="tatal-price-row item-price">
                                        <?= ($item->product->price + ($item->color->price_increase ?? 0) )* $item->number ?> تومان
                                    </s>
                                    <p class="tatal-price-row item-price m-3">
                                        <?= $SingleFinalPrice ?> تومان
                                    </p>
                                    <?php }else{ ?>
                                        <p class="tatal-price-row item-price m-3">
                                            <?= ($item->product->price + ($item->color->price_increase ?? 0) )* $item->number ?> تومان
                                        </p>
                                    <?php }?>
                            </div>
                        </div>
                        <?php 
                                $count += $item->number;
                        ?>
                    <?php }?>

                    <?php
                 }else{?>
                        <p>محصولی در سبد خرید شما وجود ندارد</p>
                    <?php } ?>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12" style="font-size: 13px;">
                        <div class="side-box all-item-card p-4 border-radius" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="300">
                            <p class="d-flex justify-content-between">
                                <span>مبلغ کل ( <?= $count ?> کالا)</span>
                                <span><?= $totalPrice ?> تومان</span>
                            </p>

                            <p class="d-flex justify-content-between mt-4 mb-3">
                                <span>تخفیف </span>
                                <span><?= $totalDiscount ?> تومان</span>
                            </p>
        
                            <p class="sum-all-item">
                                <span class="font-weight-bold">مبلغ قابل پرداخت:</span>
                                <span class="all-price font-weight-bold"><?= $finalPrice ?> تومان</span>
                            </p>
        
                            <div class="clear"></div>
                        </div>
        
                        <a href="<?= Url::to(['/confirm-pay']) ?>" class="left-buttom d-block buy-btn1 d-block w-100 mt-2 py-3 text-center text-white font-weight-bold"
                            data-aos="fade-up" data-aos-duration="2000" data-aos-delay="600"
                        >ادامه ثبت سفارش
                        <i class="fal fa-arrow-left mr-3 font-weight-bold"></i></a>
                    </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>