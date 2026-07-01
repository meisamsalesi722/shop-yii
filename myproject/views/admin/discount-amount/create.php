<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DiscountAmount $model */

$this->title = 'Create Discount Amount';
$this->params['breadcrumbs'][] = ['label' => 'Discount Amounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-amount-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
