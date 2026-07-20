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
                '<i class="fas fa-store"></i> داشبورد فروشگاه',
                Url::to(['/admin/dashboard/index']),
                ['class' => $currentRoute == 'admin/dashboard/index' ? 'active' : '']
            ) ;  ?>
        </li>

        <li>
            <?= Html::a(
                '<i class="fas fa-blog"></i> داشبورد وبلاگ',
                Url::to(['/blog/admin/dashboard/index']),
                ['class' => str_contains($currentRoute , 'blog/admin/dashboard') ? 'active' : '']
            ) ?>
        </li>

        <li class="menu-label"> مدیریت محتوا فروشگاه</li>
               <li>
            <?= Html::a(
                '<i class="fas fa-tag"></i> برند ها',
                Url::to(['/admin/brand/index']),
                ['class' => str_contains($currentRoute , 'admin/brand') ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-sitemap"></i> دسته بندی',
                Url::to(['/admin/category/index']),
                ['class' => str_contains($currentRoute , 'admin/category') ? 'active' : '']
            ) ?>
        </li>


        <li>
            <?= Html::a(
                '<i class="fas fa-shield-alt"></i> گارانتی ها',
                Url::to(['/admin/guarantee/index']),
                ['class' => str_contains($currentRoute , 'admin/guarantee') ? 'active' : '']
            ) ?>
        </li>
            <li>
            <?= Html::a(
                '<i class="fas fa-images"></i> بنر ها',
                Url::to(['/admin/banner/index']),
                ['class' => str_contains($currentRoute , 'admin/banner') ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-map-marker-alt"></i> ادرس ها',
                Url::to(['/admin/address/index']),
                ['class' => str_contains($currentRoute , 'admin/address') ? 'active' : '']
            ) ?>
        </li>

        <li>
            <?= Html::a(
                '<i class="fas fa-comment-dots"></i> کامنت ها',
                Url::to(['/admin/comment/index']),
                ['class' => str_contains($currentRoute , 'admin/comment') ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-ticket-alt"></i> تیکت ها',
                Url::to(['/admin/ticket/index']),
                ['class' => str_contains($currentRoute , 'admin/ticket') ? 'active' : '']
            ) ?>
        </li>
        
        <li class="menu-label">فروشگاه</li>
        
        <li>
            <?= Html::a(
                '<i class="fas fa-shopping-cart"></i> سفارشات',
                Url::to(['/admin/order/index']),
                ['class' => str_contains($currentRoute , 'admin/order') ? 'active' : '']
                ) ?>
        </li>
        <!-- -------------------- -->
        
        <li>
            <?= Html::a(
                '<i class="fas fa-boxes"></i>  محصولات',
                Url::to( ['/admin/product/index']),
                ['class' => str_contains($currentRoute , 'admin/product') ? 'active' : '']
                ) ?>
        </li>
        
        <li class="menu-label">تخفیف ها</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-percent"></i> تخفیف ها',
                Url::to(['/admin/discount-amount/index']),
                ['class' => str_contains($currentRoute , 'admin/discount-amount') ? 'active' : '']
            ) ?>
        </li>

        <li>
            <?= Html::a(
                '<i class="fas fa-gift"></i> کوپن',
                Url::to(['/admin/copan/index']),
                ['class' => str_contains($currentRoute , 'admin/copan') ? 'active' : '']
            ) ?>
        </li>


                <li class="menu-label">وبلاگ</li>

        <li>
            <?= Html::a(
                '<i class="fas fa-file-alt"></i> مقالات',
                Url::to(['/blog/admin/article/index']),
                ['class' => str_contains($currentRoute , 'blog/admin/article') ? 'active' : '']
            ) ?>
        </li>
        <li class="menu-label">علاقه‌مندی‌ها</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-heart"></i> علاقه مندی ها',
                Url::to(['/blog/admin/favorite/index']),
                ['class' => str_contains($currentRoute , 'blog/admin/favorite') ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-folder-tree"></i> دسته‌بندی‌های مقاله',
                Url::to(['/blog/admin/blog-category/index']),
                ['class' => str_contains($currentRoute , 'blog/admin/blog-category') ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comment-medical"></i> نظرات مقاله',
                Url::to(['/blog/admin/comment-blog/index']),
                ['class' => str_contains($currentRoute , 'blog/admin/comment-blog') ? 'active' : '']
            ) ?>
        </li>
        <!-- -------------------- -->
        
        <li class="menu-label">مدیریت دسترسی</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-user-shield"></i> نقش‌ها',
                Url::to( ['/blog/admin/rbac/index']),
                ['class' => str_contains($currentRoute , 'blog/admin/rbac') ? 'active' : '']
                ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-user-plus"></i> تخصیص نقش',
                Url::to( ['/blog/admin/rbac/assign']),
                ['class' => str_contains($currentRoute , 'blog/admin/rbac/assign') ? 'active' : '']
            ) ?>
        </li>







        <!-- -------------------- -->

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