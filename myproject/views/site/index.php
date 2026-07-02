    <section id="slider-section">
        <div class="container">
            <div class="row px-3 px-sm-0">
                
                <div class="col-lg-8  col-12 px-0 px-sm-2">
                    <div id="carousel1" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($banerSliders as $key => $banerSlider) { ?>
                                <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                    <a href="<?= $banerSlider->url ?>"><img class="d-block w-100" src="<?= Yii::getAlias('@web/uploads/images/') . $banerSlider->image ?>" alt="First slide"></a>
                                </div>
                            <?php } ?>

                        </div>
                        <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <div class="row mx-0">
                        <div class="col-lg-6 d-none d-lg-block pr-0 pl-2 pt-3"><a href="<?= $bottomRightBanners->url ?>"><img src="<?= Yii::getAlias('@web/uploads/images/') . ($bottomRightBanners->image ?? '') ?>" alt=""  class="img-fluid slider-section-img"></a></div>
                        <div class="col-lg-6 d-none d-lg-block pl-0 pr-2 pt-3"><a href="<?= $bottomLeftBanners->url ?>"><img src="<?= Yii::getAlias('@web/uploads/images/') . ($bottomLeftBanners->image ?? '') ?>" alt=""  class="img-fluid slider-section-img"></a></div>
                    </div>
                    
                </div>
                <div class="col-lg-4 col-12  px-0 px-sm-2">
                    <div class="row pt-md-3 pt-lg-0">
                        <a href="<?= $leftTopBanners->url ?>" class=" col-lg-12 d-none d-lg-block"><img src="<?= Yii::getAlias('@web/uploads/images/') . ($leftTopBanners->image ?? '') ?>" alt="" class="img-fluid"></a> 
                        <a href="<?= $leftBottomBanners->url ?>" class="col-lg-12 col-6 mt-lg-3 mt-3 mt-md-0"><img src="<?= Yii::getAlias('@web/uploads/images/') . ($leftBottomBanners->image ?? '') ?>" alt="" class="img-fluid img-big" ></a> 
                        <a href="<?= $leftBottomBanners->url ?>" class="col-6 slider-section-img d-lg-none mt-3 mt-md-0"><img src="<?= Yii::getAlias('@web/uploads/images/') . ($leftBottomBanners->image ?? '') ?>" alt="" class="img-fluid" ></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>



    <section id="offer-section">
        
        <div class="container px-sm-2">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 text-center px-4 px-sm-0 ">

                    <div class="offer-section-right h-100">
                        <img src="<?= Yii::getAlias('@web/img/index.svg/') ?>" alt="" class="img-fluid">
                        <img src="<?= Yii::getAlias('@web/img/special-offer-title.af8fd0e.png/') ?>" class="img-fluid pt-2 pt-md-0 " alt="">
                        
                        <span class="offer-section-right-title p-2 p-md-1 "><p>تخفیف فقط برای امروز</p></span>
                        <div class="timer py-2 ">
                            <span id="Timer"></span>
                            <span><i class="far fa-clock"></i></span>
                            
                        </div>
                        
                        <button type="button" class="btn btn-outline-light mb-lg-2 mb-md-1 offer-button"> مشاهده همه <i class="fas fa-arrow-left"></i></button>
                    </div>
                    
                </div>

                <div class="col-xl-10 col-lg-9 col-md-9 col-sm-9 px-4">
                    <div id="first-slider" class="owl-carousel owl-theme">

                        <?php foreach ($specials as $key => $special) { ?>
                        
                        <div class="item">
                            <a href="#">
                                <div class="offer-item text-center">
                                    <img src="<?= Yii::getAlias('@web/uploads/images/') . ($special->image ?? '') ?>" class="img-fluid" alt="">
                                    <div class="img-caption">
                                    <p ><?= $special->name ?></p>
                                    <span class="percent-off"><?= $special->discountAmounts->percentage ?>%</span>
                                        <?php 
                                            $price = $special->price;
                                            $discount =($price / 100) * ($special->discountAmounts->percentage);
                                            $finalyPrice = $discount > $special->discountAmounts->discount_ceiling ? 
                                            $price - $special->discountAmounts->discount_ceiling
                                            : $price - $discount;

                                        ?>
                                    <span class="price-befor">
                                         <?= $price ?>
                                    </span>
                                    <span class="price-after"> تومان 
                                         <?= $finalyPrice ?>
                                    </span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <?php } ?>
                        
                        
                    </div>

                </div>
            </div>
        </div>
        

    </section>

    <section id="small-slider">
        <div class="container">
            <div class="row px-3 px-sm-0">
               <div class="small-slider-big col-lg-12">
                <h3 dir="rtl">محصولات جدید</h3>

                <div class="visited-slider">
                    <div class="owl-carousel owl-theme second-slider" >
                        <?php foreach ($newProducts as $key => $newProduct) { ?>
                            <div class="item" >
                                <a href="#" class="d-block text-center">
                                    <img src="<?= Yii::getAlias('@web/uploads/images/') . ($newProduct->image ?? '') ?>" alt="">
                                    <div class="item-caption">
                                        <p><?= $newProduct->name ?></p>
                                        <div class="item-caption-bottom">
                                            
                                            <span class="price">6,250,000</span>
                                            <span class="unit">تومان</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
               </div>

            </div>
        </div>
    </section>

    <section id="box">
        <div class="container px-sm-0">
            <div class="row overflow-hidden">
                <?php foreach($fourMiddleBanners as $index => $fourMiddleBanner) { ?>
                    <a href="<?= $fourMiddleBanner->url ?>" class="col-md-3 col-sm-6 col-12 mt-3 mt-md-0 <?= $index < 2 ? 'd-none d-md-block': '' ?>"><img src="<?= Yii::getAlias('@web/uploads/images/') . ($fourMiddleBanner->image ?? '') ?>" alt="" class="img-fluid "></a>
                <?php }?>

            </div>
        </div>
    </section>

    <div class="clearfix"></div>

    <section id="small-slider">
            <div class="container">
                <div class="row px-3  px-sm-0">
                   <div class="small-slider-big col-lg-12 col-md-12"  >
                    <h3 dir="rtl">پرفروش ترین ها</h3>
    
                    <div class="visited-slider">
                        <div class="owl-carousel owl-theme second-slider" >
                        <?php foreach ($bestsellers as $key => $bestseller) { ?>
                            <div class="item" >
                                <a href="#" class="d-block text-center">
                                    <img src="<?= Yii::getAlias('@web/uploads/images/') . ($bestseller->image ?? '') ?>" alt="">
                                    <div class="item-caption">
                                        <p><?= $bestseller->name ?></p>
                                        <div class="item-caption-bottom">
                                            <span class="price"><?= $bestseller->price ?></span>
                                            <span class="unit">تومان</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                   </div>
    
                </div>
            </div>
        </section>


    <section id="pic-big" >
        <div class="container ">
            <div class="row overflow-hidden">
                <?php foreach ($twoMiddleBanners as $key => $twoMiddleBanner) { ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 <?= $key === 0 ? 'pr-sm-0' : 'pl-sm-0' ?> ">
                    <a href="#"><img src="<?= Yii::getAlias('@web/uploads/images/') . ($twoMiddleBanner->image ?? '') ?>" alt="" class="img-fluid <?= $key === 0 ? 'pt-sm-0' : '' ?>"></a>
                </div>

                <?php } ?>
            </div>
        </div>
    </section>

    <section id="small-slider-product">
        <div class="container">
            <div class="row px-3  px-sm-0">
                <div class="small-slider-product col-lg-12 text-right  ">
                    <div class="small-slider-product-top d-flex justify-content-between">
                        <div class="small-slider-product-right ">
                            <h3 dir="rtl"><?= $categories_notchilren[0]->name ?></h3>
                        </div>
                        <div class="small-slider-product-left align-content-end mt-4">
                                <a href="#" >مشاهده لیست کامل
                                <i class="fas fa-chevron-left mr-2"></i>
                                </a> 
                        </div>
                    </div>

                    <div class="small-slider-product-cntent">

                        <div class="owl-carousel owl-theme second-slider" >
                            <?php foreach ($productsCategory1 as $key => $productCategory1) { ?>
                                    <div class="item" >
                                        <a href="#" class="d-block text-center">
                                            <img src="<?= Yii::getAlias('@web/uploads/images/') . ($productCategory1->image ?? '') ?>" alt="">
                                            <div class="item-caption">
                                                <p><?= $productCategory1->name ?></p>
                                                <div class="item-caption-bottom">
                                                    <span class="price"><?= $productCategory1->price ?></span>
                                                    <span class="unit">تومان</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                                </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section id="baner" class="d-none d-md-block">
        <div class="container">
            <div class="row overflow-hidden">
                <img src="<?= Yii::getAlias('@web/uploads/images/') . ($OneLastBanner->image ?? '') ?>" alt="" class="img-fluid">
            </div>
        </div>
    </section>

    <section id="small-slider-product">
        <div class="container">
            <div class="row px-3  px-sm-0">
                <div class="small-slider-product col-lg-12 text-right ">
                    <div class="small-slider-product-top d-flex justify-content-between">
                        <div class="small-slider-product-right ">
                            <h3 dir="rtl"> پربازدیدترین</h3>
                        </div>
                        <div class="small-slider-product-left align-content-end mt-4">
                                <a href="#" >مشاهده لیست کامل
                                <i class="fas fa-chevron-left mr-2"></i>
                                </a> 
                        </div>
                    </div>

                    <div class="small-slider-product-cntent">

                                <div class="owl-carousel owl-theme second-slider" >
                                    <?php foreach ($mostVieweds as $key => $mostViewed) {?>
                                    
                                        <div class="item" >
                                            <a href="#" class="d-block text-center">
                                                <img src="<?= Yii::getAlias('@web/uploads/images/') . ($mostViewed->image ?? '') ?>" alt="">
                                                <div class="item-caption">
                                                    <p><?= $mostViewed->name ?></p>
                                                    <div class="item-caption-bottom">
                                                        <span class="price"><?= $mostViewed->price ?></span>
                                                        <span class="unit">تومان</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                    <?php } ?> 
                                </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="blog">
        <div class="container">
            <div class="row overflow-hidden">
                <div class="d-none d-sm-block blog-item col-lg-2 col-md-4 col-sm-4 px-1">
                    <div class="blog-item2">
                        <img src="<?= Yii::getAlias('@web/img/blog1.jpg/') ?>" alt="" class="small-pic img-fluid">
                        <div class="blog-caption col-lg-12 py-2 text-center">
                            <h5>عنوان مقاله</h5>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است    
                                 </p>
                            <a href="#" >خواندن این مقاله</a>
                        </div>
                    </div>
                </div>
                <div class="d-lg-none d-none d-sm-block blog-item col-lg-2 col-md-4 col-sm-4 col-12 px-1">
                    <div class="blog-item2">
                        <img src="<?= Yii::getAlias('@web/img/blog1.jpg/') ?>" alt="" class="small-pic img-fluid">
                        <div class="blog-caption col-lg-12 py-2 text-center">
                            <h5>عنوان مقاله</h5>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است    
                                 </p>
                            <a href="#" >خواندن این مقاله</a>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-block d-lg-none blog-item col-lg-2 col-md-4 col-sm-4 col-12 px-1">
                    <div class="blog-item2">
                        <img src="<?= Yii::getAlias('@web/img/blog1.jpg/') ?>" alt="" class="small-pic img-fluid">
                        <div class="blog-caption col-lg-12 py-2 text-center">
                            <h5>عنوان مقاله</h5>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است    
                                 </p>
                            <a href="#" >خواندن این مقاله</a>
                        </div>
                    </div>
                </div>
                <div class="blog-item col-lg-2  px-2 ">
                    <div class="row d-block d-sm-none d-lg-flex">
                        <div class="col-lg-12  col-12 w-100 ">
                            <div class="blog-item2 ">
                                <img src="<?= Yii::getAlias('@web/img/blog2.jpg/') ?>" alt="" class="small-pic img-fluid w-100 ">
                                <div class="blog-caption col-lg-12 py-2 text-center">
                                    <h5>عنوان مقاله</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده 
                                
                                    </p>
                                    <a href="#" >مشاهده مقاله</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-12 pt-2 ">
                            <div class="blog-item2 ">
                                <img src="<?= Yii::getAlias('@web/img/blog3.jpg/') ?>" alt="" class="small-pic img-fluid w-100">
                                <div class="blog-caption  col-lg-12 py-2 text-center">
                                    <h5>عنوان مقاله</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده 
                                        </p>
                                    <a href="#" >خواندن این مقاله</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="blog-item col-lg-4 col-md-12  col-12 px-2  py-sm-2 pt-2 p-lg-0">
                    <div class="blog-item2">
                        <img src="<?= Yii::getAlias('@web/img/blog4.jpg/') ?>" alt="" class="big-pic img-fluid w-100">
                        <div class="blog-caption col-12 py-2 text-center">
                            <h5>عنوان مقاله</h5>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است    
                                 </p>
                            <a href="#" >خواندن این مقاله</a>
                        </div>
                    </div>
                   
                </div>
                <div class="blog-item col-lg-2 col-12 px-1 ">
                    <div class="row d-none d-lg-flex">
                        <div class="col-lg-12 col-12 ">
                            <div class="blog-item2 ">
                                <img src="<?= Yii::getAlias('@web/img/blog5.jpg/') ?>" alt="" class="img-fluid ">
                                <div class="blog-caption col-12 py-2 text-center">
                                    <h5>عنوان مقاله</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده 
                                
                                    </p>
                                    <a href="#" >خواندن این مقاله</a>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-12 col-12 pt-2 ">
                           <div class="blog-item2 h-100">
                                <img src="<?= Yii::getAlias('@web/img/blog6.jpg/') ?>" alt="" class="img-fluid ">
                                <div class="blog-caption col-12 py-2 text-center">
                                    <h5>عنوان مقاله</h5>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده 
                                
                                    </p>
                                    <a href="#" >خواندن این مقاله</a>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-block blog-item col-lg-2 col-md-4  col-sm-4 px-1">
                   <div class="blog-item2">
                        <img src="<?= Yii::getAlias('@web/img/blog7.jpg/') ?>" alt="" class="big-pic img-fluid">
                        <div class="blog-caption col-12 py-2 text-center">
                            <h5>عنوان مقاله</h5>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        
                            </p>
                            <a href="#" >خواندن این مقاله</a>
                        </div>
                   </div>
                </div>
                <div class="d-none d-sm-block d-lg-none blog-item col-lg-2 col-md-4  col-sm-4 px-1">
                    <div class="blog-item2">
                         <img src="<?= Yii::getAlias('@web/img/blog7.jpg/') ?>" alt="" class="big-pic img-fluid">
                         <div class="blog-caption col-12 py-2 text-center">
                             <h5>عنوان مقاله</h5>
                             <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                         
                             </p>
                             <a href="#" >خواندن این مقاله</a>
                         </div>
                    </div>
                 </div>
                 <div class="d-none d-sm-block d-lg-none blog-item col-lg-2 col-md-4  col-sm-4 px-1">
                    <div class="blog-item2">
                         <img src="<?= Yii::getAlias('@web/img/blog7.jpg/') ?>" alt="" class="big-pic img-fluid">
                         <div class="blog-caption col-12 py-2 text-center">
                             <h5>عنوان مقاله</h5>
                             <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                         
                             </p>
                             <a href="#" >خواندن این مقاله</a>
                         </div>
                    </div>
                 </div>
            </div>

    </section>

    <section id="footer-above">
        <div class="row text-center ">
            <div class="col-8 col-sm-8 col-lg-5 mx-auto" >
                <h4>برای اطلاع از آخرین تخفیف ها  و جدیدترین کالاها عضو شوید</h4>
                <form action="" method="get" class="d-flex pb-4 justify-content-center" >
                    <input type="email" class="my-auto" placeholder="عضویت در خبرنامه">
                    <button type="submit" name="send" class="my-auto">عضویت</button>
                </form>
            </div> 
        </div>
    </section>