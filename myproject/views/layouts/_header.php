<?php
// use Yii;

use app\models\CartItem;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Category;
use yii\widgets\ActiveForm;

?>
    <div class="top-menu">
        <section id="header-section" class="">
            <div class="container">
                <div class="row d-flex">
                    <div class="logo col-lg-1 col-md-1 col-sm-2 col-2 text-right ">
                        <a href="<?= Url::to('/') ?>"><img src="<?= Yii::getAlias('@web/') ?>img/webeto_logo.png" alt="" class="img-fluid"></a>
                    </div>
                    
                        <div class="col-lg-6 col-md-6 col-sm-8 col-8 search-top">
                            <form action="<?= Url::to(['list/index']) ?>" method="get" class="d-flex  justify-content-between">
                                <input type="text" name="send"  value="<?= Yii::$app->request->get('send') ?>" placeholder="جستجوی کالا در محصولات...">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <div class="header-left d-flex col-lg-5 col-md-5 col-sm-12 col-12 justify-content-center align-items-center justify-content-md-end">
                            <?php if(Yii::$app->user->isGuest){
                                ?>  
                                <a href="<?= Url::to('/login-register') ?>">
                                    <span>ورود</span>
                                    <i class="fal fa-user"></i>
                                </a> 
                                <?php }else{?>

                                    <?php ActiveForm::begin([
                                        'action' => '/login-register/logout',
                                        'options' => ['style' => ' background-color: white; border: 0px solid white; !important']
                                    ]) ?>

                                <button type="submit">
                                    <span>خروج</span>
                                    <i class="fal fa-sign-out"></i>
                                </button> 
                                        
                                <?php ActiveForm::end()?>

                                    

                                    <?php }?>
                                    <?php 
                                        $cartItems = count(Yii::$app->user->identity->cartItems ?? []);
                                     ?>
                                <a href="<?= Url::to('/cart-item') ?>">
                                    <span>سبد خرید</span>
                                    <span class="badge badge-secondary" style="font-size: 10px; margin:-30px -10px 0 -3px;"><?= $cartItems ?></span>
                                    <i class="fal fa-shopping-cart"></i>
                                </a>              
                        </div>
                </div>
            </div>
            
        </section>
        <section id="menu" >
            <div class="container justify-content-between bg-white">
                <div class="menu-desktop">
                    <ul>
                    <li>
                        <span class="me-menu">
                            <i class="fal fa-bars"></i>
                            دسته بندی کالا ها
            
                            <div class="body-menu">
                                <div class="in-body-menu">
                                    <div class="first-col">
                                        <nav>
                                            <?php 
                                                    $categories = Category::find()->with('children.children')->where(['parent_id' => null ,'status' => 1])->all();
                                            ?>
                                        <?php foreach ($categories as $key => $category) { ?>

                                            <span class="first-col-span">
                                                <a href="<?= Url::to(['/list/index' , 'categoryId' => $category->id]) ?>" class="link-in-first-col"><?= $category->name ?></a>
                                                <div class="sub-me-menu ">
                                                    
                                                    <div class="in-sub-me-menu  ">
                                                       <?php foreach ($category->children as $key => $children) { ?>
                                                        <div class="three-level ">
                                                            <span class="three-level-span "><a href="<?= Url::to(['/list/index' , 'categoryId' => $children->id]) ?>"><h3><?= $children->name ?></h3></a></span>
                                                            <?php foreach ($children->children as $key => $subchildren) { ?>
                                                                <span class="three-level-span three-level-span-space "><a href="<?= Url::to(['/list/index' , 'categoryId' => $subchildren->id]) ?>" class=""> <?= $subchildren->name ?></a></span>

                                                            <?php } ?>
                                                        </div>
                                                        <?php } ?>
                                                                                                           
                                                </div>
                                                    
                                                </div>
                                                
                                            </span>

                                        <?php } ?>

                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </span>
                    </li>
                    <li>
                        <div class="divider px-0 mx-0" ></div>
                    </li>
                    <!-- <li class="blue-border"><a href="#">تخفیف های امروز</a></li>
                    <li class="blue-border"><a href="#">مجله آنلاین</a></li> -->
                    </ul>
                </div>
                <div class="article">
                    <a href="<?= Url::to(['/blog/blog']) ?>">
                        <i class="far fa-file-alt"></i>
                        <p>مجله لیموناد</p>
                    </a>
                    <?php if(!Yii::$app->user->isGuest){?>
                    <a href="<?= Url::to('/userpanel/user-info') ?>">
                        <i class="far fa-user" style="font-size: 25px;"></i>
                        <p>پروفایل</p>
                    </a>
                    <?php }?>
                </div>

            </div>
        </section>
    </div>
    <div class="header-responsive d-lg-none">
        <div class="container">
            <div class="header-section-responsive ">
                <div class="header-ersponsive-top d-flex px-3 justify-content-between">
                    <div class="header-right-responsive">
                        <div class="menu-icon" onclick="open_menu()">
                            <i class="fal fa-bars my-auto"></i>
                        </div>
                    </div>
                    
                    <div class="my-auto">
                        <a href="#" class=""><img src="img/2بج سه.png" alt="" class="img-fluid "></a>
                    </div>
                    <div class="header-left-responsive d-flex">
                            <?php if(Yii::$app->user->isGuest){?>  
                                <a href="<?= Url::to('/login-register') ?>">
                                    <i class="fal fa-user"></i>
                                </a> 
                                <?php }else{?>

                                    <?php ActiveForm::begin([
                                        'action' => '/login-register/logout',
                                        'options' => ['style' => ' background-color: white; border: 0px solid white; !important']
                                    ]) ?>

                                <button type="submit">
                                    <i class="fal fa-sign-out"></i>
                                </button> 
                                        
                                <?php ActiveForm::end() ; }?>

                            <a href="<?= Url::to('/cart-item') ?>">
                                <i class="fal fa-shopping-cart pl-0"></i>
                            </a>              
                    </div>
                </div>
                <div class="header-responsive-bottom text-center">
                    <form action="<?= Url::to(['list/index']) ?>" method="get"  class="" >
                        <input type="text" name="send" value="<?= Yii::$app->request->get('send') ?>" class="my-auto" placeholder="جستجو در مطالب سایت">
                        <button type="submit" class="my-auto">
                            <i class="fal fa-search my-auto"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>