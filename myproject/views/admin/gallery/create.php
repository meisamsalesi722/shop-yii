<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gallery $model */

$this->title = 'Create Gallery';
$this->params['breadcrumbs'][] = ['label' => 'Gulleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
