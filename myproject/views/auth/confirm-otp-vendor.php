<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'w-100']
]); ?>
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-md-6 col-lg-4 text-center p-4 bg-light rounded-4 shadow-lg">
        <h4 class="mb-3 fw-light text-secondary">
            <i class="bi bi-shield-lock"></i> Verification
        </h4>
        <p class="text-muted small mb-4">Enter the 6-digit code sent to your mobile</p>
        
        <div class="mb-3 text-start">
            <label for="otp" class="form-label fw-semibold text-secondary">
                <i class="bi bi-key"></i> Enter verification code
            </label>
            <input type="number" name="otp" id="otp" 
                   class="form-control form-control-lg text-center rounded-pill py-3"
                   placeholder="______"
                   style="font-size: 2rem; letter-spacing: 8px; font-weight: 300;"
                   maxlength="6"
                   autofocus>
            <div class="form-text text-center mt-2">
                <small>Didn't receive code? <a href="#" class="text-primary">Resend</a></small>
            </div>
        </div>

        <div class="mt-4">
            <?= Html::submitButton('Verify & Register', [
                'class' => 'btn btn-success btn-lg rounded-pill px-5 w-100',
                'style' => 'letter-spacing: 1px; font-weight: 500;'
            ]) ?>
        </div>
        
        <div class="mt-3">
            <?= Html::a('← Back to Login', Url::to('/login-register'), [
                'class' => 'text-decoration-none text-secondary small'
            ]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>