<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryAttribute $model */

$this->title = 'Update Category Attribute: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => ' / Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Category Attributes', 'url' => ['admin/category/attribute/' , 'category_id' => $category_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['attribute-view', 'category_id' => $category_id , 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'category_id' => $category_id
    ]) ?>

</div>
