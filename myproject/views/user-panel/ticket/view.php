<?php

use app\models\Ticket;
use Dom\Comment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */ // تیکت اصلی (پدر)
/* @var $children app\models\Ticket[] */ // پاسخ‌ها (فرزندان)
?>

<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/index']) ?>">صفحه اصلی</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to(['userpanel/ticket']) ?>">تیکت‌ها</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($model->subject) ?></li>
            </ol>
        </nav>
    </div>

    <div class="content-in">
        <div class="ticket-chat-container">
            
            <!-- هدر تیکت -->
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

            <div class="chat-messages p-3" style="max-height: 500px; overflow-y: auto; background: #f8f9fa; border-radius: 10px;">
                
                <div class="chat-message mb-3 d-flex">
                    <div class="message-avatar me-2">
                        <i class="fas fa-user-circle fa-2x text-secondary"></i>
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

                <!-- پاسخ‌ها (فرزندان) -->
                <?php if (!empty($children)): ?>
                    <?php foreach ($children as $child): ?>
                        <?php 
                        // تشخیص اینکه پاسخ از طرف ادمینه یا کاربر
                        // فرض می‌کنیم یه فیلد role یا is_admin داری
                        $isAdmin = $child->is_admin ?? false; 
                        // یا می‌تونی از role استفاده کنی: $isAdmin = ($child->user->role == 'admin');
                        ?>
                        <div class="chat-message mb-3 d-flex <?= $isAdmin ? 'flex-row-reverse' : '' ?>">
                            <div class="message-avatar mx-2">
                                <?php if ($isAdmin): ?>
                                    <i class="fas fa-headset fa-2x text-primary"></i>
                                <?php else: ?>
                                    <i class="fas fa-user-circle fa-2x text-secondary"></i>
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
                                <div class="message-body">
                                    <?= nl2br(Html::encode($child->description ?? $child->content)) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- اگه هیچ پاسخی وجود نداشته باشه -->
                <?php if (empty($children)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-comment-dots fa-3x mb-2" style="opacity: 0.3;"></i>
                        <p>هنوز پاسخی ثبت نشده است</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- بخش ارسال پاسخ جدید -->
            <div class="chat-input-section mt-3 p-3 bg-white rounded border">
                <?php if ($model->status != Ticket::STATUS_CLOSE): ?>
                    <form action="<?= Url::to(['userpanel/ticket/reply', 'id' => $model->id]) ?>" method="post">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> ارسال
                            </button>
                            <textarea name="reply_content" class="form-control" rows="2" placeholder="پاسخ خود را بنویسید..." required></textarea>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-secondary mb-0 text-center">
                        <i class="fa fa-lock"></i> این تیکت بسته شده است و نمی‌توان پاسخ داد
                    </div>
                <?php endif; ?>
            </div>

            <!-- دکمه‌های عملیاتی -->
            <div class="ticket-actions mt-3 d-flex gap-2">
                
                <?= Html::a('<i class="fa fa-arrow-right"></i> بازگشت به لیست', 
                    ['userpanel/ticket'], 
                    ['class' => 'btn btn-outline-primary']
                ) ?>
            </div>
        </div>
    </div>
</div>

<style>
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    .chat-messages::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    .chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .message-content {
        word-wrap: break-word;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .chat-message .message-avatar {
        align-self: flex-start;
    }
    .ticket-chat-container {
        max-width: 900px;
        margin: 0 auto;
    }
    @media (max-width: 768px) {
        .message-content {
            max-width: 85% !important;
        }
        .chat-messages {
            max-height: 400px !important;
        }
    }
</style>