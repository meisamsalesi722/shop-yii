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

    <ul class="sidebar-menu">
        <li class="menu-label">داشبورد</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-chart-pie"></i> داشبورد',
                Url::to(['/blog/admin/dashboard']),
                ['class' => Yii::$app->controller->id === 'site' ? 'active' : '']
            ) ?>
        </li>

        <li class="menu-label">مدیریت محتوا</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-newspaper"></i> مقالات',
                Url::to(['/blog/admin/article/index']),
                ['class' => Yii::$app->controller->id === 'article' ? 'active' : '']
            ) ?>
        </li>
        <li class="menu-label">علاقه‌مندی‌ها</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-newspaper"></i> علاقه مندی ها',
                Url::to(['/blog/admin/favorite/index']),
                // ['class' => Yii::$app->controller->id === 'article' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-tags"></i> دسته‌بندی‌ها',
                Url::to(['/blog/admin/blog-category/index']),
                ['class' => Yii::$app->controller->id === 'blog-category' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-comments"></i> نظرات',
                Url::to(['/blog/admin/comment/index']),
                ['class' => Yii::$app->controller->id === 'comment' ? 'active' : '']
            ) ?>
        </li>
        <!-- -------------------- -->
        
        <li class="menu-label">مدیریت دسترسی</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-user-tag"></i> نقش‌ها',
                Url::to( ['/blog/admin/rbac/index']),
                ['class' => Yii::$app->controller->id === 'user' ? 'active' : '']
                ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-user-cog"></i> تخصیص نقش',
                Url::to( ['/blog/admin/rbac/assign']),
                ['class' => Yii::$app->controller->id === 'user' ? 'active' : '']
            ) ?>
        </li>
        <li>
            <?= Html::a(
                '<i class="fas fa-users"></i> مدیریت کاربران',
                Url::to( ['/blog/admin/user/index']),
                ['class' => Yii::$app->controller->id === 'user' ? 'active' : '']
            ) ?>
        </li>
        
        <!-- -------------------- -->
        <li class="menu-label">تنظیمات</li>
        <li>
            <?= Html::a(
                '<i class="fas fa-cog"></i> تنظیمات',
                Url::to(['/blog/admin/settings/index']),
                ['class' => Yii::$app->controller->id === 'settings' ? 'active' : '']
            ) ?>
        </li>
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