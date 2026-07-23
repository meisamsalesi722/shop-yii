
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
                                'id' => 'color_form',
                            ]
                         ]); ?>
                    <?php if(count($product->color) > 0 ){?>
                        <div class="select-color d-flex">
                             <span class="my-auto">انتخاب رنگ: </span> 
                             <input type="hidden" id="change_color" name="change_color">
                            <?php foreach($product->color as $color){?>
                                <label for="color_<?= $color->id ?>" class="select-color-item <?= $color_id == $color->id ? 'active' : '' ?>" ><i class="fas fa-circle color-withe" style="color: <?= $color->color_code ?>;"></i> <?= $color->name ?> </label>
                                
                                <input type="radio" class="d-none" onchange=" $('#change_color').val(1);$('#color_form').submit()" <?= $color_id == $color->id ? 'checked' : '' ?>   id="color_<?= $color->id ?>" value="<?= $color->id ?>" name="color_id">
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
                        <?php if($product->guarantee){?>
                            <div class="product-left-warenty">
                                <i class="far fa-shield-check"></i>
                                <?= $product->guarantee->name ?>
                            </div>
                        <?php } ?>
                        <div class="product-left-available <?= $product->status == 0 ? 'text-danger' : '' ?>">
                            <i class="fal fa-truck-container"></i>
                                <?= $product->status == 1 ? 'اماده ارسال' : 'امکان ارسال وجود ندارد'?>
                        </div>
                        <div class="product-left-not-available">
                            <i class="far fa-dolly-flatbed-<?= $product->marketable_number > 0 ? 'alt' : 'empty'?>"></i>
                            <?= $product->marketable_number > 0 ? ($product->marketable_number < 5 ? $product->marketable_number . ' عدد باقی مانده است ' : 'موجود') : 'ناموجود' ?>
                        </div>
                        <div class="product-left-price text-left">
                            <?php if($product->discountAmounts){?>
                            <?php 
                                $price = $product->price;
                                $discount =($price / 100) * ($product->discountAmounts->percentage);
                                $finalyPrice = $discount > $product->discountAmounts->discount_ceiling ? 
                                $price - $product->discountAmounts->discount_ceiling
                                : $price - $discount;
                            ?>
                            <span class="befor"><?= $price ?> </span>
                            <div class="d-flex justify-content-between">
                                <div class="price-off"><?= $product->discountAmounts->percentage ?>%</div>
                                <div>
                                    <span class="after"> <?= $finalyPrice ?> </span>
                                    <span class="price">تومان</span>
                                </div>
                            </div>
                            <?php }else{ ?>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="after"> <?= $product->price ?> </span>
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
                        
                        <button onclick="$('#color_form').submit();" class="btn w-100" <?= $product->marketable_number > 0 ? '' : 'disabled' ?>>
                            <i class="fal fa-shopping-cart"></i>
                            افزودن به سبد خرید
                        </button>


                    </div>
                        
                </div>
            </div>

                
        </div>
        
</section>


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
                                    <span class="percent-off"><?= $newProduct->discountAmounts->percentage ?>%</span>
                                        <?php 
                                            $price = $newProduct->price;
                                            $discount =($price / 100) * ($newProduct->discountAmounts->percentage);
                                            $finalyPrice = $discount > $newProduct->discountAmounts->discount_ceiling ? 
                                            $price - $newProduct->discountAmounts->discount_ceiling
                                            : $price - $discount;

                                        ?>
                                    <span class="price-befor">
                                         <?= $price ?>
                                    </span>
                                    <span class="price-after"> تومان 
                                         <?= $finalyPrice ?>
                                    </span>
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