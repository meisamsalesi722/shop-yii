<?php

use app\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\ticket\models\Ticket;

/** @var yii\web\View $this */
/** @var app\modules\ticket\models\Ticket $model */
/** @var yii\widgets\ActiveForm $form */
?>

        <div class="ticket-chat-container">
            
            <div class="ticket-header mb-3 p-3 bg-light rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= Html::encode($model->subject) ?></h4>
                    <span class="badge <?= $model->status == 'closed' ? 'bg-secondary' : 'bg-success' ?>">
                        <?= Html::encode($model->status) ?>
                    </span>
                </div>
                <small class="text-muted">
                    <i class="fa fa-clock"></i> 
                    ایجاد شده: <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                </small>
            </div>

            <div class="chat-messages p-3" style="max-height: 50vh; overflow-y: auto; background: #f8f9fa; border-radius: 10px;">
                
                <div class="chat-message mb-3 d-flex">
                    <div class="message-avatar me-2">
                        <?php $user = User::findOne($model->user_id) ?>
                    <?= Html::img( Yii::getAlias('@web/uploads/images/') . ($user->avatar ?? 'images.png'), [
                        'class' => 'rounded-circle border border-4 border-white shadow',
                        'style' => 'width: 40px; height: 40px; object-fit: cover;',
                        'alt' => 'Avatar'
                    ]) ?>
                    </div>
                    <div class="message-content p-3 rounded" style="max-width: 70%; background: #e9ecef;">
                        <div class="message-header d-flex justify-content-between align-items-center mb-1">
                            <strong><?= Html::encode($model->user->username ?? 'کاربر') ?></strong>
                            <small class="text-muted ms-2">
                                <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                            </small>
                        </div>
                        <div class="message-body">
                            <?= nl2br(Html::encode($model->description)) ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($children)): ?>
<?php foreach ($children as $child): ?>
    <?php 
    $isAdmin = $child->is_admin ?? false;
    
    $images = json_decode($child->image, true);
    $files = json_decode($child->file, true);
    
    if (!is_array($images) && !empty($child->image)) {
        $images = [$child->image];
    }
    if (!is_array($files) && !empty($child->file)) {
        $files = [$child->file];
    }
    ?>
    
    <div class="chat-message mb-3 d-flex <?= $isAdmin ? 'flex-row-reverse' : '' ?>">
        <div class="message-avatar mx-2">
            <?php if ($isAdmin): ?>
                <i class="fas fa-headset fa-2x text-primary"></i>
            <?php else: ?>
                <?php $user = User::findOne($model->user_id) ?>
                <?= Html::img( Yii::getAlias('@web/uploads/images/') . ($user->avatar ?? 'images.png'), [
                                        'class' => 'rounded-circle border border-4 border-white shadow',
                                        'style' => 'width: 40px; height: 40px; object-fit: cover;',
                                        'alt' => 'Avatar'
                                    ]) ?>
            <?php endif; ?>
        </div>
        
        <div class="message-content p-3 rounded" style="max-width: 70%; <?= $isAdmin ? 'background: #d1e7ff;' : 'background: #e9ecef;' ?>">
            <div class="message-header d-flex justify-content-between align-items-center mb-1">
                <strong>
                    <?= $isAdmin ? 'پشتیبانی' : Html::encode($child->user->username ?? 'کاربر') ?>
                    <?php if ($isAdmin): ?>
                        <i class="fas fa-circle-check text-primary ms-1" style="font-size: 14px;"></i>
                    <?php endif; ?>
                </strong>
                <small class="text-muted ms-2">
                    <?= Yii::$app->formatter->asDatetime($child->created_at) ?>
                </small>
            </div>
            
            <?php if (!empty($files) && is_array($files)): ?>
                <div class="message-body mb-3">
                    <div class="file-attachments d-flex flex-wrap gap-2">
                        <?php foreach ($files as $file): ?>
                            <?= Html::a(
                                '📄 ' . Html::encode($file),
                                Yii::getAlias('@web/uploads/file/ticket/') . $file,
                                [
                                    'target' => '_blank',
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'download' => $file
                                ]
                            ); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;?>

            <?php if (!empty($images) && is_array($images)): ?>
                <div class="message-body mb-3">
                    <div class="image-gallery">
                        <?php if (count($images) == 1): ?>
                            <a href="<?= Yii::getAlias('@web/uploads/images/ticket/') . $images[0] ?>" 
                               target="_blank" 
                               class="d-block">
                                <img src="<?= Yii::getAlias('@web/uploads/images/ticket/') . $images[0] ?>" 
                                     class="img-fluid rounded single-image" 
                                     style="max-height: 200px; width: auto; cursor: pointer; border: 1px solid #ddd;"
                                     alt="تصویر">
                            </a>
                        <?php else: ?>
                            <div class="row g-2">
                                <?php foreach ($images as $index => $image): ?>
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <a href="<?= Yii::getAlias('@web/uploads/images/ticket/') . $image ?>" 
                                           target="_blank" 
                                           class="d-block image-link">
                                            <img src="<?= Yii::getAlias('@web/uploads/images/ticket/') . $image ?>" 
                                                 class="img-fluid rounded" 
                                                 style="width: 100%; height: 150px; object-fit: cover; border: 1px solid #ddd; transition: transform 0.2s;"
                                                 alt="تصویر <?= $index + 1 ?>"
                                                 loading="lazy"
                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                 onmouseout="this.style.transform='scale(1)'">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif;?>

            <!-- متن پیام -->
            <div class="message-body">
                <?= nl2br(Html::encode($child->description ?? $child->content)) ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
                <?php endif; ?>

                <?php if (empty($children)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-comment-dots fa-3x mb-2" style="opacity: 0.3;"></i>
                        <p>هنوز پاسخی ثبت نشده است</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="chat-input-section mt-3 p-3 bg-white rounded border">
                <?php if ($model->status != Ticket::STATUS_CLOSE): ?>
                    <?php $form = ActiveForm::begin([
                        'action' =>  Url::to(['/ticket/admin/ticket/create', 'id' => $model->id]),
                        'options' => 
                            [
                            'enctype' => 'multipart/form-data'
                            ]

                    ])?>
                        <div class="input-group">
                            <?= Html::submitButton('<i class="fa fa-paper-plane"></i> ارسال', ['class' => 'btn btn-success' ,'style' => 'border-radius:0 15px 15px 0']) ?>
                            <textarea name="reply_content" class="form-control" rows="2" placeholder="پاسخ خود را بنویسید..."></textarea>
                            <?= $form->field($model , 'fileInput[]')->fileInput([
                                'class' => 'd-none',
                                'multiple' => true
                            ])->label('<i class="fa-solid fa-file"></i>' , [
                                'class' => 'btn btn-sm btn-outline-info h-100',
                                'style' => 'border-radius:0 0 0 0'

                            ]) ?>

                            <?= $form->field($model , 'imageInput[]')->fileInput([
                                'multiple' => true, 'accept' => 'image/*',
                                'class' => 'd-none',
                            ])->label('<i class="fa-solid fa-paperclip"></i>' , [
                                'class' => 'btn btn-sm btn-info h-100',
                                'style' => 'border-radius:15px 0 0 15px'

                            ]) ?>
                            <?php ActiveForm::end()?>
                        </div>
                    <!-- </form> -->
                <?php else: ?>
                    <div class="alert alert-secondary mb-0 text-center">
                        <i class="fa fa-lock"></i> این تیکت بسته شده است و نمی‌توان پاسخ داد
                    </div>
                <?php endif; ?>
            </div>

            <!-- دکمه‌های عملیاتی -->
            <div class="ticket-actions mt-3 d-flex gap-2">
                
                <?= Html::a('<i class="fa fa-arrow-right"></i> بازگشت به لیست', 
                    ['/ticket/admin/ticket'], 
                    ['class' => 'btn btn-outline-primary']
                ) ?>
                <?= Html::a('<i class="fa fa-close"></i> بستن تیکت', 
                    ['/ticket/admin/ticket/reject' , 'id' => $model->id], 
                    ['class' => 'btn btn-danger']
                ) ?>

                <?= Html::a(' ارجاع به <i class="fa fa-arrow-alt-circle-left"></i>  ', 
                    ['/ticket/admin/ticket/referral' , 'id' => $model->id], 
                    ['class' => 'btn btn-info']
                ) ?>
            </div>
        </div>