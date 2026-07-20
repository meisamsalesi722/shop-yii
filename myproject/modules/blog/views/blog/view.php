<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Breadcrumbs;
use app\modules\blog\models\CommentBlog;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $commentModel app\models\Comment */
/* @var $isFavorite boolean */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'مقالات', 'url' => ['/blog/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="article-view py-4">
    <div class="container">


        <!-- مقاله اصلی -->
        <article class="card border-0 shadow-lg mb-4 overflow-hidden">
            <!-- هدر با گرادینت -->
            <div class="card-header bg-gradient-primary text-white p-4 border-0">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-4 fw-bold mb-2"><?= Html::encode($model->title) ?></h1>
                        <div class="d-flex flex-wrap gap-3 mt-3">
                            <span class="badge bg-light text-dark py-2 px-3">
                                <i class="fas fa-tag text-primary"></i> <?= Html::encode($model->blog_category->title ?? 'بدون دسته') ?>
                            </span>
                            <span class="text-white-50">
                                <i class="fas fa-user"></i> <?= Html::encode($model->user->username ?? 'ناشناس') ?>
                            </span>
                            <span class="text-white-50">
                                <i class="far fa-calendar-alt"></i> 
                                <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:Y/m/d H:i') ?>
                            </span>
                            <?php if ($model->updated_at != $model->created_at): ?>
                                <span class="text-white-50">
                                    <i class="fas fa-edit"></i> <?= Yii::$app->formatter->asDatetime($model->updated_at, 'php:Y/m/d H:i') ?>
                                </span>
                            <?php endif; ?>
                            <span class="text-white-50">
                                <i class="far fa-eye"></i> <?= $model->view_count ?? 0 ?> بازدید
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-white text-primary fs-6 px-4 py-2">
                            <i class="far fa-clock"></i> 
                            <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-lg-5">
                <!-- تصویر با افکت hover -->
                <?php if ($model->image): ?>
                    <div class="position-relative mb-4">
                        <div class="overflow-hidden rounded-3 shadow-sm">
                            <img src="<?= Yii::getAlias('@web/uploads/images/') . $model->image ?>" 
                                 class="img-fluid w-100 transition-transform" 
                                 alt="<?= Html::encode($model->title) ?>"
                                 style="max-height: 500px; object-fit: cover; transition: transform 0.3s;"
                                 onmouseover="this.style.transform='scale(1.02)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 px-3 py-2">
                                <i class="fas fa-image"></i> تصویر مقاله
                            </span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- خلاصه با آیکون -->
                <?php if ($model->summary): ?>
                    <div class="alert alert-info border-0 bg-light-info d-flex align-items-start p-4 rounded-3 mb-4">
                        <i class="fas fa-lightbulb text-primary fs-4 me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-primary mb-1">خلاصه مقاله</h6>
                            <p class="mb-0"><?= Html::encode($model->summary) ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- محتوا -->
                <div class="article-content">
                    <?= $model->content ?>
                </div>

                <!-- دکمه‌های پایین -->
                <div class="mt-5 pt-4 border-top">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <!-- دکمه علاقه‌مندی با انیمیشن -->
                                <div id="favorite-section">
                                    <?= $this->render('_favorite_button', [
                                        'model' => $model,
                                        'isFavorite' => $isFavorite,
                                    ]) ?>
                                </div>
                                
                                <!-- دکمه PDF با استایل جدید -->
                                <?php if ($model->pdf): ?>
                                    <a href="<?= Yii::getAlias('@web/uploads/pdf/') . $model->pdf ?>" 
                                       target="_blank" 
                                       download="<?= $model->pdf ?>"
                                       class="btn btn-outline-danger">
                                        <i class="fas fa-file-pdf"></i> دانلود PDF
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="text-muted me-2">اشتراک‌گذاری:</span>
                            <button class="btn btn-outline-primary btn-sm" onclick="shareOnTwitter()">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="shareOnTelegram()">
                                <i class="fab fa-telegram"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="shareOnWhatsApp()">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="copyLink()">
                                <i class="fas fa-link"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="printArticle()">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- بخش نظرات -->
        <div class="card border-0 shadow-lg" id="comments-section">
            <div class="card-header bg-light border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-comments text-primary"></i> نظرات
                        <span class="badge bg-primary ms-2" id="comment-count">
                            <?= CommentBlog::find()->where(['article_id' => $model->id, 'status' => CommentBlog::STATUS_APPROVED])->count() ?>
                        </span>
                    </h5>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <button class="btn btn-primary btn-sm" onclick="document.getElementById('comment-form').scrollIntoView({behavior: 'smooth'})">
                            <i class="fas fa-pen"></i> ثبت نظر
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card-body p-4">
                <?php Pjax::begin([
                    'id' => 'comments-pjax',
                    'enablePushState' => false,
                    'timeout' => 5000,
                    'scrollTo' => true,
                ]) ?>
                
                <!-- نمایش پیام‌های فلش -->
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- لیست کامنت‌ها -->
                <div class="comments-list mb-4">
                    <?php 
                    // فقط کامنت‌های تایید شده را نمایش بده
                    $approvedComments = array_filter($model->commentsBlog, function($c) {
                        return $c->status == CommentBlog::STATUS_APPROVED;
                    });
                    ?>
                    
                    <?php if ($approvedComments): ?>
                        <?php foreach ($approvedComments as $comment): ?>
                            <div class="comment-item d-flex gap-3 p-3 rounded-3 mb-3 bg-light-hover transition-all" id="comment-<?= $comment->id ?>">
                                <div class="flex-shrink-0">
                                    <div class="avatar-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded-circle"
                                         style="width: 48px; height: 48px; font-size: 20px; font-weight: bold;">
                                        <?= strtoupper(substr($comment->user->username ?? 'U', 0, 1)) ?>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-1">
                                        <div>
                                            <strong class="fw-bold"><?= Html::encode($comment->user->username ?? 'کاربر ناشناس') ?></strong>
                                            <?php if ($comment->user_id == $model->user_id): ?>
                                                <span class="badge bg-success bg-opacity-10 text-success ms-2">نویسنده</span>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted">
                                            <i class="far fa-clock"></i> 
                                            <?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?>
                                        </small>
                                    </div>
                                    <p class="mb-1"><?= nl2br(Html::encode($comment->comment)) ?></p>
                                    
                                    <!-- دکمه‌های مدیریت برای نویسنده یا ادمین -->
                                    <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->id == $comment->user_id || Yii::$app->user->can('admin'))): ?>
                                        <div class="mt-2">
                                            <?php if (Yii::$app->user->id == $comment->user_id): ?>
                                                <button class="btn btn-sm btn-outline-primary" onclick="editComment(<?= $comment->id ?>, '<?= addslashes($comment->comment) ?>')">
                                                    <i class="fas fa-edit"></i> ویرایش
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteComment(<?= $comment->id ?>)">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-comment-dots text-muted fs-1 mb-3 d-block"></i>
                            <p class="text-muted mb-0">هنوز نظری ثبت نشده است.</p>
                            <p class="text-muted small">اولین نفری باشید که نظر می‌دهید!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- فرم ثبت کامنت -->
                <?php if (!Yii::$app->user->isGuest): ?>
                    <div id="comment-form" class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-pen text-primary"></i> نظر خود را بنویسید
                        </h6>
                        
                        <?php
                         $form = ActiveForm::begin([
                            'action' => ['/blog/comment-blog/create', 'article_id' => $model->id],
                            'options' => [
                                // 'data-pjax' => true, 
                                'class' => 'comment-form',
                                'id' => 'comment-form-id',
                            ],
                            'enableClientValidation' => true,
                            'enableAjaxValidation' => false,
                        ]); 
                        ?>
                        
                        <div class="position-relative">
                            <?= $form->field($commentModel, 'comment')->textarea([
                                'rows' => 4,
                                'placeholder' => 'نظر خود را اینجا بنویسید...',
                                'class' => 'form-control form-control-lg',
                                'style' => 'border-radius: 12px; resize: none;',
                                'id' => 'comment-textarea',
                            ])->label(false) ?>
                            
                            <div class="mt-3 d-flex gap-2">
                                <?= Html::submitButton(
                                    '<i class="fas fa-paper-plane"></i> ارسال نظر',
                                    ['class' => 'btn btn-primary px-4', 'id' => 'submit-comment']
                                ) ?>
                                <button type="reset" class="btn btn-outline-secondary" onclick="resetCommentForm()">
                                    <i class="fas fa-undo"></i> پاک کردن
                                </button>
                            </div>
                        </div>
                        
                        <?php ActiveForm::end(); ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info border-0 d-flex align-items-center p-3">
                        <i class="fas fa-info-circle fs-4 me-3"></i>
                        <div>
                            برای ثبت نظر ابتدا 
                            <?= Html::a('وارد شوید', ['/site/login'], ['class' => 'alert-link fw-bold']) ?>
                            یا 
                            <?= Html::a('ثبت نام کنید', ['/site/signup'], ['class' => 'alert-link fw-bold']) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>

<!-- استایل‌ها -->
<style>
/* فونت و فاصله‌گذاری */
.article-view {
    font-family: 'Vazir', 'Tahoma', sans-serif;
}

/* گرادینت‌ها */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-light-info {
    background-color: #e8f4fd !important;
}

/* انیمیشن‌ها */
.transition-all {
    transition: all 0.3s ease;
}

.comment-item:hover {
    background-color: #f8f9fa !important;
    transform: translateX(-5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* محتوای مقاله */
.article-content {
    font-size: 1.05rem;
    line-height: 2;
    color: #2d3748;
}

.article-content h2 {
    font-size: 2rem;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: #1a202c;
    border-right: 4px solid #667eea;
    padding-right: 15px;
}

.article-content h3 {
    font-size: 1.5rem;
    margin-top: 2rem;
    margin-bottom: 0.8rem;
    color: #2d3748;
}

.article-content p {
    margin-bottom: 1.2rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 1.5rem 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.article-content blockquote {
    border-right: 4px solid #667eea;
    padding: 1rem 1.5rem;
    margin: 1.5rem 0;
    background: #f7fafc;
    border-radius: 8px;
    font-style: italic;
}

.article-content ul, .article-content ol {
    padding-right: 1.5rem;
    margin-bottom: 1.2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

/* کارت‌ها */
.card {
    border-radius: 16px !important;
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.12) !important;
}

/* آواتار */
.avatar-circle {
    width: 48px;
    height: 48px;
    font-size: 20px;
    font-weight: bold;
}

/* فرم */
.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* دکمه‌ها */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-primary:disabled {
    opacity: 0.7;
    transform: none;
}

.btn-outline-primary {
    border-color: #667eea;
    color: #667eea;
}

.btn-outline-primary:hover {
    background: #667eea;
    color: white;
}

/* لودینگ Pjax */
.loading {
    opacity: 0.6;
    position: relative;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 30px;
    height: 30px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* ریسپانسیو */
@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem !important;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .comment-item {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
}
</style>

<!-- اسکریپت‌ها -->
<script>
// توابع اشتراک‌گذاری
function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('<?= Html::encode($model->title) ?>');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
}

function shareOnTelegram() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://t.me/share/url?url=${url}`, '_blank', 'width=600,height=400');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://wa.me/?text=${url}`, '_blank', 'width=600,height=400');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = event.target.closest('button');
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> کپی شد!';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-outline-primary');
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    });
}

function printArticle() {
    window.print();
}

// مدیریت کامنت‌ها
function deleteComment(id) {
    if (!confirm('آیا از حذف این نظر مطمئن هستید؟')) {
        return;
    }
    
    $.ajax({
        url: '/blog/admin/comment/delete?id=' + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload(); // ریلود صفحه برای به‌روزرسانی Pjax
            } else {
                alert('خطا در حذف نظر');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        }
    });
}

function editComment(id, content) {
    const textarea = $('#comment-textarea');
    textarea.val(content);
    textarea.focus();
    
    const submitBtn = $('#submit-comment');
    submitBtn.html('<i class="fas fa-save"></i> ویرایش نظر');
    submitBtn.data('edit-id', id);
    submitBtn.data('action', 'update');
    
    // تغییر اکشن فرم به ویرایش
    const form = $('.comment-form');
    form.attr('action', '/comment/update?id=' + id);
    
    // اسکرول به فرم
    document.getElementById('comment-form').scrollIntoView({behavior: 'smooth'});
}

function resetCommentForm() {
    $('#comment-textarea').val('');
    const submitBtn = $('#submit-comment');
    submitBtn.html('<i class="fas fa-paper-plane"></i> ارسال نظر');
    submitBtn.removeData('edit-id');
    submitBtn.removeData('action');
    
    // برگرداندن اکشن فرم به حالت عادی
    const form = $('.comment-form');
    form.attr('action', '/blog/comment-blog/create?article_id=<?= $model->id ?>');
}

// رویدادهای Pjax
$(document).on('pjax:beforeSend', function() {
    $('#submit-comment').prop('disabled', true);
});

$(document).on('pjax:complete', function() {
    $('#submit-comment').prop('disabled', false);
    resetCommentForm();
    
    // به‌روزرسانی تعداد نظرات
    const count = $('.comment-item').length;
    $('#comment-count').text(count);
    
    // اسکرول به بخش نظرات اگر کامنت جدید اضافه شده
    if (window.location.hash === '#comments') {
        document.getElementById('comments-section').scrollIntoView({ 
            behavior: 'smooth' 
        });
    }
});

// اسکرول به بخش کامنت‌ها
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash === '#comments') {
        document.getElementById('comments-section').scrollIntoView({ 
            behavior: 'smooth' 
        });
    }
});
</script>