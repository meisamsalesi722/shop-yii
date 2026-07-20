<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $category app\models\Category */
/* @var $articles app\models\Article[] */

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => 'دسته‌بندی‌ها', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-view">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">
                <i class="fas fa-folder-open"></i> <?= Html::encode($category->title) ?>
            </h3>
        </div>
        <div class="card-body">
            <?php if ($articles): ?>
                <div class="row">
                    <?php foreach ($articles as $article): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>
                                        <?= Html::a(
                                            Html::encode($article->title),
                                            ['/article/view', 'id' => $article->id],
                                            ['class' => 'text-decoration-none']
                                        ) ?>
                                    </h5>
                                    <p class="text-muted small">
                                        <i class="fas fa-user"></i> <?= Html::encode($article->user->username ?? 'ناشناس') ?>
                                        <span class="mx-2">|</span>
                                        <i class="far fa-calendar-alt"></i> 
                                        <?= Yii::$app->formatter->asDate($article->created_at) ?>
                                    </p>
                                    <p><?= Html::encode(substr($article->summary ?? $article->content, 0, 100)) ?>...</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> هنوز مقاله‌ای در این دسته منتشر نشده است.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>