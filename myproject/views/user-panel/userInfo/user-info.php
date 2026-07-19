<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<!-- start page-content -->
<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/index']) ?>">صفحه اصلی</a></li>
                <li class="breadcrumb-item active" aria-current="page">پروفایل کاربر</li>
            </ol>
        </nav>
    </div>

    <div class="content-in">
        <!-- Profile Header Card -->
        <div class="card shadow-sm border-0 mb-4 overflow-hidden">
            <!-- Cover Image -->
            <div class="profile-cover" style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative;">
                <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.3));">
                </div>
            </div>
            
            <!-- Profile Info -->
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex flex-column flex-md-row align-items-md-end" style="margin-top: -60px;">
                            <!-- Avatar -->
                            <div class="flex-shrink-0 ms-md-3 mb-3 mb-md-0">
                                <div class="profile-avatar position-relative">
                                    <?= Html::img( Yii::getAlias('@web/uploads/images/') . ($userModel->avatar ?? 'images.png'), [
                                        'class' => 'rounded-circle border border-4 border-white shadow',
                                        'style' => 'width: 130px; height: 130px; object-fit: cover;',
                                        'alt' => 'Avatar'
                                    ]) ?>
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-white">
                                        <i class="fas fa-check-circle text-white" style="font-size: 16px;"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- User Info -->
                            <div class="flex-grow-1">
                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between">
                                    <div>
                                        <h3 class="mb-1 fw-bold"><?= Html::encode($userModel->username) ?></h3>
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                                <i class="fas fa-calendar me-1"></i> عضو از <?= $userModel->created_at ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="mt-3 mt-md-0">
                                        <?= Html::a('<i class="fas fa-edit me-2"></i>ویرایش پروفایل', ['update'], [
                                            'class' => 'btn btn-primary rounded-pill px-4'
                                        ]) ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                            <i class="fas fa-shopping-bag text-primary fa-2x"></i>
                        </div>
                        <h5 class="mb-0 fw-bold"><?= count($userModel->orders) ?></h5>
                        <small class="text-muted">سفارشات</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                            <i class="fas fa-heart text-success fa-2x"></i>
                        </div>
                        <h5 class="mb-0 fw-bold"><?= count($userModel->productUser) ?></h5>
                        <small class="text-muted">علاقه‌مندی‌ها</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Info Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0"><i class="fas fa-user-circle me-2 text-primary"></i>اطلاعات شخصی</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item p-3 bg-light rounded-3">
                            <label class="text-muted small mb-1">نام کاربری</label>
                            <div class="fw-bold fs-5"><?= Html::encode($userModel->username) ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-item p-3 bg-light rounded-3">
                            <label class="text-muted small mb-1">شماره موبایل</label>
                            <div class="fw-bold fs-5 dir-ltr"><?= Html::encode($userModel->mobile) ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-item p-3 bg-light rounded-3">
                            <label class="text-muted small mb-1">ایمیل</label>
                            <div class="fw-bold fs-5 dir-ltr"><?= Html::encode($userModel->email) ?></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0"><i class="fas fa-clock me-2 text-info"></i>اطلاعات حساب</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">تاریخ ثبت نام</span>
                            <span class="fw-bold"><?= $userModel->created_at ?></span>
                        </div>

                    </div>
                </div>
            </div>
            
            <!-- <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0"><i class="fas fa-shield-alt me-2 text-warning"></i>امنیت</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">احراز هویت دو مرحله‌ای</span>
                            <span class="badge bg-success">فعال</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">تأیید موبایل</span>
                            <span class="badge bg-success">تأیید شده</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">تأیید ایمیل</span>
                            <span class="badge bg-warning">تأیید نشده</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <!-- Recent Activities -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-history me-2 text-primary"></i>فعالیت‌های اخیر</h6>
                <a href="#" class="text-primary text-decoration-none small">مشاهده همه</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                        <div>
                            <i class="fas fa-edit text-primary me-2"></i>
                            <span>ویرایش پروفایل</span>
                        </div>
                        <small class="text-muted"><?=  Yii::$app->formatter->asRelativeTime($userModel->updated_at) ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end page-content -->

<style>
/* Custom styles for better RTL support */
.dir-ltr {
    direction: ltr;
    text-align: left;
}

.info-item {
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.stat-icon {
    transition: all 0.3s ease;
}

.card:hover .stat-icon {
    transform: scale(1.05);
}

.profile-avatar {
    cursor: pointer;
}

@media (max-width: 768px) {
    .profile-cover {
        height: 100px !important;
    }
}
</style>