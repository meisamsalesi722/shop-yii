<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $favorites app\models\Favorite[] */

$this->title = 'علاقه‌مندی‌های من';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="favorite-index">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white p-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-heart"></i> علاقه‌مندی‌های من
                </h4>
                <span class="badge bg-light text-dark">
                    <i class="fas fa-list"></i> <?= count($favorites) ?> مقاله
                </span>
            </div>
        </div>
        
        <div class="card-body p-4">
            <?php Pjax::begin(['id' => 'favorites-pjax']) ?>
            
            <?php if ($favorites): ?>
                <div class="row g-4">
                    <?php foreach ($favorites as $favorite): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm hover-card" id="favorite-<?= $favorite->id ?>">
                                <?php if ($favorite->article->image): ?>
                                    <img src="<?= Yii::getAlias('@web/uploads/images/') . $favorite->article->image ?>" 
                                         class="card-img-top" 
                                         alt="<?= Html::encode($favorite->article->title) ?>"
                                         style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= Html::a(
                                            Html::encode($favorite->article->title),
                                            ['article/view', 'id' => $favorite->article_id],
                                            ['class' => 'text-decoration-none text-dark']
                                        ) ?>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        <i class="fas fa-user"></i> 
                                        <?= Html::encode($favorite->article->user->username ?? 'ناشناس') ?>
                                    </p>
                                    <p class="card-text">
                                        <?= Html::encode(substr($favorite->article->summary ?? $favorite->article->content, 0, 80)) ?>...
                                    </p>
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> 
                                        <?= Yii::$app->formatter->asRelativeTime($favorite->created_at) ?>
                                    </small>
                                </div>
                                
                                <div class="card-footer bg-transparent border-0 d-flex gap-2">
                                    <?= Html::a(
                                        '<i class="fas fa-book-open"></i> مطالعه',
                                        ['blog/view', 'slug' => $favorite->article->slug],
                                        ['class' => 'btn btn-primary btn-sm flex-grow-1']
                                    ) ?>
                                    
                                    <button class="btn btn-danger btn-sm" onclick="removeFavorite(<?= $favorite->id ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-heart-broken text-muted fa-4x mb-3 d-block"></i>
                    <h4 class="text-muted">شما هیچ علاقه‌مندی ندارید!</h4>
                    <p class="text-muted">برای افزودن مقاله به علاقه‌مندی‌ها، روی قلب قرمز رنگ در صفحه مقاله کلیک کنید.</p>
                    <?= Html::a(
                        '<i class="fas fa-book-open"></i> مشاهده مقالات',
                        ['blog/index'],
                        ['class' => 'btn btn-primary mt-3']
                    ) ?>
                </div>
            <?php endif; ?>
            
            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<!-- استایل‌ها -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
</style>

<!-- اسکریپت‌ها -->
<script>
function removeFavorite(id) {
    if (!confirm('آیا از حذف این آیتم از علاقه‌مندی‌ها مطمئن هستید؟')) {
        return;
    }
    
    $.ajax({
        url: '/blog/favorite/delete?id=' + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#favorite-' + id).fadeOut(300, function() {
                    $(this).remove();
                    // به‌روزرسانی تعداد
                    const count = $('.favorite-item').length;
                    $('.badge.bg-light.text-dark').text(count + ' مقاله');
                    
                    if (count === 0) {
                        location.reload();
                    }
                });
            } else {
                alert('خطا در حذف آیتم');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        }
    });
}
</script>