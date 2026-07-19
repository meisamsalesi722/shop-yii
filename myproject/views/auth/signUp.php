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
        <h3 class="mb-4 fw-light text-secondary">Create Account</h3>
        
        <?= $form->field($model, 'mobile', [
            'inputOptions' => [
                'class' => 'form-control form-control-lg rounded-pill px-4',
                'placeholder' => 'Enter your mobile number 01234567890'
            ],
            'labelOptions' => ['class' => 'fw-semibold text-start w-100 ps-2']
        ])->textInput(['autofocus' => true]) ?>
        
        <div class="mt-4">
            <?= Html::submitButton('Register', [
                'class' => 'btn btn-success btn-lg rounded-pill px-5 w-100',
                'style' => 'letter-spacing: 1px;'
            ]) ?>
        </div>
        

    </div>
</div>
<?php ActiveForm::end(); ?>