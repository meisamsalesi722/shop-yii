<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $permissions yii\rbac\Permission[] */

$this->title = 'ایجاد نقش جدید';
$this->params['breadcrumbs'][] = ['label' => 'مدیریت نقش‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rbac-create-role">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-success text-white p-4">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle"></i> <?= $this->title ?>
            </h4>
        </div>
        
        <div class="card-body p-4">
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'options' => ['class' => 'form-horizontal'],
            ]); ?>
            
            <div class="row">
                <div class="col-md-8">
                    <!-- نام نقش -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">
                            <i class="fas fa-tag text-primary"></i> نام نقش <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="name" 
                               name="name" 
                               placeholder="مثلاً: manager, author, moderator"
                               required>
                        <div class="form-text">نام نقش باید به انگلیسی و بدون فاصله باشد.</div>
                    </div>
                    
                    <!-- توضیحات -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">
                            <i class="fas fa-info-circle text-info"></i> توضیحات
                        </label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="توضیحات مربوط به این نقش را وارد کنید..."></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-info-circle text-primary"></i> راهنما
                            </h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> 
                                    نام نقش باید یکتا باشد
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> 
                                    از حروف کوچک انگلیسی استفاده کنید
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> 
                                    برای چند کلمه از خط تیره استفاده کنید
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> 
                                    مثال: <code>content-manager</code>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- دسترسی‌ها -->
            <div class="mt-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-key text-warning"></i> دسترسی‌های این نقش
                </h5>
                <p class="text-muted small">دسترسی‌هایی که این نقش به آنها دسترسی خواهد داشت را انتخاب کنید.</p>
                
                <div class="row">
                    <?php if ($permissions): ?>
                        <?php foreach ($permissions as $permission): ?>
                            <div class="col-md-4 col-lg-3 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="perm-<?= $permission->name ?>" 
                                           name="permissions[]" 
                                           value="<?= $permission->name ?>">
                                    <label class="form-check-label" for="perm-<?= $permission->name ?>">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?= Html::encode($permission->name) ?>
                                        </span>
                                        <?php if ($permission->description): ?>
                                            <br>
                                            <small class="text-muted"><?= Html::encode($permission->description) ?></small>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 
                                هیچ دسترسی‌ای تعریف نشده است. ابتدا دسترسی‌ها را ایجاد کنید.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- دکمه‌ها -->
            <div class="mt-4 pt-3 border-top">
                <?= Html::submitButton(
                    '<i class="fas fa-save"></i> ایجاد نقش',
                    ['class' => 'btn btn-success btn-lg px-5']
                ) ?>
                
                <?= Html::a(
                    '<i class="fas fa-times"></i> انصراف',
                    ['index'],
                    ['class' => 'btn btn-secondary btn-lg px-4 ms-2']
                ) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- استایل‌ها -->
<style>
.form-check {
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s;
}

.form-check:hover {
    background-color: #f8f9fa;
}

.form-check-input:checked + .form-check-label .badge {
    background-color: #0d6efd !important;
    color: white !important;
}

.badge.bg-opacity-10 {
    background-color: rgba(13, 110, 253, 0.1);
}
</style>

<!-- اسکریپت‌ها -->
<script>
// انتخاب/لغو انتخاب همه دسترسی‌ها (اختیاری)
document.addEventListener('DOMContentLoaded', function() {
    // می‌توانید دکمه Select All اضافه کنید
    const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
    
    // بررسی اینکه آیا همه انتخاب شده‌اند
    function checkAllSelected() {
        const checked = document.querySelectorAll('input[name="permissions[]"]:checked');
        return checked.length === checkboxes.length;
    }
});
</script>