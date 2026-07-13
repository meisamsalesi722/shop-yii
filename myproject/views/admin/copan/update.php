<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Copan $model */

$this->title = 'Update Copan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Copans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="copan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
