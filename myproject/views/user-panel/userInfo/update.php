<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<!-- start page-content -->
<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/index']) ?>">صفحه اصلی</a></li>
                <li class="breadcrumb-item active" aria-current="page">اطلاعات کاربر</li>
            </ol>
        </nav>
    </div>

    <div class="content-in">
        <!-- User Profile Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-gradient-primary py-3">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">پروفایل کاربر</h5>
                        <small class="">ویرایش اطلاعات شخصی</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'user-profile-form']
                ]); ?>

                <!-- Avatar/Profile Picture -->
                <div class="text-center mb-4">
                    <div class="profile-avatar position-relative d-inline-block">

                        <?= Html::img(Yii::getAlias('@web/uploads/images/') . ($userModel->avatar ?? 'images.png'), [
                            'class' => 'rounded-circle border border-3 border-primary',
                            'style' => 'width: 120px; height: 120px; object-fit: cover;',
                            'alt' => 'Avatar'
                        ]) ?>

                        
                        <?= $form->field($model , 'imageFile')->fileInput([
                            'class' => 'd-none'
                        ])->label('<span class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-white" style="width: 35px; height: 35px; cursor: pointer;">
                            <i class="fas fa-camera text-white" style="font-size: 14px;"></i>
                        </span>') ?>
                        
                    </div>
                    <h5 class="mt-3 mb-0 fw-bold"><?= Html::encode($userModel->username) ?></h5>
                    <small class="text-muted">عضویت از تاریخ <?= $userModel->created_at ?></small>
                </div>

                <hr class="my-4">

                <!-- Form Fields -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <?= $form->field($model, 'username', [
                            'options' => ['class' => 'mb-3'],
                            'template' => '{label}<div class="input-group">{input}</div>{error}'
                        ])->textInput([
                            'value' => $userModel->username,
                            'maxlength' => true,
                            'class' => 'form-control form-control-lg',
                            'placeholder' => 'نام کاربری خود را وارد کنید'
                        ])->label('نام کاربری : ', ['class' => 'fw-bold text-muted']) ?>
                    </div>

                    <!-- <div class="col-md-6">
                        <?php //$form->field($model, 'mobile', [
                            //'options' => ['class' => 'mb-3'],
                            //'template' => '{label}<div class="input-group">{input}</div>{error}'
                        //])->textInput([
                         //   'value' => $userModel->mobile,
                          //  'maxlength' => true,
                          //  'class' => 'form-control form-control-lg',
                           // 'placeholder' => '۰۹۱۲۳۴۵۶۷۸۹',
                           // 'dir' => 'ltr'
                       // ])->label('شماره موبایل : ', ['class' => 'fw-bold text-muted']) ?>
                    </div> -->

                    <div class="col-md-6">
                        <?= $form->field($model, 'email', [
                            'options' => ['class' => 'mb-3'],
                            'template' => '{label}<div class="input-group">{input}</div>{error}'
                        ])->textInput([
                            'value' => $userModel->email,
                            'maxlength' => true,
                            'class' => 'form-control form-control-lg',
                            'placeholder' => 'example@gmail.com',
                            'dir' => 'ltr'
                        ])->label('ایمیل : ', ['class' => 'fw-bold text-muted']) ?>
                    </div>


                </div>

                <!-- Additional Info -->
                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <div class="info-box bg-light p-3 rounded-3 text-center">
                            <i class="fas fa-calendar-check text-primary fa-2x"></i>
                            <h6 class="mt-2 mb-0">تاریخ ثبت نام</h6>
                            <small class="text-muted"><?= $userModel->created_at ?></small>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="form-group mt-4 pt-3 border-top">
                    <div class="d-flex gap-2">
                        <?= Html::submitButton('<i class="fas fa-save me-2"></i> ذخیره اطلاعات', [
                            'class' => 'btn btn-success btn-lg px-5',
                            'style' => 'border-radius: 10px;'
                        ]) ?>

                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light py-3">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>آخرین فعالیت‌ها</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span><i class="fas fa-edit text-primary me-2"></i>ویرایش پروفایل</span>
                        <small class="text-muted">۲ ساعت پیش</small>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span><i class="fas fa-shopping-cart text-warning me-2"></i>ثبت سفارش</span>
                        <small class="text-muted">دیروز</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end page-content -->