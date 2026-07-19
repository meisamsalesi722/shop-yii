<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\PanelAsset;

PanelAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="en">


 <head>
     <?php $this->head() ?>
 </head>

<body>
<?php $this->beginBody() ?>

        <!-- فلش‌ها -->
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?= Yii::$app->session->getFlash('warning') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>


<?= $this->render('../_header') ?>

    <section id="profile-page">
        <div class="container">
            <div class="position-relative">
                <div class="row">

                    <div class="col-xl-3 col-lg-4">
                        <?= $this->render('_side-bar') ?>
                    </div>
                    <div class="col-xl-9 col-lg-8 mt-3 mt-lg-0">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->render('../_footer') ?>

<div class="black-menu"></div>
<?= $this->render('../_menu') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
