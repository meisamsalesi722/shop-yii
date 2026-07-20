<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/* @var $model app\models\Article */
?>

<div class="card h-100 shadow-sm hover-card">
    <!-- تصویر -->
    <div class="card-img-top-wrapper" style="height: 200px; overflow: hidden; position: relative;">
        <?php if ($model->image): ?>
            <img src="<?= Yii::getAlias('@web/uploads/images/') . $model->image ?>" 
                 class="card-img-top" 
                 alt="<?= Html::encode($model->title) ?>"
                 style="width: 100%; height: 100%; object-fit: cover;">
        <?php else: ?>
            <div class="bg-secondary d-flex align-items-center justify-content-center" 
                 style="width: 100%; height: 100%;">
                <i class="fas fa-image fa-3x text-white-50"></i>
            </div>
        <?php endif; ?>
        
        <!-- برچسب وضعیت -->
        <?php if ($model->status == 1): ?>
            <span class="badge bg-success position-absolute top-0 end-0 m-2">
                <i class="fas fa-check-circle"></i> منتشر شده
            </span>
        <?php endif; ?>
    </div>

    <div class="card-body d-flex flex-column">
        <!-- دسته‌بندی -->
        <div class="mb-2">
            <span class="badge bg-primary">
                <i class="fas fa-tag"></i> <?= Html::encode($model->blogCategory->title ?? 'بدون دسته') ?>
            </span>
        </div>

        <!-- عنوان -->
        <h5 class="card-title">
            <?= Html::a(
                Html::encode($model->title),
                ['blog/view', 'slug' => $model->slug],
                ['class' => 'text-decoration-none text-dark']
            ) ?>
        </h5>

        <!-- خلاصه -->
        <p class="card-text text-muted small">
            <?= Html::encode(StringHelper::truncate($model->summary ?? $model->content, 120)) ?>
        </p>

        <!-- اطلاعات نویسنده و تاریخ -->
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <!-- آواتار نویسنده -->
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                         style="width: 30px; height: 30px; font-size: 12px;">
                        <?= strtoupper(substr($model->user->username ?? 'U', 0, 1)) ?>
                    </div>
                    <small class="text-muted">
                        <?= Html::encode($model->user->username ?? 'ناشناس') ?>
                    </small>
                </div>
                <small class="text-muted">
                    <i class="far fa-calendar-alt"></i> 
                    <?= Yii::$app->formatter->asDate($model->created_at, 'php:Y/m/d') ?>
                </small>
            </div>
        </div>
    </div>

    <div class="card-footer bg-transparent">
        <div class="d-flex justify-content-between align-items-center">
            <!-- دکمه مطالعه -->
            <?= Html::a(
                '<i class="fas fa-book-open"></i> مطالعه',
                ['blog/view', 'slug' => $model->slug],
                ['class' => 'btn btn-sm btn-outline-primary']
            ) ?>
            
            <!-- تعداد کامنت‌ها و لایک‌ها -->
            <div>
                <span class="text-muted me-2">
                    <i class="far fa-comment"></i> <?= count($model->commentsBlog) ?>
                </span>
                <span class="text-muted">
                    <i class="far fa-heart"></i> <?= count($model->favorites) ?>
                </span>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.card-img-top-wrapper {
    background: #f8f9fa;
}
</style>