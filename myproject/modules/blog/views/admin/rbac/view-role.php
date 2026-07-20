<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $role yii\rbac\Role */
/* @var $permissions yii\rbac\Permission[] */
/* @var $users app\models\User[] */

$this->title = 'جزئیات نقش: ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت نقش‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rbac-view-role">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-info text-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-user-tag"></i> <?= $this->title ?>
                </h4>
                <div>
                    <?= Html::a(
                        '<i class="fas fa-edit"></i> ویرایش',
                        ['update-role', 'name' => $role->name],
                        ['class' => 'btn btn-light btn-sm']
                    ) ?>
                    <?= Html::a(
                        '<i class="fas fa-trash"></i> حذف',
                        ['delete-role', 'name' => $role->name],
                        [
                            'class' => 'btn btn-danger btn-sm',
                            'data-confirm' => 'آیا از حذف این نقش مطمئن هستید؟',
                            'data-method' => 'post',
                        ]
                    ) ?>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4">
            <?= DetailView::widget([
                'model' => $role,
                'attributes' => [
                    [
                        'attribute' => 'name',
                        'label' => 'نام نقش',
                        'value' => '<span class="badge bg-primary">' . Html::encode($role->name) . '</span>',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'توضیحات',
                        'value' => $role->description ?? 'بدون توضیحات',
                    ],
                    [
                        'attribute' => 'createdAt',
                        'label' => 'تاریخ ایجاد',
                        'value' => $role->createdAt ? date('Y/m/d H:i', $role->createdAt) : '-',
                    ],
                ],
            ]) ?>
            
            <!-- دسترسی‌ها -->
            <div class="mt-4">
                <h5 class="fw-bold">
                    <i class="fas fa-key text-warning"></i> دسترسی‌های این نقش
                </h5>
                <div class="row mt-3">
                    <?php if ($permissions): ?>
                        <?php foreach ($permissions as $permission): ?>
                            <div class="col-md-3 mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success p-2">
                                    <i class="fas fa-check-circle"></i> 
                                    <?= Html::encode($permission->name) ?>
                                    <?php if ($permission->description): ?>
                                        <br>
                                        <small class="text-muted"><?= Html::encode($permission->description) ?></small>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">این نقش هیچ دسترسی‌ای ندارد.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- کاربران دارای این نقش -->
            <div class="mt-4">
                <h5 class="fw-bold">
                    <i class="fas fa-users text-primary"></i> کاربران دارای این نقش
                </h5>
                <div class="row mt-3">
                    <?php if ($users): ?>
                        <?php foreach ($users as $user): ?>
                            <div class="col-md-3 mb-2">
                                <span class="badge bg-info bg-opacity-10 text-info p-2">
                                    <i class="fas fa-user"></i> 
                                    <?= Html::encode($user->username) ?>
                                    <br>
                                    <small class="text-muted"><?= Html::encode($user->email) ?></small>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">هیچ کاربری این نقش را ندارد.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mt-4">
                <?= Html::a(
                    '<i class="fas fa-arrow-right"></i> بازگشت به لیست نقش‌ها',
                    ['index'],
                    ['class' => 'btn btn-secondary']
                ) ?>
            </div>
        </div>
    </div>
</div>