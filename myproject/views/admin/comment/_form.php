<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Comment $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comment-form">

      <section class="card mb-3">
        <section class="card-header text-white bg-custom-yellow">
          <?= $comment->user->username ?> - <?= $comment->user->id ?>
        </section>
        <section class="card-body">
          <p class="card-text"><?= $comment->comment ?></p>
        </section>
      </section>
<?php if($comment->parent == null){?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php }?>
</div>
