<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<?php $form = ActiveForm::begin(); ?>
<div class="row justify-content-center mt-5">
    <div class="col-6 text-center ">
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <div>
            <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
        </div>
        <a href="<?= Url::to('/site/login') ?>" class="mt-3">login</a>


    </div>
</div>



<?php ActiveForm::end(); ?>