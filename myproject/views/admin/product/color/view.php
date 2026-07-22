<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Color $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => ' / product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Colors', 'url' => ['color-index' , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="color-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['color-update', 'product_id' => $product_id , 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['color-delete', 'product_id' => $product_id , 'id' => $model->id], [
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
            'name',
            'color_code',
            'price_increase',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
