<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap5\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $stats array */

$this->title = 'مدیریت فروشنده ها';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-admin">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-boxes"></i> مدیریت فروشنده ها
                        </h4>
                        <div>
                            <span class="badge bg-light text-dark ms-2">
                                <i class="fas fa-clock text-warning"></i> 
                                <?= $stats['pending'] ?? 0 ?> در انتظار
                            </span>
                            <span class="badge bg-light text-dark ms-2">
                                <i class="fas fa-check-circle text-success"></i> 
                                <?= $stats['approved'] ?? 0 ?> تایید شده
                            </span>
                            <span class="badge bg-light text-dark ms-2">
                                <i class="fas fa-times-circle text-danger"></i> 
                                <?= $stats['rejected'] ?? 0 ?> رد شده
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-list"></i> 
                                <?= $stats['total'] ?? 0 ?> کل فروشنده ها
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <?php Pjax::begin([
                        'id' => 'admin-vendors-pjax',
                        'enablePushState' => false,
                        'timeout' => 5000,
                    ]) ?>
                    
                    <!-- فیلترها -->
                    <div class="filter-section mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select" id="status-filter" onchange="filterProducts()">
                                    <option value="">همه فروشنده ها</option>
                                    <option value="0">در انتظار تایید</option>
                                    <option value="1">تایید شده</option>
                                    <option value="2">رد شده</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="search-input" placeholder="جستجوی نام فروشنده..." onkeyup="searchProducts()">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                    <i class="fas fa-undo"></i> بازنشانی فیلترها
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- جدول فروشنده ها -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="vendors-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>تصویر</th>
                                    <th>نام فروشنده</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ ثبت</th>
                                    <th>دلیل رد درخواست</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($vendors): ?>
                                    <?php foreach ($vendors as $index => $vendor): ?>
                                        <tr id="vendor-row-<?= $vendor->id ?>" data-status="<?= $vendor->status ?>">
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <?php if ($vendor->image): ?>
                                                    <img src="<?= Yii::getAlias('@web/uploads/images/vendor/') . $vendor->image ?>" alt="<?= Html::encode($vendor->name) ?>" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= Html::encode($vendor->name) ?></strong>
                                            </td>
                                            <td>
                                                <?php 
                                                $statusClass = '';
                                                $statusText = '';
                                                switch($vendor->status) {
                                                    case 0:
                                                        $statusClass = 'warning';
                                                        $statusText = 'در انتظار';
                                                        break;
                                                    case 1:
                                                        $statusClass = 'success';
                                                        $statusText = 'تایید شده';
                                                        break;
                                                    case 2:
                                                        $statusClass = 'danger';
                                                        $statusText = 'رد شده';
                                                        break;
                                                    default:
                                                        $statusClass = 'secondary';
                                                        $statusText = 'نامشخص';
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
                                                        <?= Yii::$app->formatter->asDatetime($vendor->created_at, 'php:Y/m/d') ?>
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="far fa-clock"></i> 
                                                        <?= Yii::$app->formatter->asRelativeTime($vendor->created_at) ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                
                                                <div class="text-nowrap">
                                                    <small class="text-muted d-block">
                                                        <?php if($vendor->reject_message != null && $vendor->status != 1){?>
                                                        <i class="far fa-message"></i> 
                                                        <?= $vendor->reject_message ?>
                                                        <?php }?>
                                                    </small>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical gap-1" style="min-width: 100px;">
                                                    <?php if ($vendor->status == 0 || $vendor->status == 2): ?>
                                                        <button class="btn btn-success btn-sm" onclick="approveProduct(<?= $vendor->id ?>)">
                                                            <i class="fas fa-check"></i> تایید
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($vendor->status == 0 || $vendor->status == 1): ?>
                                                        <button class="btn btn-danger btn-sm message" value="<?= $vendor->id ?>">
                                                            <i class="fas fa-times"></i> رد
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <a class="btn btn-info btn-sm" href="<?= Url::to(['/admin/vendor/view', 'id' => $vendor->id]) ?>">
                                                        <i class="fas fa-eye"></i> مشاهده
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-box-open text-muted fs-1 mb-3 d-block"></i>
                                            <p class="text-muted mb-0">هیچ فروشندهی یافت نشد.</p>
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
                                <h6 class="text-primary">کل فروشنده ها</h6>
                                <h3 class="fw-bold"><?= $stats['total'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-warning bg-opacity-10 p-3 rounded-3">
                                <h6 class="text-warning">در انتظار تایید</h6>
                                <h3 class="fw-bold"><?= $stats['pending'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-success bg-opacity-10 p-3 rounded-3">
                                <h6 class="text-success">تایید شده</h6>
                                <h3 class="fw-bold"><?= $stats['approved'] ?? 0 ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card bg-danger bg-opacity-10 p-3 rounded-3">
                                <h6 class="text-danger">رد شده</h6>
                                <h3 class="fw-bold"><?= $stats['rejected'] ?? 0 ?></h3>
                            </div>
                        </div>
                    </div>

                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-card {
    transition: all 0.3s ease;
    cursor: default;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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

@media (max-width: 768px) {
    .table-responsive {
        font-size: 14px;
    }
    
    .btn-group-vertical {
        min-width: 80px !important;
    }
    
    .stat-card h3 {
        font-size: 1.5rem;
    }
}
</style>

<?php
Modal::begin([
    'id' => 'modal-up',
    'size' => 'modal-lg',
    'closeButton' => ['data-bs-dismiss' => 'modal'],
    'title' => '<i class="fas fa-user-times text-danger me-2"></i> رد درخواست فروشندگی'
]);
?>

<div id="modalAddToFactor" class="p-3">
    <div class="row g-3">
        <!-- اطلاعات کاربر -->
        <div class="col-md-5">
            <div class="bg-light p-3 rounded-3 h-100">
                <h6 class="fw-bold text-muted mb-3">
                    <i class="fas fa-user-circle me-1"></i> اطلاعات کاربر
                </h6>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2">
                        <i class="fas fa-user text-secondary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">نام(شرکت/فرد) فروشنده</small>
                        <span class="fw-semibold"><?= $vendor->name ?? 'نامشخص' ?></span>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2">
                        <i class="fas fa-envelope text-secondary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">ایمیل</small>
                        <span class="fw-semibold"><?= $vendor->توضیحات ?? 'نامشخص' ?></span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2">
                        <i class="fas fa-calendar text-secondary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">تاریخ ثبت</small>
                        <span class="fw-semibold"><?= $vendor->created_at ?? 'نامشخص' ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- فرم دلیل رد -->
        <div class="col-md-7">
            <div class="mb-3">
                <label for="message" class="form-label fw-bold text-danger">
                    <i class="fas fa-exclamation-triangle me-1"></i> 
                    دلیل رد درخواست
                </label>
                <textarea 
                    id="message" 
                    class="form-control border-danger" 
                    rows="5" 
                    placeholder="لطفاً دلیل رد درخواست را به صورت کامل و دقیق وارد کنید..."
                    style="resize: none;"
                ></textarea>
                <div class="mt-2">
                    <span class="badge bg-danger bg-opacity-10 text-danger">
                        <i class="fas fa-info-circle me-1"></i>
                        این پیام برای کاربر ارسال خواهد شد
                    </span>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> انصراف
                </button>
                <button id="messageBtn" class="btn btn-danger flex-fill">
                    <i class="fas fa-times-circle me-1"></i> رد درخواست
                </button>
            </div>
        </div>
    </div>
</div>

<style>
#message:focus {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15) !important;
}
#messageBtn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(220, 53, 69, 0.3);
}
</style>

<?php
Modal::end();
?>

<script>
    let productId = null
    $(document).on("click", '.message',function() {
        productId = $(this).val();
        var id = $(this).attr('value');
        $('#modal-up').addClass('in');
        $('#modal-up').modal('show');
    });
    $(document).on("click", '#messageBtn',function() {
        let message = $('#message').val();

        rejectProduct(productId, message);
    });

// تایید فروشنده
function approveProduct(id) {
    if (!confirm('آیا از تایید این فروشنده مطمئن هستید؟')) {
        return;
    }
    
    $.ajax({
         url: '<?= Url::to(['/admin/confirm-vendor/approve', 'id' => '']) ?>' + id,
         type: 'POST',
         // data: {id: id},
         dataType: 'json',
         success: function(response) {
             if (response.success) {
                 location.reload();
            } else {
                alert('خطا در تایید فروشنده');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        }
    });
}

// رد فروشنده
function rejectProduct(id ,message) {
    if (!confirm('آیا از رد این فروشنده مطمئن هستید؟')) {
        return;
    }
    $.ajax({
        url: '<?= Url::to(['/admin/confirm-vendor/reject', 'id' => '']) ?>' + id,
        type: 'POST',
        data: {message:message},
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('خطا در رد فروشنده');
            }
        },
error: function(xhr, status, error) {
    console.log(xhr.responseText);
    console.log(status);
    console.log(error);

    alert(xhr.responseText);
        }
    });
}

// فیلتر کردن فروشنده ها
function filterProducts() {
    const status = document.getElementById('status-filter').value;
    const rows = document.querySelectorAll('#vendors-table tbody tr');
    
    rows.forEach(row => {
        if (row.id && row.id.startsWith('vendor-row-')) {
            let show = true;
            if (status && row.dataset.status !== status) {
                show = false;
            }
            row.style.display = show ? '' : 'none';
        }
    });
}

// جستجو در فروشنده ها
function searchProducts() {
    const searchText = document.getElementById('search-input').value.toLowerCase();
    const rows = document.querySelectorAll('#vendors-table tbody tr');
    
    rows.forEach(row => {
        if (row.id && row.id.startsWith('vendor-row-')) {
            const vendorName = row.querySelector('td:nth-child(3) strong')?.textContent?.toLowerCase() || '';
            const vendorCode = row.querySelector('td:nth-child(3) small')?.textContent?.toLowerCase() || '';
            
            if (vendorName.includes(searchText) || vendorCode.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

// بازنشانی فیلترها
function resetFilters() {
    document.getElementById('status-filter').value = '';
    document.getElementById('search-input').value = '';
    
    const rows = document.querySelectorAll('#vendors-table tbody tr');
    rows.forEach(row => {
        if (row.id && row.id.startsWith('vendor-row-')) {
            row.style.display = '';
        }
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