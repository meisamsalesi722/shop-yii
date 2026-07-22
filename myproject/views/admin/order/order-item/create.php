<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CartItem $model */

$this->title = 'Create Cart Item';
$this->params['breadcrumbs'][] = ['label' => '/ Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Order Items', 'url' => ['order-item' , 'order_id' => $order_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
