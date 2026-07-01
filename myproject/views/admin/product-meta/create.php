<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductMeta $model */

$this->title = 'Create Product Meta';
$this->params['breadcrumbs'][] = ['label' => 'Product Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-meta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
