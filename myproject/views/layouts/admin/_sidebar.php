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
                '<i class="fas fa-newspaper"></i> ادرس ها',
                Url::to(['admin/address/index']),
                ['class' => $currentRoute === 'admin/address/index' ? 'active' : '']
            ) ?>
        </li>
        <li class="menu-label">برند ها</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-newspaper"></i> برند ها',
                Url::to(['admin/brand/index']),
                ['class' => $currentRoute === 'admin/brand/index' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-tags"></i> سبد خرید',
                Url::to(['admin/cart-item/index']),
                ['class' => $currentRoute === 'admin/cart-item/index' ? 'active' : '']
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
                '<i class="fas fa-comments"></i> ویژگی های دسته بندی',
                Url::to(['admin/category-attribute/index']),
                ['class' => $currentRoute === 'admin/category-attribute/index' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> رنگ ها',
                Url::to(['admin/color/index']),
                ['class' => $currentRoute === 'admin/color/index' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> گالری محصول',
                Url::to(['admin/gullery/index']),
                ['class' => $currentRoute === 'admin/gullery/index' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> تخفیف ها',
                Url::to(['admin/discount-amount/index']),
                ['class' => $currentRoute === 'admin/discount-amount/index' ? 'active' : '']
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
        <!-- -------------------- -->

        <!-- <li class="menu-label">مدیریت دسترسی</li> -->
        <li>
            <?= Html::a(
                '<i class="fas fa-user-tag"></i>  محصولات',
                Url::to( ['/admin/product/index']),
                ['class' =>$currentRoute === 'admin/product/index' ? 'active' : '']
                ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-user-tag"></i> ویژگی های محصول',
                Url::to( ['/admin/product-meta/index']),
                ['class' =>$currentRoute === 'admin/product-meta/index' ? 'active' : '']
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