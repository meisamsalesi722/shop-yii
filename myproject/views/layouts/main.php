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

<?= $this->render('_header') ?>

       <?= $content ?>

<?= $this->render('_footer') ?>

<div class="black-menu"></div>
<?= $this->render('_menu') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
