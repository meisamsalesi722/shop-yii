
<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\FrontendAsset;
use app\models\ProductUser;


$this->registerCssFile(
    '@web/css/product.css',
    ['depends' => [\app\assets\FrontendAsset::class]]
);
?>
<style>
    /* ===== SELLER SELECTION STYLES ===== */
    .product-left-sellers {
        background: #ffffff;
        border-radius: 16px;
        padding: 12px 14px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid #eef3f8;
    }

    .product-left-sellers .sellers-list::-webkit-scrollbar {
        width: 4px;
    }

    .product-left-sellers .sellers-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .product-left-sellers .sellers-list::-webkit-scrollbar-thumb {
        background: #c1c9d6;
        border-radius: 10px;
    }

    .product-left-sellers .seller-item {
        transition: all 0.25s ease;
    }

    .product-left-sellers .seller-item:hover {
        border-color: #90b8e8 !important;
        background: #f6faff !important;
        transform: translateX(-3px);
        box-shadow: 0 4px 12px rgba(42, 125, 225, 0.08);
    }

    .product-left-sellers .seller-item.active-seller {
        border-color: #2a7de1 !important;
        background: #f0f7ff !important;
    }

    .product-left-sellers .seller-item .seller-action {
        transition: all 0.2s ease;
    }

    .product-left-sellers .seller-item:hover .seller-action {
        display: block !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .product-left-sellers .seller-item {
            padding: 10px 12px !important;
        }
        
        .product-left-sellers .seller-item .seller-info .seller-name {
            font-size: 13px !important;
        }
        
        .product-left-sellers .seller-item .price-box span {
            font-size: 14px !important;
        }
    }
</style>

<!-------------------------------------Start product page--------------------------------->

        <section id="breadcrumb-top">
            <div class="container">
                <div class="row">
                    <div class="breadcrumb-top d-flex">
                        <div class="breadcrumb-top-item ml-4 mr-2 mr-sm-0">
                            <a href="<?= Url::to(['/list' , 'categoryId' => $product->category->parent->parent->id]) ?>"><?= $product->category->parent->parent->name ?></a>
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="breadcrumb-top-item ml-4">
                            <a href="<?= Url::to(['/list' , 'categoryId' => $product->category->parent->id]) ?>"><?= $product->category->parent->name ?> </a>
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="breadcrumb-top-item ml-4">
                            <a href="<?= Url::to(['/list' , 'categoryId' => $product->category->id]) ?>"><?= $product->category->name ?> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-------------------------------------Start product --------------------------------->
    
<section id="product">
        <div class="container">
            <div class="row">

                <div class="product-item col-lg-4 col-md-8 col-12 mx-auto px-5 d-none d-md-block">
                    <div class="product-img ">
                        <img src="<?= Yii::getAlias('@web/uploads/images/gallery/') . ($product->galleries[0]->image ?? '')  ?>" alt="" class="img-fluid" id="main-product-photo">
                    </div>
                    <div class="owl-carousel owl-theme three-slider">
                        <?php foreach($product->galleries as $key => $gallery){ ?>
                        <div class="item"><img src="<?= Yii::getAlias('@web/uploads/images/gallery/') . $gallery->image?>" class="mx-auto"alt="" onclick="change_photo('<?= Yii::getAlias('@web/uploads/images/gallery/') . $gallery->image?>')"></div>
                        <?php }?>
                    </div>
                </div>

                <div class="product-item d-block d-md-none col-12 px-5">
                    
                    <d  iv class="owl-carousel owl-theme four-slider">
                        <div class="item"><img src="img/mobile.jpg" alt=""></div>
                        <div class="item"><img src="img/mobile2.jpg" alt=""></div>
                        <div class="item"> <img src="img/mobile3.jpg" alt=""></div>
                        <div class="item"> <img src="img/mobile4.jpg" alt=""></div>
                        <div class="item"> <img src="img/mobile5.jpg" alt=""></div>
                    </d>
                </div>

                <div class="product-description col-lg-5  col-12 text-right">
                    <div class="title"><h2><?= $product->persian_name ?></h2></div>
                    <div class="subtitle"><p><?= $product->name ?></p> </div>
                    <div class="data-product">
                        <span>برند:</span>
                        <a href="<?= Url::to(['/list' , 'brandId' => $product->brand->id]) ?>"><?= $product->brand->original_name ?></a>
                        <span class="pr-4">دسته بندی:</span>
                        <a href="<?= Url::to(['/list' , 'categoryId' => $product->category->id]) ?>"><?= $product->category->name ?></a>
                        
                    </div>
                    <?php 
                         $form = ActiveForm::begin([
                            'options' => [
                                'id' => 'productVariants_form',
                            ]
                         ]); ?>

                        <input type="number" class="d-none" name="vendor_product_id" value="<?= $vendorProduct->id ?>">
                    

 
                    
                    <?php if(count($productVariants) > 0 ){?>
                        <div class="select-color d-flex">
                             <span class="my-auto">انتخاب رنگ: </span> 
                             <input type="hidden" id="change_productVariants" name="change_productVariants">
                             
                             
                            <?php foreach($productVariants as $variant){?>
                                <label for="productVariant_<?= $variant->id ?>" class="select-color-item <?= $variant->id == $productVariant_id ? 'active' : '' ?>" ><i class="fas fa-circle color-withe" style="color: <?= $variant->color_code ?>;"></i> <?= $variant->color ?> </label>
                                <input type="radio" class="d-none" onchange="$('#change_productVariants').val(1);$('#productVariants_form').submit()" <?= $variant->id == $productVariant_id ? 'checked' : '' ?>   id="productVariant_<?= $variant->id ?>" value="<?= $variant->id ?>" name="productVariant_id">
                            <?php }?>
                        </div>
                    <?php }?>
                        <?php ActiveForm::end(); ?>
                    

                    <?php if(count($product->productMetas) > 0 ){?>
                        <div class="description-org" id="show-more">
                            <h3>مشخصات اصلی :</h3>
                            <ul>
                                <?php foreach($productMetas as $key => $meta){?>
                                <?php if($key > 2) break ?>
                                <li><span class="description-org-title"><?=  $meta->meta_key ?>: </span> <span class="mr-2"><?= $meta->meta_value  . ' ' . $meta->unit ?></span></li>
                            <?php }?>

                        </ul>
                        <?php if(count($productMetas) > 3){?>
                        <button class="" id="show-more-btn">نمایش بیشتر</button>
                        <?php }?>
                    </div>
                    <?php }?>


                    <div class="description-org" id="close-more">
                    <h3>مشخصات اصلی :</h3>
                        <ul>
                            <?php foreach($productMetas as $key => $meta){?>
                                <li><span class="description-org-title"><?= $meta->meta_key ?>: </span> <span class="mr-2"><?= $meta->meta_value  . ' ' . $meta->unit ?></span></li>
                            <?php }?>
                        </ul>
                        <button class="" id="close-more-btn">بستن </button>
                    </div>
                </div>

                <div class="col-lg-3 ">
                    <div class="product-left">
                        <?php if($productVariant->guarantee){?>
                            <div class="product-left-warenty">
                                <i class="far fa-shield-check"></i>
                                <?= $productVariant->guarantee ?>
                            </div>
                        <?php } ?>
                        <div class="product-left-available <?= $product->status == 0 ? 'text-danger' : '' ?>">
                            <i class="fal fa-truck-container"></i>
                                <?= $product->status == 1 ? 'اماده ارسال' : 'امکان ارسال وجود ندارد'?>
                        </div>
                        <div class="product-left-not-available">
                            <?php 
                                $sum = 0 ;
                                foreach($productVariant->vendorProducts as $countVendorProduct){
                                    $sum += $countVendorProduct->marketable_number;
                                }

                            ?>
                            <i class="far fa-dolly-flatbed-<?= $sum > 0 ? 'alt' : 'empty'?>"></i>
                            <?= $sum > 0 ? ($sum < 5 ? $sum . ' عدد باقی مانده است ' : 'موجود') : 'ناموجود' ?>
                        </div>
                        <div class="product-left-price text-left">
                            <?php 
                            if($vendorProduct->discountAmounts){?>
                                <?php 
                                    $discountAmounts = $vendorProduct->discountAmounts;
                                ?>
                            <?php 
                                $price = $vendorProduct->price;
                                $discount =($price / 100) * ($discountAmounts->percentage);
                                $finalyPrice = $discount > $discountAmounts->discount_ceiling ? 
                                $price - $discountAmounts->discount_ceiling
                                : $price - $discount;
                            ?>
                            <span class="befor"><?= number_format($price) ?> </span>
                            <div class="d-flex justify-content-between">
                                <div class="price-off"><?= $discountAmounts->percentage ?>%</div>
                                <div>
                                    <span class="after"> <?= number_format($finalyPrice) ?> </span>
                                    <span class="price">تومان</span>
                                </div>
                            </div>
                            <?php }else{ ?>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="after"> <?= number_format($vendorProduct->price) ?> </span>
                                        <span class="price">تومان</span>
                                    </div>
                                </div>
                            <?php }?>
                                
                        </div>

                        <div class="product-left-favorit">
                            <?php
                                $user_id = Yii::$app->user->id;
                                $product_id = $product->id;
                               $isFavorite = ProductUser::isFavorite($user_id , $product_id);
                                ?>

                                <?= Html::a(
                                     $isFavorite ? 'حذف از علاقه مندی ها<i class="fas fa-heart text-danger"></i>' : 'افزودن به علاقه مندی ها<i class="far fa-heart text-danger"></i>',
                                    Url::to( ['/product/toggle-favorite' , 'id' => $product->id]),
                                    ['class' => 'text-dark']
                                ) ?>
                        </div>

                        <button onclick="$('#productVariants_form').submit();" class="btn w-100" <?=  $vendorProduct->marketable_number > 0 ? '' : 'disabled' ?>>
                            <i class="fal fa-shopping-cart"></i>
                            افزودن به سبد خرید
                        </button>

                        


                    </div>
                        
                </div>
            </div>

                
        </div>
        
</section>

                        <!-- --------------------------------- -->
                         <!-- ===== START SELLER SELECTION SECTION ===== -->
<div class="product-left-sellers mt-3  w-75 mx-auto">
    <div class="sellers-header d-flex justify-content-between align-items-center mb-2">
        <span class="font-weight-bold" style="font-size: 15px;">
            <i class="fas fa-store-alt text-primary ml-1"></i>
            فروشندگان این کالا
        </span>
        <span class="badge badge-light text-dark px-3 py-2" style="font-size: 12px; border-radius: 20px;">
            <i class="fas fa-check-circle text-success ml-1"></i>
            <?= count($productVariant->vendorProducts) ?> فروشنده
        </span>
    </div>

    <div class="sellers-list" style="max-height: 320px; overflow-y: auto; padding-left: 4px;">
        <?php foreach($productVariant->vendorProducts as $index => $singleVendorProduct): ?>
            <?php 
                if($singleVendorProduct->marketable_number == 0){
                    continue;
                }
                $hasDiscount = isset($singleVendorProduct->discountAmounts);
                $finalPrice = $singleVendorProduct->price;
                $discountPercent = 0;
                if($hasDiscount) {
                    $discountAmounts = $singleVendorProduct->discountAmounts;
                    $discount = ($singleVendorProduct->price / 100) * ($discountAmounts->percentage);
                    $finalPrice = $discount > $discountAmounts->discount_ceiling ? 
                        $singleVendorProduct->price - $discountAmounts->discount_ceiling : 
                        $singleVendorProduct->price - $discount;
                    $discountPercent = $discountAmounts->percentage;
                }
                
                $isAvailable = $singleVendorProduct->marketable_number > 0;

                $stockStatus = $isAvailable ? 'موجود' : 'ناموجود';
                $stockClass = $isAvailable ? 'text-success' : 'text-danger';
            ?>

                <form action="<?= Url::to(['' , 'id' => $product_id])?>" method="post" id="change-vendor-product">
                    <?php $form = ActiveForm::begin() ?>

                        <input type="hidden" id="input-vendor-product-id" name="change_vendor_product_id">

                    <?php ActiveForm::end() ?>
                </form>
            
            <div class="seller-item <?= $vendorProduct->id == $singleVendorProduct->id ? 'active-seller' : '' ?>"
                 style="background: #fafcff; 
                        border: 1.5px solid #e6edf5; 
                        border-radius: 12px; 
                        padding: 12px 14px; 
                        margin-bottom: 10px; 
                        transition: all 0.2s ease;
                        cursor: pointer;"
                 onclick="$('#input-vendor-product-id').val(<?= $singleVendorProduct->id ?>)  ; $('#change-vendor-product').submit()">
                 
                
                <div class="d-flex justify-content-between align-items-start">
                    <div class="seller-info" style="flex: 1;">
                        <!-- نام فروشنده -->
                        <div class="seller-name d-flex align-items-center mb-1">
                            <i class="fas fa-store text-primary ml-1" style="font-size: 14px;"></i>
                            <span style="font-weight: 600; font-size: 14px; color: #1a2639;">
                                <?= $singleVendorProduct->vendor->name ?? 'فروشنده' ?>
                            </span>
                        </div>
                        
                        <!-- گارانتی و مشخصات -->
                        <div class="d-flex flex-wrap align-items-center gap-2" style="gap: 6px; font-size: 12px; color: #4b5a6f;">
                            <span class="badge" style="background: #e9eff6; padding: 3px 10px; border-radius: 30px; font-weight: 500;">
                                <i class="fas fa-shield-alt text-primary ml-1"></i>
                                <?= $singleVendorProduct->productVariant->guarantee ?? 'گارانتی ۱۸ ماهه هما تکام' ?>
                            </span>
                            
                            <?php if($hasDiscount): ?>
                                <span class="badge" style="background: #ffebee; color: #d32f2f; padding: 3px 10px; border-radius: 30px; font-weight: 600;">
                                    <i class="fas fa-tag ml-1"></i>
                                    <?= $discountPercent ?>% تخفیف
                                </span>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                    
                    <!-- قیمت و وضعیت -->
                    <div class="seller-price-status text-left" style="min-width: 100px;">
                        <div class="price-box">
                            <?php if($hasDiscount): ?>
                                <span style="font-size: 12px; color: #9e9e9e; text-decoration: line-through; display: block;">
                                    <?= number_format($singleVendorProduct->price) ?>
                                </span>
                                <span style="font-weight: 700; font-size: 16px; color: #d32f2f;">
                                    <?= number_format($finalPrice) ?>
                                </span>
                            <?php else: ?>
                                <span style="font-weight: 700; font-size: 16px; color: #1a2639;">
                                    <?= number_format($singleVendorProduct->price) ?>
                                </span>
                            <?php endif; ?>
                            <span style="font-size: 11px; color: #7f8c9b;">تومان</span>
                        </div>
                        
                        <div class="stock-status mt-1 <?= $stockClass ?>" style="font-size: 12px; font-weight: 500;">
                            <i class="fas fa-<?= $isAvailable ? 'check-circle' : 'times-circle' ?> ml-1"></i>
                            <?= $stockStatus ?>
                            <?php if($isAvailable && $singleVendorProduct->marketable_number < 5): ?>
                                <span style="font-size: 10px; color: #f57c00;">
                                    (<?= $singleVendorProduct->marketable_number ?> عدد)
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- دکمه انتخاب (مخفی در حالت عادی، نمایش روی هاور یا انتخاب) -->
                <div class="seller-action mt-2 text-left" style="display: <?= $vendorProduct->id == $singleVendorProduct->id ? 'block' : 'none' ?>;">
                    <button class="btn btn-sm btn-primary select-seller-btn" 
                            style="border-radius: 30px; padding: 4px 18px; font-size: 12px; font-weight: 600;"
                        >
                        <i class="fas fa-check ml-1"></i> انتخاب شده
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- توضیحات پایین -->
    <div class="sellers-footer mt-2" style="font-size: 11px; color: #9e9e9e; border-top: 1px dashed #e6edf5; padding-top: 10px;">
        <i class="fas fa-info-circle text-primary ml-1"></i>
        انتخاب هر فروشنده، قیمت و گارانتی مربوط به آن را تغییر می‌دهد.
    </div>
</div>
<!-- ===== END SELLER SELECTION SECTION ===== -->
                        <!-- --------------------------------- -->


<!-------------------------------------END product --------------------------------->


<section id="icon-shop" class="d-flex justify-content-between">
    <div class="container">
        <div class="row  justify-content-between">
            <div class="icon-shop-item col-4 col-md-2 my-auto">
                <img src="img/award.png" alt="" class="img-fluid my-auto">
                <span class="my-auto">ضمانت اصل بودن</span>
            </div>
            <div class="icon-shop-item col-4 col-md-2 my-auto">
                <img src="img/peyment2.png" alt="" class="img-fluid">
                <span class="my-auto">پرداخت اینترنتی</span>
            </div>
           <div class="icon-shop-item col-4 col-md-2 my-auto">
                <img src="img/truck.png" alt="" class="img-fluid">
                <span class="my-auto"> تحویل اکسپرس </span>
            </div>
            <div class="icon-shop-item col-4 col-md-2 my-auto">
                <img src="img/like.png" alt="" class="img-fluid">
                <span class="my-auto">تضمین قیمت</span>
            </div>
            <div class="icon-shop-item col-4 col-md-2 my-auto">
                <img src="img/website.png" alt="" class="img-fluid">
                <span class="my-auto">پشتیبانی </span>
            </div>
        </div>
    </div>
    
</section>


<!-------------------------------------Start product-bottom --------------------------------->

<section id="product-bottom" class="text-right">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-12 px-0 pl-lg-2">
                <!-- <div class="video-style ">
                    <video controls class="w-100">
                        <source src="video/video1.mp4" type="video/mp4">
                    </video>
                </div> -->

                <div class="description-tab d-none d-sm-block">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active py-3" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true"> <i class="far fa-book-open"></i> توضیحات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link   py-3" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-bars"></i> مشخصات </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><i class="far fa-comment"></i> نظرات کاربران</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <div class="tab-content-description">
                                <h3>معرفی کالا</h3>
                                <p>
                                <?= $product->introduction ?>
                                </p>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            
                            <div class="my-table">
                                <div class="my-table-item">
                                    <i class="far fa-arrow-alt-circle-left"></i><h4>مشخصات </h4> 
                                    <div class="table-responsive">
                                        <table class="table">
                                            
                                            <tbody>
                                                <?php foreach ($product->productMetas as $key => $pMeta) {?>
                                                <tr>
                                                    <th scope="row" ><?= $pMeta->meta_key ?></th>
                                                    <td ><?= $pMeta->meta_value . ' ' . $pMeta->unit ?> 
                                                    </td>
                                                </tr>
                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                               

                            </div>
                            
                            

                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <!-------START NO COMMENT-------->
                            <?php if(count($comments) <= 0){ ?>
                            <div class="no-comment-user text-center">
                                
                                <div class="top-no-comment">
                                    <img src="img/nocomment.0d700eb.svg" alt="" class="img-fluid">
                                    <h4>اولین نظر را شما بنویسید</h4>
                                    <p>با ارسال نظر ضمن کمک
                                        به دیگران، اگر کالا را از لیموناد خریده باشید امتیاز دریافت خواهید کرد

                                    </p>
                                    <button type="button" class="btn btn-comment">ارسال نظر جدید</button>
                                </div>
                                <div class="bottom-no-comment text-right">
                                    <div class="bottom-no-comment-title">
                                        <h3>نظرات کاربران</h3>
                                    </div>
                                    <p>دیدگاهی برای این کالا وجود ندارد</p>
                                </div>

                            </div>
                            <?php }?>
                            <!-------END NO COMMENT-------->


                            <!-------START COMMENT-------->

                            <div class="comment-user ">
                                <div class="comment-user-title">
                                    <h3>نظرات کاربران</h3>
                                </div>

                            <?php if(count($comments) > 0){  foreach($comments as $comment){ ?>
                        
                                <div class="comment-sender">
                                    <div class="comment-sender-details d-flex justify-content-between ">
                                        <span> <i class="far fa-user-circle"></i> <?= $comment->user->username ?></span><span><?=  $comment->created_at ?></span>
                                    </div>
                                    <div class="comment-content">
                                        <p><?= $comment->comment ?></p>
                                    </div>
                                    <div class="comment-like">

                                    </div>

                                </div>
                                <?php if($comment->children){
                                    foreach($comment->children as $children){
                                    ?>
                                    
                                    <div class="comment-admin">
                                        <div class="comment-admin-details d-flex justify-content-between ">
                                            <span><i class="fal fa-comment-alt-lines"></i> پاسخ کارشناس</span><span><?= $children->created_at ?></span>
                                        </div>
                                        <div class="comment-admin-content">
                                            <p><?= $children->comment ?></p>
                                        </div>
                                        

                                    </div>

                                <?php }}?>
                                <?php }}?>
                            </div>

                            <!-------END  COMMENT-------->

                        </div>
                    </div>

                    
                </div>


                <div class="information-mobile d-block d-sm-none">
                    <div class="description-mobile">
                        <div class="small-box-information" onclick="opent_body('#angle-down-1')">
                            <a class="mobile-style justify-content-between " data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
                                <div class="div-start">
                                    <i class="fas fa-bars"></i>    مشاهده مشخصات کامل 
                                </div>
                                
                                <div class="div-end">
                                    <i id="angle-down-1" class="fas fa-chevron-left down-rotate"></i>
                                </div>
                            </a>
                            
                        </div>
                        <div class="collapse" id="collapse1">
                            <div class="card card-body">
                                
    
                                <div class="my-table">
                                    <div class="my-table-item">
                                        <i class="far fa-arrow-alt-circle-left"></i><h4>مشخصات فیزیکی</h4> 
                                        <div class="table-responsive">
                                            <table class="table">
                                                
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" >ابعاد</th>
                                                        <td >39x12x4.5 میلی‌متر
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >وزن</th>
                                                        <td >گرم</td>
                                                    </tr>
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
    
                                    <div class="my-table-item">
                                        <i class="far fa-arrow-alt-circle-left"></i><h4>مشخصات فنی</h4> 
                                        <div class="table-responsive">
                                            <table class="table">
                                                
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">رابط</th>
                                                        <td >39x12x4.5 میلی‌متر
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">ظرفیت</th>
                                                        <td>گرم</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">مقاومت</th>
                                                        <td >گرم</td>
                                                    </tr>
                                                    <tr>
                                                        <th >وزن</th>
                                                        <td >گرم</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">وزن</th>
                                                        <td >گرم</td>
                                                    </tr>
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
    
                                   
    
                                </div>
    
                            </div>
                        </div>
                    </div>
    
                    <div class="tozihat-mobile">
                        <div class="small-box-information" onclick="opent_body('#angle-down-2')">
                            <a class=" mobile-style justify-content-between" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
                          <div class="div-start">
                            <i class="far fa-book-open "></i>    توضیحات کامل  
                          </div> 
                           <div class="div-end">
                            <i id="angle-down-2" class="fas fa-chevron-left down-rotate"></i>
                           </div> 
                            </a>
                            
                        </div>
                        <div class="collapse" id="collapse2">
                            <div class="card card-body">
                                <h3>معرفی کالا</h3>
                                <p>
                                     
                                    فلش مموری ای دیتا مدل UV210 در تاریخ 9 آوریل
                                     سال 2017 به بازار عرضه شد و در دسترس کاربران قرار گرفت. 
                                    این فلش مموری ساخت ای دیتا یک حافظه جانبی همراه، با طراحی ساده 
                                    و یکدست می باشد که می تواند داده ها و اطلاعات مهم شما
                                    را در خود ذخیره کند و به خوبی از آن ها محافظت کند.
                                    کمپانی ای دیتا برای فلش مموری ای دیتا مدل UV210 وزنی معادل 6 گرم و ابعادی برابر با 39×12×4.5 میلیمتر در نظر گرفته است که باعث می شود شما بتوانید به راحتی آن را با خود حمل کنید. این فلش مموری بدنه ای از جنس فلز با کیفیت دارد که این موضوع باعث شده است به و گرد و غبار بسیار مقاوم باشد. این فلش مموری
                                    همچنین با استفاده از تراشه COB می تواند در برابر
                                    آب و شوک یا لرزش به خوبی مقاوم باشد. علاوه بر آن، بدنه UV210 به گونه ای طراحی شده است که مانع از جذب اثر انگشت شما و لکه می شود، همچنین طراحی بدون درپوش آن باعث می شود شما بتوانید با سهولت بیشتری فلش مموری خود را حمل کنید. در قسمت بالایی فلش مموری 
                                    ای دیتا مدل UV210 یک شیار طراحی شده است که امکان اتصال بند را برای شما فراهم می کند. این فلش مموری مجهز به پورت USB 2.0 می باشد که از این طریق می تواند به لپ تاپ، کامپیوتر و یا دیگر دستگاه های هوشمند متصل شود و اطلاعات شما را با سرعتی معادل 480 مگابایت بر ثانیه منتقل کند. برای این فلش مموری از شرکت ای دیتا، 16 گیگابایت فضای ذخیره سازی در نظر گرفته شده است 
                                    که به شما امکان می دهد عکس ها 
                                    فیلم ها و یا دیگر اطلاعات مهم خود را روی آن ذخیره کنید و با خود به همراه داشته باشید.
                                </p>
    
                            </div>
                        </div>
                    </div>
    
    
                    <div class="comment-user-mobile">
                        <div class="small-box-information" onclick="opent_body('#angle-down-3')">
                            <a class="mobile-style justify-content-between" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
                            <div class="div-start">
                                <i class="far fa-comment"></i> نظرات کاربران 
                            </div>
                            <div class="div-end">
                                <i id="angle-down-3" class="fas fa-chevron-left down-rotate"></i>
                            </div>
                            </a>
                            
                        </div>
    
                        <div class="collapse" id="collapse3">
                            <div class="card card-body">
    
                                <div class="no-comment-user text-center">
                                    
                                    <div class="top-no-comment">
                                        <img src="img/nocomment.0d700eb.svg" alt="" class="img-fluid">
                                        <h4>اولین نظر را شما بنویسید</h4>
                                        <p>با ارسال نظر ضمن کمک
                                            به دیگران، اگر کالا را از لیموناد خریده باشید امتیاز دریافت خواهید کرد
    
                                        </p>
                                        <button type="button" class="btn btn-comment">ارسال نظر جدید</button>
                                    </div>
                                    <div class="bottom-no-comment text-right">
                                        <div class="bottom-no-comment-title">
                                             <h3>نظرات کاربران</h3>
                                        </div>
                                       
                                        <p>دیدگاهی برای این کالا وجود ندارد</p>
                                    </div>
    
                                </div>
    
                            </div>
                          </div>
                    </div>
                </div>


                
            </div>

            <div class="col-lg-4 col-12 mt-4 mt-lg-0 px-0 pr-lg-2">
                <div class="form-user-comment">
                    <div class="form-user-comment-title pb-2 pt-3 text-right">
                        <h3 >ارسال نظر</h3>
                    </div>

                    
                    <!-- <form action="" enctype="text/plain" class="px-3" method="POST"> -->
                        <!-- <div class="form-border"> -->
                            <!-- <div class="form-group required ">
                                <label for="name" class="py-2 mt-2">نام و نام خانوادگی</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="name" id="name" class="form-control" placeholder="نام و نام خانوادگی">
                            </div>
                            
                            <div class="form-group required">
                                <label for="email-comment" class="py-2">ایمیل</label>
                                <span class="text-danger">*</span>
                                <input type="email" name="email" class="form-control" id="email-comment" aria-describedby="emailHelp" placeholder="ایمیل">
                            </div> -->
        
                            <!-- <div class="form-group">
                                <label for="Textarea-comment" class="py-2"> نظر کاربر درباره کالا</label>
                                <span class="text-danger">*</span>
                                <textarea class="form-control " name="comment" id="Textarea-comment" rows="6">متن اصلی را وارد کنید</textarea>
                            </div> -->
        
                            <!-- <div class="form-group  required  ">
                                <label   class="py-2">کد امنیتی</label> 
                                <input type="text" class="form-control" class="control-label">
                            </div> -->
                            
                            <!-- <button type="submit" class="btn btn-primary btn-bottom w-100 mb-4 mt-5 mx-auto">تایید و ارسال نظر </button>
                        </div>
                        
                    </form>
     -->
                    <?php
                        $form = ActiveForm::begin([
                            'action' => ['product/create', 'id' => $product->id],
                            'method' => 'post',
                            'options' => [
                                'class' => 'px-3',
                            ],
                        ]);
                        ?>

                        <div class="form-border">

                            <div class="form-group">
                                <label class="py-2">
                                    نظر کاربر درباره کالا
                                    <span class="text-danger">*</span>
                                </label>

                                <?= $form->field($model, 'comment' )->textarea([
                                    'rows' => 6,
                                    'class' => 'form-control',
                                    'placeholder' => 'متن اصلی را وارد کنید',
                                ])->label('') ?>

                            </div>

                            <div class="form-group required">
                                <label for="email-comment" class="py-2">ایمیل</label>
                                <span class="text-danger">*</span>

                                <?= $form->field($model, 'email')->textInput([
                                    'class' => 'form-control',
                                    'placeholder' => 'ایمیل را وارد کنید',
                                ])->label('') ?>
                            </div> 

                            <button type="submit" class="btn btn-primary btn-bottom w-100 mb-4 mt-5 mx-auto">
                                تایید و ارسال نظر
                            </button>

                        </div>

                        <?php ActiveForm::end(); ?>
                </div>
            </div>



        </div>
    </div>
    
    
</section>




<!-------------------------------------END product-bottom --------------------------------->





<!-------------------------------------Start slider --------------------------------->
<section id="small-slider">
    <div class="container">
        <div class="row px-3 px-sm-0">
           <div class="small-slider-big col-lg-12"  >
            <h3 dir="rtl">محصولات جدید</h3>

            <div class="visited-slider">
                <div class="owl-carousel owl-theme second-slider" >
                    <?php foreach($newProducts as $newProduct){?>
                    <div class="item offer-item" >
                        <a href="<?= Url::to(['product/' , 'id' => $newProduct->id]) ?>" class="d-block text-center">
                            <img src="<?= Yii::getAlias('@web/uploads/images/') . ($newProduct->image ?? '') ?>" alt="">
                                   <div class=" img-caption">
                                    <p ><?= $newProduct->name ?></p>
                                            <?php if(count($newProduct->productVariantsHasDiscount) > 0){?>
                                            <?php
                                                $discountAmounts = $newProduct->productVariantsHasDiscount[0]->vendorProductsHasDiscount[0]->discountAmounts;
                                                $price = $newProduct->productVariantsHasDiscount[0]->vendorProductsHasDiscount[0]->price;
                                            ?>
                                            <span class="percent-off"><?= $discountAmounts->percentage ?>%</span>
                                                <?php 
                                                    $discount =($price / 100) * ($discountAmounts->percentage);
                                                    $finalyPrice = $discount > $discountAmounts->discount_ceiling ? 
                                                    $price - $discountAmounts->discount_ceiling
                                                    : $price - $discount;

                                                ?>
                                            <span class="price-befor">
                                                <?= $price ?>
                                            </span>
                                            <span class="price-after"> تومان 
                                                <?= number_format($finalyPrice) ?>
                                            </span>
                                            
                                            <?php }else{?>
                                                <span class="price"><?= number_format($newProduct->productVariants[0]->vendorProducts[0]->price) ?></span>
                                                <span class="unit">تومان</span>
                                            <?php }?>
                                    </div>
                        </a>
                    </div>
                        <?php }?>
                </div>
            </div>
           </div>

        </div>
    </div>
</section>


<!-------------------------------------End slider --------------------------------->


<!-------------------------------------END product page--------------------------------->

<script>
    document.querySelectorAll('input[name="color_id"]').forEach(function (radio) {
    radio.addEventListener('change', function () {

        // حذف active از همه لیبل‌ها
        document.querySelectorAll('.select-color-item').forEach(function (label) {
            label.classList.remove('active');
        });

        // اضافه کردن active به لیبل مربوطه
        document.querySelector('label[for="' + this.id + '"]').classList.add('active');
    });
});
</script>

</script>