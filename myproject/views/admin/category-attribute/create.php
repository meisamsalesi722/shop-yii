<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryAttribute $model */

$this->title = 'Create Category Attribute';
$this->params['breadcrumbs'][] = ['label' => 'Category Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
