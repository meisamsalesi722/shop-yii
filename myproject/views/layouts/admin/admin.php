<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" dir="rtl" data-bs-theme="light" id="html-theme">
 <?= $this->render('_head') ?>
<body>
<?php $this->beginBody() ?>

<?= $this->render('_sidebar') ?>

<!-- اوورلی برای موبایل -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- محتوای اصلی -->
<div class="admin-content">

<?= $this->render('_header') ?>

    <!-- بدنه -->
    <div class="admin-body">
        <!-- بریدکرامب -->
        <?php if (isset($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
                'options' => ['class' => 'admin-breadcrumb breadcrumb'],
                'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>",
                'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>",
            ]) ?>
        <?php endif; ?>


        <!-- فلش‌ها -->
        <?php if (Yii::$app->session->hasFlash('success')): ?>

            <?= $this->render('//layouts/errors/toast/success') ?>

        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>

            <?= $this->render('//layouts/errors/toast/error') ?>

        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('warning')): ?>

            <?= $this->render('//layouts/errors/toast/warning') ?>

        <?php endif; ?>

        <!-- محتوای اصلی -->
        <div class="fade-in">
            <?= $content ?>
        </div>
    </div>
</div>


<?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>