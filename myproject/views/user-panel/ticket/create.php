<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to('/userpanel/ticket') ?>">تیکت ها</a></li>
                <li class="breadcrumb-item active" aria-current="page">ایجاد تیکت</li>
            </ol>
        </nav>
    </div>
    <div class="content-in">
<div class="ticket-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
