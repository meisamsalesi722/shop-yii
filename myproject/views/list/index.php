<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\assets\FrontendAsset;

                        use yii\widgets\LinkPager;

$this->registerCssFile(
    '@web/css/list.css',
    ['depends' => [\app\assets\FrontendAsset::class]]
);
?>
     <!-------------------------------------Start product page--------------------------------->
      <div id="content">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 d-none d-lg-block">
                  <div class="content-right">
                     <div class="category">
                        <div class="category-sm">
                           <div class="category-title">
                              <h3>دسته بندی نتایج</h3>
                           </div>
                           <div class="category-content">
                              <div class="category-content-title">
                                 <i class="fas fa-chevron-left"></i>
                                 <a href="#">کالای دیجیتال</a>    
                              </div>
                              <div class="category-sub-content">
                                 <div>
                                    <i class="fas fa-chevron-down"></i>
                                    <a href="#">لپ تاپ</a>   
                                 </div>
                                 <div class="mr-3">
                                    <a href="#">لپ تاپ و الترابوک</a> 
                                 </div>
                                 <div class="mr-3">
                                    <a href="#">لوازم جانبی لپ تاپ</a> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="available-product d-flex justify-content-md-between">
                        <span class="my-auto"> فقط کالاهای موجود </span>

                        <?php 
                         $form = ActiveForm::begin([
                           'action' => '/list/index?sortId=' . $sortId,
                           'method' => 'get',
                        ]); ?>

                        
                        <label class="switch" onchange="$('#w0').submit();">
                        <input type="checkbox"  name="exist" value="1" <?= $exist ? 'checked' : '' ?>>
                        <span class="slider-available round"></span>
                        </label>


                     </div>
                     <div class="search-product">
                        <div class="search-box-information" onclick="opent_body('#angle-down-1')">
                           <a class="search-style justify-content-between " data-toggle="collapse" href="#collapse-search" role="button" aria-expanded="false" aria-controls="collapse-search">
                              <div class="div-start">
                                 جستجو در نتایج
                              </div>
                              <div class="div-end">
                                 <i id="angle-down-1" class="fas fa-chevron-left down-rotate"></i>
                              </div>
                           </a>
                        </div>
                        <div class="collapse" id="collapse-search">
                           <div class="card card-body">
                              <div class="d-flex form-search">

                                 <button type="submit" ><i class="fas fa-search"></i></button>
                                 <input type="text" name="send" value="<?= $search ?>" placeholder="نام کالا یا برند.... " class="my-auto border-0">


                              <!-- <form action="" class="d-flex form-search ">
                                 <button type="submit" name="send"><i class="fas fa-search"></i></button>
                                 <input type="text" placeholder="نام کالا یا برند.... " class="my-auto border-0">
                              </form> -->

                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="search-price">
                        <div class="search-box-information" onclick="opent_body('#angle-down-2')">
                           <a class="search-style justify-content-between " data-toggle="collapse" href="#collapse-search-price" role="button" aria-expanded="false" aria-controls="collapse-search-price">
                              <div class="div-start">
                                 قیمت
                              </div>
                              <div class="div-end">
                                 <i id="angle-down-2" class="fas fa-chevron-left down-rotate"></i>
                              </div>
                           </a>
                        </div>
                        <div class="collapse " id="collapse-search-price">
                           <div class="card card-body">
                              <!-- ---------range slider------- -->
                              <!-- <div dir="ltr" class="box">
                                 
                                 <div class="values">
                                    <div>$30000<span id="first"></span></div>
                                    - 
                                    <div>$4000000<span id="second"></span></div>
                                 </div>
                                 
                                 <div class="slider" data-value-0="#first" data-value-1="#second" data-range="#third"></div>
                              </div> -->

                              <!-- <label for="min_price">قیمت از</label>
                              <input type="number" id="min_price" name="min_price" placeholder="قیمت از">
                              <label for="max_price">تا</label>
                              <input type="number" id="max_price" name="max_price" placeholder="قیمت تا">
                              <div  class="submit-range">
                                 <button type="submit" href="#">اعمال محدوده قیمت </button>
                              </div> -->

                              <!-- فیلدهای قیمت -->
            <div class="price-fields">
                <div class="form-group">
                    <label for="min_price">قیمت از</label>
                    <input type="number" name="minPrice" id="min_price" value="<?= isset($minPrice) ? htmlspecialchars($minPrice) : '' ?>" placeholder="قیمت از" class="form-control">
                </div>
                <div class="form-group">
                    <label for="max_price">تا</label>
                    <input type="number" name="maxPrice" id="max_price" value="<?= isset($maxPrice) ? htmlspecialchars($maxPrice) : '' ?>" placeholder="قیمت تا" class="form-control">
                </div>
                <div class="submit-range">
                    <button type="submit" class="btn btn-primary btn-block">
                        اعمال محدوده قیمت
                    </button>
                </div>
            </div>

                              <!-- ---------range slider------- -->
                           </div>
                        </div>
                     </div>
                     
                     <div class="search-brand">
                        <div class="search-box-information" onclick="opent_body('#angle-down-3')">
                           <a class="search-style justify-content-between " data-toggle="collapse" href="#collapse-search-brand" role="button" aria-expanded="false" aria-controls="collapse-search-brand">
                              <div class="div-start">
                                 برند
                              </div>
                              <div class="div-end">
                                 <i id="angle-down-3" class="fas fa-chevron-left down-rotate"></i>
                              </div>
                           </a>
                        </div>
                        <div class="collapse" id="collapse-search-brand">
                           <div class="card card-body">
                              <!-- <form action="" class="d-flex form-search ">
                                 <button type="submit" name="send"><i class="fas fa-search"></i></button>
                                 <input type="text" placeholder="جستجوی نام....  " class="my-auto border-0">
                              </form> -->
                              <div class="brand-item">
                                 <?php foreach($brands as $brand){?>
                                 <div class="d-flex justify-content-between">
                                    <div>
                                       <i class="far fa-square"></i>
                                       <span> <?= $brand->persian_name ?></span>
                                    </div>
                                    <span> <?= $brand->original_name ?> </span>
                                 </div>
                                    <?php } ?>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="search-brand">
                        <div class="search-box-information" onclick="opent_body('#angle-down-4')">
                           <a class="search-style justify-content-between " data-toggle="collapse" href="#collapse-search-capacity" role="button" aria-expanded="false" aria-controls="collapse-search-capacity">
                              <div class="div-start">
                                 ظرفیت حافظه
                              </div>
                              <div class="div-end">
                                 <i id="angle-down-4" class="fas fa-chevron-left down-rotate"></i>
                              </div>
                           </a>
                        </div>
                        <div class="collapse" id="collapse-search-capacity">
                           <div class="card card-body">
                              <!-- <form action="" class="d-flex form-search ">
                                 <button type="submit" name="send"><i class="fas fa-search"></i></button>
                                 <input type="text" placeholder="جستجوی نام....  " class="my-auto border-0">
                              </form> -->
                              <div class="brand-item">
                                 <div class="d-flex justify-content-between">
                                    <div>
                                       <i class="far fa-square"></i>
                                       <span> ال جی</span>
                                    </div>
                                 </div>
                                 <div class="d-flex justify-content-between">
                                    <div>
                                       <i class="far fa-square"></i>
                                       <span> سامسونگ</span>
                                    </div>
                                 </div>
                                 <div class="d-flex justify-content-between">
                                    <div>
                                       <i class="far fa-square"></i>
                                       <span> اپل </span>
                                    </div>
                                 </div>
                                 <div class="d-flex justify-content-between">
                                    <div>
                                       <i class="far fa-square"></i>
                                       <span> اپل </span>
                                    </div>
                                 </div>
                                 <div class="d-flex justify-content-between">
                                    <div>
                                       <i class="far fa-square"></i>
                                       <span> اپل </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                     <a href="<?= Url::to('/list')  ?>" class="btn btn-warning w-100" >حذف همه فیلتر ها</a>
                  </div>
               </div>
               <div class="col-lg-9">
                  <!---------------------------------------START breadcrumb-top--------------------------------->
                  <div id="breadcrumb-top">
                     <div class="container">
                        <div class="row">
                           <div class="breadcrumb-top d-flex">
                              <div class="breadcrumb-top-item ml-4 mr-2 mr-sm-0">
                                 <a href="#">کالای دیجیتال</a>
                                 <i class="fas fa-chevron-left"></i>
                              </div>
                              <div class="breadcrumb-top-item ml-4">
                                 <a href="#">موبایل </a>
                                 <i class="fas fa-chevron-left"></i>
                              </div>
                              <div class="breadcrumb-top-item ml-4">
                                 <span>گوشی موبایل </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--------------------------------------- END breadcrumb-top--------------------------------->
                  <div class="sort-content d-none d-lg-block">
                     <i class="fas fa-sort-amount-up"></i>    
                     <span class="sort-title">مرتب سازی</span>
                        <a href="<?= Url::to(['/list', 'sortId' => 1 , 'send' => $search , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'exist' => $exist]) ?>" <?=  $sortId == 1 ? 'class="active"' : ''  ?>>گران ترین</a>
                     <a href="<?= Url::to(['/list', 'sortId' => 2 , 'send' => $search , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'exist' => $exist]) ?>" <?=  $sortId == 2 ? 'class="active"' : ''  ?>>ارزان ترین</a>
                     <a href="<?= Url::to(['/list', 'sortId' => 3 , 'send' => $search , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'exist' => $exist]) ?>" <?=  $sortId == 3 ? 'class="active"' : ''  ?>>پربازدیدترین</a>
                     <a href="<?= Url::to(['/list', 'sortId' => 4 , 'send' => $search , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'exist' => $exist]) ?>" <?=  $sortId == 4 ? 'class="active"' : ''  ?>>جدیدترین</a>
                  </div>
                  <div class="mobile-item d-block d-lg-none">
                     <span class="icon-mob-drow" onclick="open_sort()">
                     مرتب سازی براساس
                     <a href="<?= Url::to(['/list', 'sortId' => 1 , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'send' => $search , 'exist' => $exist]) ?>">
                        <span class="<?=  $sortId == 1 ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline-primary'  ?>"> 
                        گران ترین 
                        </span>
                     </a>
                     <a href="<?= Url::to(['/list', 'sortId' => 2 , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'send' => $search , 'exist' => $exist]) ?>">
                        <span class="<?=  $sortId == 2 ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline-primary'  ?>"> 
                        ارزان ترین 
                        </span>
                     </a>
                     <a href="<?= Url::to(['/list', 'sortId' => 3 , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'send' => $search , 'exist' => $exist]) ?>">
                        <span class="<?=  $sortId == 3 ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline-primary'  ?>"> 
                        پربازدیدترین 
                        </span>
                     </a>
                     <a href="<?= Url::to(['/list', 'sortId' => 4 , 'minPrice' => $minPrice , 'maxPrice' => $maxPrice , 'send' => $search , 'exist' => $exist]) ?>">
                        <span class="<?=  $sortId == 4 ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline-primary'  ?>"> 
                           جدیدترین 
                        </span>
                     </a>
                     
                     <span class="icon-mob-drow-2" onclick="open_filter_mobile()">
                        فیلتر های پیشرفته 
                     </span>
                  </div>
                  <?php ActiveForm::end(); ?>
                  <!---------------------------------------START product--------------------------------->
                  <div id="content-left">


                        <?= ListView::widget([
                           'dataProvider' => $dataProvider,
                           'itemView' => '_product_view',
                           'layout' => "{items}\n{pager}",
                           'options' => ['class' => 'row'],
                           'itemOptions' => ['class' => 'col-lg-4 col-md-6 mt-lg-3'],
                           'pager' => [
                              'class' => 'yii\bootstrap5\LinkPager',
                              'options' => [
                                 'class' => 'col-12  d-flex justify-content-center align-items-center m-3',
                              ]
                           ],
                           ]) ?>
                  </div>
                  <div class="product-list-footer-mobile d-flex d-md-none justify-content-between">
                     <a href="#" class="my-auto disabled">صفحه قبل</a>
                     <nav aria-label="...">
                        <ul class="pagination">
                           <li class="page-item"><a class="page-link" href="#">1</a></li>
                           <li class="page-item active">
                              <span class="page-link">
                              2
                              <span class="sr-only">(current)</span>
                              </span>
                           </li>
                           <li class="page-item"><a class="page-link" href="#">...</a></li>
                           <li class="page-item"><a class="page-link" href="#">15</a></li>
                        </ul>
                     </nav>
                     <a href="#" class="my-auto">صفحه بعد</a>
                  </div>
                  <div class="lap-description" id="show-more-lap">
                     <div class="lap-description-content">
                        <h3>خرید لپ تاپ</h3>
                        <p id="full-comment" class="overflow-hidden">
                              لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ،
                              و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و 
                              مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای 
                              متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال 
                              و آینده...،
                              شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را
                              لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ،
                              و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و 
                              مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای 
                              متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال 
                              و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را
                              لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ،
                              و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و 
                              مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای 
                              متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال 
                              و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را
                           </p>
                           <div class="lap-description-bottom d-flex justify-content-center">
                           <i class="fas fa-chevron-down my-auto"></i>
                           <button class="text-center" id="show-more-description-btn">نمایش بیشتر</button>
                        </div>
                     </div>
                  </div>
                  <!---------------------------------------END product--------------------------------->
               </div>
            </div>
         </div>
      </div>
      <!-------------------------------------END product page--------------------------------->