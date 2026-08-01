<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!-- سایدبار -->
<aside class="admin-sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="<?= Yii::$app->homeUrl ?>">
            <i class="fas fa-crown"></i>
            <span>Vendor Panel</span>
        </a>
        <small>مدیریت سیستم</small>
    </div>

    <?php
$currentRoute = Yii::$app->controller->getRoute();
?>
    <ul class="sidebar-menu">


        <li class="menu-label"> مدیریت محتوا فروشگاه</li>
               <li>
            <?= Html::a(
                '<i class="fas fa-tag"></i> برند ها',
                Url::to(['/vendor/brand/index']),
                ['class' => str_contains($currentRoute , 'vendor/brand') ? 'active' : '']
            ) ?>
        </li>

        
        <li class="menu-label">فروشگاه</li>
        

        <li>
            <?= Html::a(
                '<i class="fas fa-shopping-cart"></i> محصولات شما',
                Url::to(['/vendor/vendor-product/index']),
                ['class' => str_contains($currentRoute , 'vendor/vendor-product/index') ? 'active' : '']
                ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-shopping-cart"></i> سفارشات',
                Url::to(['/vendor/order/index']),
                ['class' => str_contains($currentRoute , 'vendor/order') ? 'active' : '']
                ) ?>
        </li>
        <!-- -------------------- -->
        
        <li>
            <?= Html::a(
                '<i class="fas fa-boxes"></i>  محصولات',
                Url::to( ['/vendor/product/index']),
                ['class' => str_contains($currentRoute , 'vendor/product/index') ? 'active' : '']
                ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-boxes"></i>محصولات در انتظار',
                Url::to( ['/vendor/products-awaiting-approval/index']),
                ['class' => str_contains($currentRoute , 'vendor/products-awaiting-approval/index') ? 'active' : '']
                ) ?>
        </li>



    </ul>

    

    <!-- دکمه تغییر تم در سایدبار -->
    <div class="theme-toggle-sidebar" id="themeToggleSidebar">
        <span class="toggle-label">
            <i class="fas fa-circle-half-stroke" id="themeIconSidebar"></i>
            <span id="themeTextSidebar">لایت مود</span>
        </span>
        <span class="toggle-switch"></span>
    </div>
</aside>