<?php 
use yii\helpers\Url;
use app\models\Order;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
?>
<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                <li class="breadcrumb-item active" aria-current="page">تاریخچه سفارشات</li>
            </ol>
        </nav>
    </div>
    <div class="content-in">
        <div class="order-index">
            

            <h1><?= Html::encode($this->title) ?></h1>


            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


            <?= GridView::widget([
                'layout' => "{items}\n{pager}",
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'آدرس',
                        'value' => function($model){
                            return substr($model->address->address , 0  ,50);
                        }
                    ],
                    [
                        'attribute' => 'وضعیت پرداخت',
                        'value' => function($model){
                            return $model->payment_status == 0 ? 'پرداخت نشده' : 'پرداخت شده';
                        }
                    ],
                    [
                        'attribute' => 'قیمت محصول',
                        'value' => function($model){
                            return $model->original_price . ' تومان';
                        }
                    ],
                     [
                        'attribute' => 'مبلغ نهایی کسر شده',
                        'value' => function($model){
                            return $model->order_total_products_discount_amount . ' تومان';
                        }
                    ],
                    [
                        'attribute' => 'قیمت نهایی محصول',
                        'value' => function($model){
                            return $model->order_final_amount . ' تومان';
                        }
                    ],
                   


                    [
                    'class' => ActionColumn::class,
                        'template' => '{view} {orderItem} {payment}',
                        'buttons' => [
                            'orderItem' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fas fa-clipboard-list"></i>',
                                    ['userpanel/order-history/order-item', 'order_id' => $model->id]
                                );
                            },
                            'payment' => function ($url, $model, $key) {
                                if($model->payment_status == 0){
                                return Html::a(
                                    '<i class="fas fa-credit-card"></i>',
                                    ['/payment/payment-submit', 'order_id' => $model->id]
                                );
                                }
                            },
                        ],
                        'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                            return Url::toRoute([ 'userpanel/order-history/' . $action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>


        </div>
</div>
</div>