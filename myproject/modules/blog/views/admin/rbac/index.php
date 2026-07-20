<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'مدیریت نقش‌ها';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rbac-index">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-primary text-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-user-shield"></i> <?= $this->title ?>
                </h4>
                <div>
                    <?= Html::a(
                        '<i class="fas fa-plus"></i> نقش جدید',
                        ['create-role'],
                        ['class' => 'btn btn-light btn-sm']
                    ) ?>
                    <?= Html::a(
                        '<i class="fas fa-user-cog"></i> تخصیص نقش',
                        ['assign'],
                        ['class' => 'btn btn-light btn-sm']
                    ) ?>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4">
            <?php Pjax::begin() ?>
            
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    
                    [
                        'attribute' => 'name',
                        'label' => 'نام نقش',
                        'format' => 'raw',
                        'value' => function($model) {
                            return '<span class="badge bg-primary">' . Html::encode($model->name) . '</span>';
                        },
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'توضیحات',
                        'value' => function($model) {
                            return $model->description ?? 'بدون توضیحات';
                        },
                    ],
                    [
                        'attribute' => 'createdAt',
                        'label' => 'تاریخ ایجاد',
                        'value' => function($model) {
                            return $model->createdAt ? date('Y/m/d H:i', $model->createdAt) : '-';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'عملیات',
                        'template' => '{update} {delete} {view}',
                        'buttons' => [
                            'update' => function($url, $model) {
                                return Html::a(
                                    '<i class="fas fa-edit"></i>',
                                    ['update-role', 'name' => $model->name],
                                    ['class' => 'btn btn-sm btn-primary']
                                );
                            },
                            'delete' => function($url, $model) {
                                return Html::a(
                                    '<i class="fas fa-trash"></i>',
                                    ['delete-role', 'name' => $model->name],
                                    [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-confirm' => 'آیا از حذف این نقش مطمئن هستید؟',
                                        'data-method' => 'post',
                                    ]
                                );
                            },
                            'view' => function($url, $model) {
                                return Html::a(
                                    '<i class="fas fa-eye"></i>',
                                    ['view-role', 'name' => $model->name],
                                    [
                                        'class' => 'btn btn-sm btn-warning',
                                        'data-method' => 'post',
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]) ?>
            
            <?php Pjax::end() ?>
        </div>
    </div>
</div>