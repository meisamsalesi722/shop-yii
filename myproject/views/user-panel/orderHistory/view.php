<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to('/userpanel/order-history/') ?>">تاریخچه سفارشات</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $model->id ?></li>
            </ol>
        </nav>
    </div>
    <div class="content-in">
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= $this->render('/user-panel/orderHistory/_print' , ['model' => $model]);?>
    <?php if($model->payment_status == 0){ ?>
        <?= HTML::a('پرداخت مجدد' ,['/payment/payment-submit' ,'order_id' => $model->id] , ['class' => 'btn btn-warning']) ;?>
    <?php }?>


<?= Html::a('print', ['print-tcpdf', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

</div>
</div>
