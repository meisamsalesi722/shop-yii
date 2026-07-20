<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'وبلاگ';
?>

<div class="site-index">
    <!-- هدر -->
    <div class="p-5 mb-4 bg-light rounded-3 text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
        <div class="container-fluid py-5">
            <h1 class="display-4 fw-bold text-white">📝 مقالات وبلاگ</h1>
            <p class="fs-5 text-white-50">جدیدترین مقالات و مطالب آموزشی</p>
        </div>
    </div>

    <!-- لیست مقالات -->
    <div class="row">
        <div class="col-12">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_article_item',
                'layout' => "{items}\n{pager}",
                'options' => ['class' => 'row g-4'],
                'itemOptions' => ['class' => 'col-md-6 col-lg-4'],
                'pager' => [
                    'class' => 'yii\bootstrap5\LinkPager',
                ],
            ]) ?>
        </div>
    </div>
</div>