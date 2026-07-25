<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ticket $model */

$this->title = 'Create Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">


    <?= $this->render('_form', [
        'model' => $model,
        'children' => $children
    ]) ?>

</div>
