<?php

use yii\helpers\Html;

/* @var $permission yii\rbac\Permission */
/* @var $roles yii\rbac\Role[] */

$this->title = 'مشاهده دسترسی: ' . $permission->name;
$this->params['breadcrumbs'][] = ['label' => 'مدیریت RBAC', 'url' => ['index']];
$this->params['breadcrumbs'][] = $permission->name;
?>

<div class="permission-view">

    <div class="d-flex justify-content-between mb-3">
        <h3><?= Html::encode($permission->name) ?></h3>

        <div>
            <?= Html::a(
                'ویرایش',
                ['update-permission', 'name' => $permission->name],
                ['class' => 'btn btn-primary']
            ) ?>

            <?= Html::a(
                'حذف',
                ['delete-permission', 'name' => $permission->name],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'method' => 'post',
                        'confirm' => 'آیا از حذف این دسترسی مطمئن هستید؟'
                    ]
                ]
            ) ?>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <tr>
            <th width="200">نام</th>
            <td><?= Html::encode($permission->name) ?></td>
        </tr>

        <tr>
            <th>توضیحات</th>
            <td><?= Html::encode($permission->description ?: '-') ?></td>
        </tr>

        <tr>
            <th>تاریخ ایجاد</th>
            <td><?= $permission->createdAt ? date('Y-m-d H:i', $permission->createdAt) : '-' ?></td>
        </tr>

        <tr>
            <th>آخرین بروزرسانی</th>
            <td><?= $permission->updatedAt ? date('Y-m-d H:i', $permission->updatedAt) : '-' ?></td>
        </tr>
    </table>

    <h4>نقش‌هایی که این دسترسی را دارند</h4>

    <?php if ($roles): ?>

        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>نام نقش</th>
                    <th>توضیحات</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($roles as $role): ?>

                <tr>
                    <td>
                        <?= Html::a(
                            $role->name,
                            ['view-role', 'name' => $role->name]
                        ) ?>
                    </td>

                    <td><?= Html::encode($role->description) ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    <?php else: ?>

        <div class="alert alert-warning">
            این دسترسی هنوز به هیچ نقشی اختصاص داده نشده است.
        </div>

    <?php endif; ?>

</div>