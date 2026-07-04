<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gullery $model */

$this->title = 'Create Gullery';
$this->params['breadcrumbs'][] = ['label' => 'Gulleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gullery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
