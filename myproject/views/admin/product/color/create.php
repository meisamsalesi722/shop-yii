<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Color $model */

$this->title = 'Create Color';
$this->params['breadcrumbs'][] = ['label' => ' / Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Colors', 'url' => ['color-index' , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="color-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_id' => $product_id,
    ]) ?>

</div>
