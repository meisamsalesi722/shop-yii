<?php

use app\models\Color;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ColorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Colors';
$this->params['breadcrumbs'][] = ['label' => ' / product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="color-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Color', ['color-create' , 'product_id' => $product_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'color_code',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Color $model, $key, $index, $column) use($product_id) {
                    return Url::toRoute([ 'color-' .$action, 'product_id' => $product_id , 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
