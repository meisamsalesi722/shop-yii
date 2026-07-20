<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\FrontendAsset;

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="en">


 <head>
     <?php $this->head() ?>
 </head>

<body>
<?php $this->beginBody() ?>

<?php //$this->render('_alerts');?>


<?= $this->render('_header') ?>


        <!-- فلش‌ها -->
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="w-75 m-3 mx-auto">
            <div class="alert alert-success alert-dismissible d-flex justify-content-around align-items-center fade show" role="alert">
                <div>
                    <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"><i class="fa fa-times"></i></button>
            </div>
            </div>

            <?php endif; ?>


        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="w-75 m-3 mx-auto">
            <div class="alert alert-danger alert-dismissible d-flex justify-content-around align-items-center fade show" role="alert">
                <div>
                    <i class="fas fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"><i class="fa fa-times"></i></button>
            </div>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('warning')): ?>
            <div class="w-75 m-3 mx-auto">
            <div class="alert alert-warning alert-dismissible d-flex justify-content-around align-items-center fade show" role="alert">
                <div>
                    <i class="fas fa-exclamation-triangle"></i> <?= Yii::$app->session->getFlash('warning') ?>
                </div>
                <button type="button" class="btn" data-bs-dismiss="alert"><i class="fa fa-times"></i></button>
            </div>
            </div>
        <?php endif; ?>


        
        <?= $content ?>
        
<?= $this->render('_footer') ?>

<div class="black-menu"></div>
<?= $this->render('_menu') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
