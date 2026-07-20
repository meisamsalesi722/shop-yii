<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Comment;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $totalArticles int */
/* @var $totalCategories int */
/* @var $totalComments int */
/* @var $totalUsers int */
/* @var $totalFavorites int */
/* @var $publishedArticles int */
/* @var $draftArticles int */
/* @var $pendingComments int */
/* @var $approvedComments int */
/* @var $rejectedComments int */
/* @var $todayArticles int */
/* @var $todayComments int */
/* @var $todayUsers int */
/* @var $latestArticles app\models\Article[] */
/* @var $latestComments app\models\Comment[] */
/* @var $latestUsers app\models\User[] */
/* @var $popularArticles app\models\Article[] */
/* @var $popularCategories app\models\Category[] */
/* @var $monthlyStats array */

$this->title = 'داشبورد مدیریت';
?>

<div class="dashboard-index">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">
                                <i class="fas fa-tachometer-alt"></i> <?= $this->title ?>
                            </h2>
                            <p class="text-white-50 mb-0">
                                <i class="far fa-calendar-alt"></i> 
                                <?= Yii::$app->formatter->asDate(time(), 'php:l، j F Y') ?>
                            </p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-white text-primary fs-6 px-4 py-2">
                                <i class="fas fa-clock"></i> 
                                <?= Yii::$app->formatter->asRelativeTime(time()) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">مقالات</h6>
                            <h2 class="fw-bold mb-0"><?= number_format($totalArticles) ?></h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> +<?= $todayArticles ?> امروز
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-newspaper fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success"><?= $publishedArticles ?> منتشر شده</span>
                        <span class="badge bg-warning"><?= $draftArticles ?> پیش‌نویس</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">نظرات</h6>
                            <h2 class="fw-bold mb-0"><?= number_format($totalComments) ?></h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> +<?= $todayComments ?> امروز
                            </small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-comments fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning"><?= $pendingComments ?> در انتظار</span>
                        <span class="badge bg-success"><?= $approvedComments ?> تایید شده</span>
                        <span class="badge bg-danger"><?= $rejectedComments ?> رد شده</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">کاربران</h6>
                            <h2 class="fw-bold mb-0"><?= number_format($totalUsers) ?></h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> +<?= $todayUsers ?> امروز
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-primary"><?= number_format($totalFavorites) ?> علاقه‌مندی</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">دسته‌بندی‌ها</h6>
                            <h2 class="fw-bold mb-0"><?= number_format($totalCategories) ?></h2>
                            <small class="text-muted">کل دسته‌بندی‌ها</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-folder fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-secondary">سطح اول</span>
                        <span class="badge bg-info">زیردسته</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-line text-primary"></i> آمار ماهانه
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie text-primary"></i> وضعیت کامنت‌ها
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="commentsChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest & Popular -->
    <div class="row g-4">
        <!-- Latest Articles -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-clock text-primary"></i> آخرین مقالات
                    </h5>
                    <?= Html::a(
                        'مشاهده همه <i class="fas fa-arrow-left"></i>',
                        ['/admin/article'],
                        ['class' => 'btn btn-sm btn-outline-primary']
                    ) ?>
                </div>
                <div class="card-body">
                    <?php if ($latestArticles): ?>
                        <?php foreach ($latestArticles as $article): ?>
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <?= strtoupper(substr($article->title, 0, 1)) ?>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <a href="<?= Url::to(['/admin/article/view', 'slug' => $article->slug]) ?>" 
                                       class="text-decoration-none text-dark fw-bold">
                                        <?= Html::encode($article->title) ?>
                                    </a>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> <?= Html::encode($article->user->username ?? 'ناشناس') ?>
                                        <span class="mx-1">|</span>
                                        <i class="far fa-clock"></i> <?= Yii::$app->formatter->asRelativeTime($article->created_at) ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center">هیچ مقاله‌ای یافت نشد.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Latest Comments -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-comments text-primary"></i> آخرین نظرات
                    </h5>
                    <?= Html::a(
                        'مشاهده همه <i class="fas fa-arrow-left"></i>',
                        ['/admin/comment'],
                        ['class' => 'btn btn-sm btn-outline-primary']
                    ) ?>
                </div>
                <div class="card-body">
                    <?php if ($latestComments): ?>
                        <?php foreach ($latestComments as $comment): ?>
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-info rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <?= strtoupper(substr($comment->user->username ?? 'U', 0, 1)) ?>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div>
                                        <strong><?= Html::encode($comment->user->username ?? 'ناشناس') ?></strong>
                                        <span class="badge <?= $comment->status == Comment::STATUS_PENDING ? 'bg-warning' : ($comment->status == Comment::STATUS_APPROVED ? 'bg-success' : 'bg-danger') ?>">
                                            <?= $comment->getStatusText() ?>
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        <?= Html::encode(substr($comment->comment, 0, 60)) ?>...
                                        <br>
                                        <i class="far fa-clock"></i> <?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center">هیچ نظری یافت نشد.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Popular & New Users -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#popular">
                                <i class="fas fa-fire text-danger"></i> محبوب‌ترین
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#newusers">
                                <i class="fas fa-user-plus text-success"></i> کاربران جدید
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Popular Articles -->
                        <div class="tab-pane fade show active" id="popular">
                            <?php if ($popularArticles): ?>
                                <?php foreach ($popularArticles as $article): ?>
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                        <div class="flex-shrink-0">
                                            <span class="badge bg-danger rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-fire"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <a href="<?= Url::to(['/admin/article/view', 'slug' => $article->slug]) ?>" 
                                               class="text-decoration-none text-dark">
                                                <?= Html::encode($article->title) ?>
                                            </a>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-comment"></i> <?= $article->comment_count ?? 0 ?> نظر
                                            </small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted text-center">هیچ مقاله‌ای یافت نشد.</p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- New Users -->
                        <div class="tab-pane fade" id="newusers">
                            <?php if ($latestUsers): ?>
                                <?php foreach ($latestUsers as $user): ?>
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                        <div class="flex-shrink-0">
                                            <span class="badge bg-success rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <?= strtoupper(substr($user->username, 0, 1)) ?>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong><?= Html::encode($user->username) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-envelope"></i> <?= Html::encode($user->email) ?>
                                                <br>
                                                <i class="far fa-clock"></i> <?= Yii::$app->formatter->asRelativeTime($user->created_at) ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted text-center">هیچ کاربری یافت نشد.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Categories -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-tags text-primary"></i> دسته‌بندی‌های پرکاربرد
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($popularCategories): ?>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($popularCategories as $category): ?>
                                <a href="<?= Url::to(['/admin/category/view', 'id' => $category->id]) ?>" 
                                   class="text-decoration-none">
                                    <span class="badge bg-primary bg-opacity-10 text-primary p-3">
                                        <i class="fas fa-folder"></i> 
                                        <?= Html::encode($category->title) ?>
                                        <span class="badge bg-primary ms-2"><?= $category->article_count ?? 0 ?></span>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">هیچ دسته‌بندی‌ای یافت نشد.</p>
                    <?php endif; ?>
                </div>
            </div>
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

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    padding: 8px 16px;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
    background: transparent;
}

.nav-tabs .nav-link:hover {
    border: none;
    color: #0d6efd;
}
</style>

<!-- اسکریپت‌ها برای Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = <?= json_encode($monthlyStats) ?>;
    
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month),
            datasets: [
                {
                    label: 'مقالات',
                    data: monthlyData.map(item => item.articles),
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'نظرات',
                    data: monthlyData.map(item => item.comments),
                    borderColor: '#38ef7d',
                    backgroundColor: 'rgba(56, 239, 125, 0.1)',
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'کاربران',
                    data: monthlyData.map(item => item.users),
                    borderColor: '#f6d365',
                    backgroundColor: 'rgba(246, 211, 101, 0.1)',
                    fill: true,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Comments Chart
    const commentsCtx = document.getElementById('commentsChart').getContext('2d');
    
    new Chart(commentsCtx, {
        type: 'doughnut',
        data: {
            labels: ['در انتظار تایید', 'تایید شده', 'رد شده'],
            datasets: [{
                data: [
                    <?= $pendingComments ?>,
                    <?= $approvedComments ?>,
                    <?= $rejectedComments ?>
                ],
                backgroundColor: [
                    '#ffc107',
                    '#28a745',
                    '#dc3545'
                ],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>