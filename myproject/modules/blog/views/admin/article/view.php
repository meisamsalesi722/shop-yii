<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Article $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('updateArticle')): ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif;
          if (Yii::$app->user->can('deleteArticle')): ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'blog_category_id',
            'title',
            'slug',
            'summary:ntext',
            'content:ntext',
        [
            'attribute' => 'image',
            'format' => 'html',
            'value' => function($model) {
                if ($model->image) {
                    return Html::img(
                        Yii::getAlias('@web/uploads/images/') . $model->image,
                        [
                            'class' => 'rounded-circle',
                            'style' => 'width: 100px; height: 100px; object-fit: cover;',
                            'alt' => $model->title
                        ]
                    );
                }
                return '<span class="text-muted">بدون تصویر</span>';
            },
        ],
            [
            'attribute' => 'pdf',
            'format' => 'html',
            'value' => function($model) {
                if ($model->pdf) {
                    return Html::a(
                        '📄 مشاهده PDF',
                        Yii::getAlias('@web/uploads/pdf/') . $model->pdf,
                        [
                            'target' => '_blank',
                            'class' => 'btn btn-sm btn-primary'
                        ]
                    );
                }
                return '<span class="text-muted">بدون فایل PDF</span>';
            },
        ],
            'status',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y/m/d - H:i'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y/m/d - H:i'],
            ],
        ],
    ]) ?>

</div>
