<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => ' / Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= $this->render('_print' , ['model' => $model]);?>



<?= Html::a('print', ['print-tcpdf', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

</div>
