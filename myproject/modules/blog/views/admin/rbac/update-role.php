<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $role yii\rbac\Role */
/* @var $permissions yii\rbac\Permission[] */
/* @var $rolePermissions array */

$this->title = 'ویرایش نقش: ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت نقش‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $role->name, 'url' => ['view-role', 'name' => $role->name]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>

<div class="rbac-update-role">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-warning text-dark p-4">
            <h4 class="mb-0">
                <i class="fas fa-edit"></i> <?= $this->title ?>
            </h4>
        </div>
        
        <div class="card-body p-4">
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'options' => ['class' => 'form-horizontal'],
            ]); ?>
            
            <div class="row">
                <div class="col-md-8">
                    <!-- نام نقش (غیرقابل تغییر) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-tag text-primary"></i> نام نقش
                        </label>
                        <div class="form-control form-control-lg bg-light">
                            <strong><?= Html::encode($role->name) ?></strong>
                            <span class="text-muted small">(قابل تغییر نیست)</span>
                        </div>
                        <div class="form-text">برای تغییر نام نقش، باید نقش جدید ایجاد کنید.</div>
                    </div>
                    
                    <!-- توضیحات -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">
                            <i class="fas fa-info-circle text-info"></i> توضیحات
                        </label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="3"><?= $role->description ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-info-circle text-primary"></i> اطلاعات نقش
                            </h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2">
                                    <i class="fas fa-calendar-alt text-muted"></i> 
                                    تاریخ ایجاد: <?= $role->createdAt ? date('Y/m/d H:i', $role->createdAt) : '-' ?>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-users text-muted"></i> 
                                    تعداد کاربران: 
                                    <?= count(Yii::$app->authManager->getUserIdsByRole($role->name)) ?>
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
                <p class="text-muted small">دسترسی‌های این نقش را انتخاب یا لغو انتخاب کنید.</p>
                
                <div class="row">
                    <?php if ($permissions): ?>
                        <?php foreach ($permissions as $permission): ?>
                            <div class="col-md-4 col-lg-3 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="perm-<?= $permission->name ?>" 
                                           name="permissions[]" 
                                           value="<?= $permission->name ?>"
                                           <?= in_array($permission->name, $rolePermissions) ? 'checked' : '' ?>>
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
                                هیچ دسترسی‌ای تعریف نشده است.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- دکمه‌ها -->
            <div class="mt-4 pt-3 border-top">
                <?= Html::submitButton(
                    '<i class="fas fa-save"></i> ذخیره تغییرات',
                    ['class' => 'btn btn-warning btn-lg px-5']
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