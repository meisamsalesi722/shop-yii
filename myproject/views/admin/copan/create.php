<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Copan $model */

$this->title = 'Create Copan';
$this->params['breadcrumbs'][] = ['label' => 'Copans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="copan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
