<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\modules\blog\models\CommentBlog;


/* @var $this yii\web\View */
/* @var $comments app\models\Comment[] */
/* @var $stats array */

$this->title = 'مدیریت نظرات';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="comment-admin">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-comments"></i> مدیریت نظرات
                        </h4>
                        <div>
                            <span class="badge bg-light text-dark ms-2">
                                <i class="fas fa-clock text-warning"></i> 
                                <?= $stats['pending'] ?> در انتظار
                            </span>
                            <span class="badge bg-light text-dark ms-2">
                                <i class="fas fa-check-circle text-success"></i> 
                                <?= $stats['approved'] ?> تایید شده
                            </span>
                            <span class="badge bg-light text-dark ms-2">
                                <i class="fas fa-times-circle text-danger"></i> 
                                <?= $stats['rejected'] ?> رد شده
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-list"></i> 
                                <?= $stats['total'] ?> کل نظرات
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <?php Pjax::begin([
                        'id' => 'admin-comments-pjax',
                        'enablePushState' => false,
                        'timeout' => 5000,
                    ]) ?>
                    
                    <!-- فیلترها -->
                    <div class="filter-section mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select" id="status-filter" onchange="filterComments()">
                                    <option value="">همه نظرات</option>
                                    <option value="<?= CommentBlog::STATUS_PENDING ?>">در انتظار تایید</option>
                                    <option value="<?= CommentBlog::STATUS_APPROVED ?>">تایید شده</option>
                                    <option value="<?= CommentBlog::STATUS_REJECTED ?>">رد شده</option>
                                    <option value="<?= CommentBlog::STATUS_DELETED ?>">حذف شده</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="search-input" placeholder="جستجوی متن نظر..." onkeyup="searchComments()">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="date-filter" onchange="filterComments()">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                    <i class="fas fa-undo"></i> بازنشانی فیلترها
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- جدول نظرات -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="comments-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>کاربر</th>
                                    <th>مقاله</th>
                                    <th>متن نظر</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($comments): ?>
                                    <?php foreach ($comments as $index => $comment): ?>
                                        <tr id="comment-row-<?= $comment->id ?>" data-status="<?= $comment->status ?>">
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded-circle me-2"
                                                         style="width: 35px; height: 35px; font-size: 14px; font-weight: bold; flex-shrink: 0;">
                                                        <?= strtoupper(substr($comment->user->username ?? 'U', 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <strong><?= Html::encode($comment->user->username ?? 'ناشناس') ?></strong>
                                                        <br>
                                                        <!-- <small class="text-muted">ID: <?= $comment->user_id ?></small> -->
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?= Html::a(
                                                    Html::encode($comment->article->title ?? 'بدون عنوان'),
                                                    ['/blog/blog/view', 'slug' => $comment->article->slug],
                                                    ['target' => '_blank', 'class' => 'text-decoration-none']
                                                ) ?>
                                            </td>
                                            <td>
                                                <div class="comment-preview">
                                                    <?= Html::encode(substr($comment->comment, 0, 80)) ?>
                                                    <?php if (strlen($comment->comment) > 80): ?>
                                                        <span class="text-muted">...</span>
                                                        <button class="btn btn-sm btn-link p-0" onclick="showFullComment(<?= $comment->id ?>)">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                                <!-- کامنت کامل (مخفی) -->
                                                <div id="full-comment-<?= $comment->id ?>" style="display: none;" class="mt-2 p-2 bg-light rounded">
                                                    <small><?= nl2br(Html::encode($comment->comment)) ?></small>
                                                    <button class="btn btn-sm btn-link" onclick="hideFullComment(<?= $comment->id ?>)">
                                                        <i class="fas fa-times"></i> بستن
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                $statusClass = '';
                                                $statusText = '';
                                                switch($comment->status) {
                                                    case CommentBlog::STATUS_PENDING:
                                                        $statusClass = 'warning';
                                                        $statusText = 'در انتظار';
                                                        break;
                                                    case CommentBlog::STATUS_APPROVED:
                                                        $statusClass = 'success';
                                                        $statusText = 'تایید شده';
                                                        break;
                                                    case CommentBlog::STATUS_REJECTED:
                                                        $statusClass = 'danger';
                                                        $statusText = 'رد شده';
                                                        break;
                                                    case CommentBlog::STATUS_DELETED:
                                                        $statusClass = 'secondary';
                                                        $statusText = 'حذف شده';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?> bg-opacity-10 text-<?= $statusClass ?> px-3 py-2">
                                                    <i class="fas fa-circle" style="font-size: 8px;"></i> <?= $statusText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="text-nowrap">
                                                    <small class="text-muted d-block">
                                                        <i class="far fa-calendar-alt"></i> 
                                                        <?= Yii::$app->formatter->asDatetime($comment->created_at, 'php:Y/m/d') ?>
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="far fa-clock"></i> 
                                                        <?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical gap-1" style="min-width: 100px;">
                                                    <?php if ($comment->status == CommentBlog::STATUS_PENDING || $comment->status == CommentBlog::STATUS_REJECTED): ?>
                                                        <button class="btn btn-success btn-sm" onclick="approveComment(<?= $comment->id ?>)">
                                                            <i class="fas fa-check"></i> تایید
                                                        </button>
                                                        <?php endif; ?>
                                                        <?php if ($comment->status == CommentBlog::STATUS_PENDING || $comment->status == CommentBlog::STATUS_APPROVED): ?>
                                                        <button class="btn btn-danger btn-sm" onclick="rejectComment(<?= $comment->id ?>)">
                                                            <i class="fas fa-times"></i> رد
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($comment->status != CommentBlog::STATUS_DELETED): ?>
                                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteComment(<?= $comment->id ?>)">
                                                            <i class="fas fa-trash"></i> حذف
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <a href="<?= Url::to(['/blog/blog/view', 'slug' => $comment->article->slug, '#' => 'comment-' . $comment->id]) ?>" 
                                                       target="_blank" 
                                                       class="btn btn-outline-info btn-sm">
                                                        <i class="fas fa-external-link-alt"></i> مشاهده
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-comment-slash text-muted fs-1 mb-3 d-block"></i>
                                            <p class="text-muted mb-0">هیچ نظری یافت نشد.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- خلاصه آمار -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="stat-card bg-primary bg-opacity-10 p-3 rounded-3">
                                <h6 class="text-primary">کل نظرات</h6>
                                <h3 class="fw-bold"><?= $stats['total'] ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-warning bg-opacity-10 p-3 rounded-3">
                                <h6 class="text-warning">در انتظار تایید</h6>
                                <h3 class="fw-bold"><?= $stats['pending'] ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-success bg-opacity-10 p-3 rounded-3">
                                <h6 class="text-success">تایید شده</h6>
                                <h3 class="fw-bold"><?= $stats['approved'] ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-danger bg-opacity-10 p-3 rounded-3">
                                <h6 class="text-danger">رد شده</h6>
                                <h3 class="fw-bold"><?= $stats['rejected'] ?></h3>
                            </div>
                        </div>
                    </div>

                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal برای نمایش کامنت کامل -->
<div class="modal fade" id="commentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">متن کامل نظر</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="commentModalBody">
            </div>
        </div>
    </div>
</div>

<!-- استایل‌ها -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.avatar-circle {
    width: 35px;
    height: 35px;
    font-size: 14px;
    font-weight: bold;
    flex-shrink: 0;
}

.stat-card {
    transition: all 0.3s ease;
    cursor: default;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.comment-preview {
    max-width: 200px;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group-vertical .btn {
    border-radius: 6px !important;
}

.filter-section .form-control:focus,
.filter-section .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 14px;
    }
    
    .comment-preview {
        max-width: 100px;
    }
    
    .btn-group-vertical {
        min-width: 80px !important;
    }
    
    .stat-card h3 {
        font-size: 1.5rem;
    }
}
</style>

<!-- اسکریپت‌ها -->
<script>
// تایید کامنت
function approveComment(id) {
    if (!confirm('آیا از تایید این نظر مطمئن هستید؟')) {
        return;
    }
    let url = '/blog/admin/comment-blog/approve?id=' + id;
    
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload(); // ریلود صفحه برای به‌روزرسانی
            } else {
                alert('خطا در تایید نظر');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        }
    });
}

// رد کامنت
function rejectComment(id) {
    if (!confirm('آیا از رد این نظر مطمئن هستید؟')) {
        return;
    }
    let url = '/blog/admin/comment-blog/reject?id=' + id;
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('خطا در رد نظر');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        }
    });
}

// حذف کامنت
function deleteComment(id) {
    if (!confirm('آیا از حذف این نظر مطمئن هستید؟ این عملیات قابل بازگشت نیست!')) {
        return;
    }
    let url = '/blog/admin/comment-blog/delete?id=' + id;
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('خطا در حذف نظر');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        }
    });
}

// نمایش کامنت کامل
function showFullComment(id) {
    const fullComment = document.getElementById('full-comment-' + id);
    if (fullComment.style.display === 'none') {
        fullComment.style.display = 'block';
    } else {
        fullComment.style.display = 'none';
    }
}

function hideFullComment(id) {
    document.getElementById('full-comment-' + id).style.display = 'none';
}

// فیلتر کردن نظرات
function filterComments() {
    const status = document.getElementById('status-filter').value;
    const date = document.getElementById('date-filter').value;
    const rows = document.querySelectorAll('#comments-table tbody tr');
    
    rows.forEach(row => {
        let show = true;
        
        // فیلتر بر اساس وضعیت
        if (status && row.dataset.status !== status) {
            show = false;
        }
        
        // فیلتر بر اساس تاریخ
        if (date) {
            const dateCell = row.querySelector('td:nth-child(6) small:first-child');
            if (dateCell) {
                const rowDate = dateCell.textContent.trim().split(' ')[0];
                if (rowDate !== date) {
                    show = false;
                }
            }
        }
        
        row.style.display = show ? '' : 'none';
    });
}

// جستجو در نظرات
function searchComments() {
    const searchText = document.getElementById('search-input').value.toLowerCase();
    const rows = document.querySelectorAll('#comments-table tbody tr');
    
    rows.forEach(row => {
        const commentText = row.querySelector('td:nth-child(4) .comment-preview')?.textContent?.toLowerCase() || '';
        const username = row.querySelector('td:nth-child(2) strong')?.textContent?.toLowerCase() || '';
        const article = row.querySelector('td:nth-child(3) a')?.textContent?.toLowerCase() || '';
        
        if (commentText.includes(searchText) || 
            username.includes(searchText) || 
            article.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// بازنشانی فیلترها
function resetFilters() {
    document.getElementById('status-filter').value = '';
    document.getElementById('search-input').value = '';
    document.getElementById('date-filter').value = '';
    
    const rows = document.querySelectorAll('#comments-table tbody tr');
    rows.forEach(row => {
        row.style.display = '';
    });
}

// بارگذاری خودکار با Pjax
$(document).on('pjax:beforeSend', function() {
    $('body').append('<div class="loading-overlay"><div class="spinner"></div></div>');
});

$(document).on('pjax:complete', function() {
    $('.loading-overlay').remove();
});

// استایل لودینگ
const style = document.createElement('style');
style.textContent = `
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.7);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>