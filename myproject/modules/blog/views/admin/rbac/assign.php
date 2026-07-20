<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $users app\models\User[] */
/* @var $roles yii\rbac\Role[] */

$this->title = 'تخصیص نقش به کاربران';
$this->params['breadcrumbs'][] = ['label' => 'مدیریت نقش‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rbac-assign">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-primary text-white p-4">
            <h4 class="mb-0">
                <i class="fas fa-user-cog"></i> <?= $this->title ?>
            </h4>
        </div>
        
        <div class="card-body p-4">
            <?php Pjax::begin(['id' => 'assign-pjax']) ?>
            
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>کاربر</th>
                            <th>نقش‌های فعلی</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                            <?php 
                            $auth = Yii::$app->authManager;
                            $userRoles = $auth->getRolesByUser($user->id);
                            ?>
                            <tr id="user-<?= $user->id ?>">
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <strong><?= Html::encode($user->username) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= Html::encode($user->email) ?></small>
                                </td>
                                <td>
                                    <?php if ($userRoles): ?>
                                        <?php foreach ($userRoles as $role): ?>
                                            <span class="badge bg-primary me-1">
                                                <?= Html::encode($role->name) ?>
                                                <button class="btn btn-sm btn-link text-white p-0 ms-1" 
                                                        onclick="revokeRole(<?= $user->id ?>, '<?= $role->name ?>')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">بدون نقش</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <select class="form-select form-select-sm role-select" 
                                                data-user-id="<?= $user->id ?>"
                                                style="width: 150px;">
                                            <option value="">انتخاب نقش...</option>
                                            <?php foreach ($roles as $role): ?>
                                                <option value="<?= $role->name ?>">
                                                    <?= Html::encode($role->name) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="btn btn-success btn-sm" 
                                                onclick="assignRole(<?= $user->id ?>)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<script>
// اختصاص نقش
function assignRole(userId) {
    const select = document.querySelector(`.role-select[data-user-id="${userId}"]`);
    const roleName = select.value;
    
    if (!roleName) {
        alert('لطفاً یک نقش را انتخاب کنید.');
        return;
    }
    
    $.ajax({
        url: '/blog/admin/rbac/assign-role',
        type: 'POST',
        data: {
            user_id: userId,
            role_name: roleName
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('خییییطا در ارتباط با سرور.');
        }
    });
}

// لغو نقش
function revokeRole(userId, roleName) {
    if (!confirm(`آیا از لغو نقش "${roleName}" از این کاربر مطمئن هستید؟`)) {
        return;
    }
    
    $.ajax({
        url: '/blog/admin/rbac/revoke-role',
        type: 'POST',
        data: {
            user_id: userId,
            role_name: roleName
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور.');
        }
    });
}
</script>