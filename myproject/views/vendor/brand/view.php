<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Brand $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="brand-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'original_name',
            'persian_name',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status == 1 ? 'فعال' : 'غیر فعال';
                }
            ],
            'slug',
            [
                'attribute' => 'logo',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/') . ($model->logo ?? '') .'" alt="" style="max-width:100px;">';
                }
            ],
           
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
