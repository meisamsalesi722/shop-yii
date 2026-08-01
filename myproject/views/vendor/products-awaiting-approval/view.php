<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($model->user_id == Yii::$app->user->id){ ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php }?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'persian_name',
            'image:ntext',
            'introduction:ntext',
            'slug',
            'category_id',
            'status',
            [
                'attribute' => 'status',
                'value' => function($model){
                    $text = match($model->status){
                        0 => 'در انتظار تایید',
                        1 => 'تایید شده',
                        2 => 'رد شده',
                        default => "نامشخص!",
                    };
                    return $text;
                }
            ],
            'created_at',
            'updated_at',
            'brand_id',
        ],
    ]) ?>

</div>
