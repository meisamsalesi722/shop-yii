<?php

use app\models\CategoryAttribute;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CategoryAttributeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Category Attributes';

$this->params['breadcrumbs'][] = ['label' => ' / Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-attribute-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category Attribute', ['admin/category/attribute-create' , 'category_id' => $category_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'category',
                'value' => 'category.name'
            ],
            'name',
            'unit',
            'value',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CategoryAttribute $model, $key, $index, $column) use($category_id) {
                    return Url::toRoute([ 'admin/category/attribute-' . $action, 'id' => $model->id , 'category_id' => $category_id]);
                 }
            ],
        ],
    ]); ?>


</div>
