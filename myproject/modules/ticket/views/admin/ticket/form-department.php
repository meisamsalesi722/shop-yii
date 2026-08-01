
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\ticket\models\Department; 


$this->title = 'Create Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    :root {
        --primary-color: #4e73df;
        --success-color: #1cc88a;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --info-color: #36b9cc;
    }

    body {
        background: #f8f9fc;
        font-family: 'Vazir', 'Tahoma', sans-serif;
    }

    .page-content {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .breadcrumb-page {
        background: white;
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-item.active {
        color: #5a5c69;
    }

    .content-in {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f2f7;
    }

    .form-header i {
        font-size: 28px;
        color: var(--primary-color);
        background: #e8f0fe;
        padding: 12px;
        border-radius: 12px;
    }

    .form-header h3 {
        margin: 0;
        font-weight: 700;
        color: #2d3748;
    }

    .form-header p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label .required {
        color: var(--danger-color);
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger-color);
    }

    .invalid-feedback {
        font-size: 0.85rem;
        margin-top: 6px;
    }

    /* Department Select Cards */
    .department-options {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 5px;
    }

    .department-option {
        position: relative;
    }

    .department-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .department-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 18px 12px;
        background: #f8f9fc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        min-height: 80px;
        gap: 8px;
    }

    .department-option label i {
        font-size: 28px;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .department-option label span {
        font-size: 0.9rem;
        font-weight: 500;
        color: #2d3748;
    }

    .department-option input[type="radio"]:checked + label {
        background: #e8f0fe;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
    }

    .department-option input[type="radio"]:checked + label i {
        color: var(--primary-color);
    }

    .department-option label:hover {
        transform: translateY(-2px);
        border-color: var(--primary-color);
        background: #f0f4ff;
    }

    /* Department colors for icons */
    .dept-blue i { color: #4e73df; }
    .dept-green i { color: #1cc88a; }
    .dept-yellow i { color: #f6c23e; }
    .dept-red i { color: #e74a3b; }
    .dept-cyan i { color: #36b9cc; }
    .dept-purple i { color: #6f42c1; }
    .dept-pink i { color: #e83e8c; }
    .dept-orange i { color: #fd7e14; }

    .department-option input[type="radio"]:checked + label.dept-blue { border-color: #4e73df; background: #e8f0fe; }
    .department-option input[type="radio"]:checked + label.dept-green { border-color: #1cc88a; background: #e2f3e6; }
    .department-option input[type="radio"]:checked + label.dept-yellow { border-color: #f6c23e; background: #fef9e7; }
    .department-option input[type="radio"]:checked + label.dept-red { border-color: #e74a3b; background: #fde8e8; }
    .department-option input[type="radio"]:checked + label.dept-cyan { border-color: #36b9cc; background: #e5f6f9; }
    .department-option input[type="radio"]:checked + label.dept-purple { border-color: #6f42c1; background: #f0ebf8; }
    .department-option input[type="radio"]:checked + label.dept-pink { border-color: #e83e8c; background: #fce4ec; }
    .department-option input[type="radio"]:checked + label.dept-orange { border-color: #fd7e14; background: #fef0e5; }

    .btn-submit {
        background: var(--primary-color);
        color: white;
        padding: 12px 40px;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1rem;
    }

    .btn-submit:hover {
        background: #2e59d9;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(78, 115, 223, 0.3);
        color: white;
    }

    .btn-submit i {
        margin-left: 8px;
    }

    .btn-cancel {
        background: #e2e8f0;
        color: #4a5568;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #cbd5e0;
        color: #2d3748;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f2f7;
    }

    .form-actions .btn {
        flex: 1;
    }

    @media (max-width: 768px) {
        .content-in {
            padding: 20px 15px;
        }

        .department-options {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }

        .form-header {
            flex-direction: column;
            text-align: center;
        }
    }

    /* Yii2 Validation Styles */
    .has-error .form-control,
    .has-error .form-select {
        border-color: var(--danger-color);
    }

    .has-error .help-block {
        color: var(--danger-color);
        font-size: 0.85rem;
        margin-top: 6px;
    }

    .field-ticket-department_id .help-block {
        display: none;
    }
</style>

<div class="page-content">


    <!-- Content -->
    <div class="content-in">
        <div class="form-header">
            <i class="fas fa-ticket-alt"></i>
            <div>
                <h3>ارجاع به دپارتمان دیگر</h3>
                <p>لطفاً دپارتمان مورد نظر را انتخاب کنید.</p>
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'ticket-form',
            'options' => ['class' => 'ticket-form'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback'],
            ],
        ]); ?>

        <!-- Department Selection -->
        <div class="form-group">
            <?= $form->field($model, 'department_id', [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
                'options' => ['class' => 'form-group'],
            ])->hiddenInput()->label(false) ?>

            <label class="form-label">
                <i class="fas fa-building"></i> دپارتمان <span class="required">*</span>
            </label>

            <!-- Radio Card Options -->
            <div class="department-options">
                <?php 
                // دریافت لیست دپارتمان‌ها از مدل
                $departments = Department::find()->all();
                $defaultDept = $model->department_id ?? null;
                $firstDept = !empty($departments) ? $departments[0]->id : null;
                ?>
                
                <?php foreach ($departments as $index => $department): ?>
                    <div class="department-option">
                        <input type="radio" 
                               name="Ticket[department_id]" 
                               id="dept-<?= $department->id ?>" 
                               value="<?= $department->id ?>"
                               <?= ($defaultDept == $department->id || ($defaultDept === null && $index === 0)) ? 'checked' : '' ?>
                               <?= $model->getErrors('department_id') ? 'data-error="true"' : '' ?>>
                        <label for="dept-<?= $department->id ?>" class="dept-<?= $department->color ?? 'blue' ?>">
                            <i class="fas <?= $department->icon ?? 'fa-building' ?>"></i>
                            <span><?= Html::encode($department->title) ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Error Display for Department -->
            <?php if ($model->getErrors('department_id')): ?>
                <div class="help-block invalid-feedback" style="display: block;">
                    <?= $model->getFirstError('department_id') ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <?= Html::a(
                '<i class="fas fa-times"></i> انصراف',
                ['index'],
                ['class' => 'btn btn-cancel', 'style' => 'text-decoration: none; text-align: center;']
            ) ?>
            
            <?= Html::submitButton(
                '<i class="fas fa-paper-plane"></i> ثبت',
                ['class' => 'btn btn-submit']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
// اضافه کردن JavaScript برای مدیریت انتخاب دپارتمان
$this->registerJs("
    $(document).ready(function() {
        // هنگامی که یک رادیو انتخاب می‌شود، مقدار department_id را به‌روز رسانی کن
        $('input[name=\"Ticket[department_id]\"]').on('change', function() {
            // خطاهای قبلی را پاک کن
            $('.field-ticket-department_id .help-block').remove();
            $('.field-ticket-department_id .form-control').removeClass('is-invalid');
            $('.department-options .has-error').removeClass('has-error');
        });

        // اعتبارسنجی در سمت کلاینت برای department
        $('#ticket-form').on('beforeValidate', function(event, messages) {
            var deptSelected = $('input[name=\"Ticket[department_id]\"]:checked').length > 0;
            if (!deptSelected) {
                messages['department_id'] = ['لطفاً یک دپارتمان انتخاب کنید'];
                return false;
            }
            return true;
        });
    });
");
?>