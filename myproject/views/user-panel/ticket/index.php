<?php

use app\models\Ticket;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

?>

<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                <li class="breadcrumb-item active" aria-current="page">تیکت ها</li>
            </ol>
        </nav>
    </div>
    <div class="content-in">
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= Html::a('تیکت جدید' , '/userpanel/ticket/create' , [
        'class' => 'btn btn-success m-3 mb-4'
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'subject',
            [
                'attribute' => 'وضعیت',
                'value' => 'StatusText'  
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, Ticket $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
    </div>
