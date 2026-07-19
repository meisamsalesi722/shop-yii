<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!-- سایدبار -->
<aside class="admin-sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="<?= Yii::$app->homeUrl ?>">
            <i class="fas fa-crown"></i>
            <span>Admin Panel</span>
        </a>
        <small>مدیریت سیستم</small>
    </div>

    <?php
$currentRoute = Yii::$app->controller->getRoute();
?>
    <ul class="sidebar-menu">
        <li class="menu-label">داشبورد</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-chart-pie"></i> داشبورد',
                Url::to(['/admin/dashboard']),
                ['class' => $currentRoute === 'admin/dashboard/index' ? 'active' : '']
            ) ?>
        </li>

        <li class="menu-label">مدیریت محتوا</li>
               <li>
            <?= Html::a(
                '<i class="fas fa-newspaper"></i> برند ها',
                Url::to(['admin/brand/index']),
                ['class' => $currentRoute === 'admin/brand/index' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> دسته بندی',
                Url::to(['admin/category/index']),
                ['class' => $currentRoute === 'admin/category/index' ? 'active' : '']
            ) ?>
        </li>


        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> گارانتی ها',
                Url::to(['admin/guarantee/index']),
                ['class' => $currentRoute === 'admin/guarantee/index' ? 'active' : '']
            ) ?>
        </li>
            <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> بنر ها',
                Url::to(['admin/banner/index']),
                ['class' => $currentRoute === 'admin/banner/index' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-newspaper"></i> ادرس ها',
                Url::to(['admin/address/index']),
                ['class' => $currentRoute === 'admin/address/index' ? 'active' : '']
            ) ?>
        </li>

        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> کامنت ها',
                Url::to(['admin/comment/index']),
                ['class' => $currentRoute === 'admin/comment/index' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> تیکت ها',
                Url::to(['admin/ticket/index']),
                ['class' => $currentRoute === 'admin/ticket/index' ? 'active' : '']
            ) ?>
        </li>

        
        <li class="menu-label">فروشگاه</li>
        
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> سفارشات',
                Url::to(['admin/order/index']),
                ['class' => $currentRoute === 'admin/order/index' ? 'active' : '']
                ) ?>
        </li>
        <!-- -------------------- -->
        
        <li>
            <?= Html::a(
                '<i class="fas fa-user-tag"></i>  محصولات',
                Url::to( ['/admin/product/index']),
                ['class' =>$currentRoute === 'admin/product/index' ? 'active' : '']
                ) ?>
        </li>
        
        <li class="menu-label">تخفیف ها</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> تخفیف ها',
                Url::to(['admin/discount-amount/index']),
                ['class' => $currentRoute === 'admin/discount-amount/index' ? 'active' : '']
            ) ?>
        </li>

        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> کوپن',
                Url::to(['admin/copan/index']),
                ['class' => $currentRoute === 'admin/copan/index' ? 'active' : '']
            ) ?>
        </li>







        <!-- -------------------- -->

    </ul>

    

    <!-- دکمه تغییر تم در سایدبار -->
    <div class="theme-toggle-sidebar" id="themeToggleSidebar">
        <span class="toggle-label">
            <i class="fas fa-moon" id="themeIconSidebar"></i>
            <span id="themeTextSidebar">لایت مود</span>
        </span>
        <span class="toggle-switch"></span>
    </div>
</aside>