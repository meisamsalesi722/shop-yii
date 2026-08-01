<?php
use yii\helpers\Html;
?>
    <!-- هدر -->
    <header class="admin-header">
        <div class="d-flex align-items-center gap-3">
            <button class="mobile-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">
                <i class="fas fa-<?= Yii::$app->controller->id ?>"></i>
                <?= Html::encode($this->title) ?>
            </h1>
        </div>

        <div class="header-actions">
            <!-- دکمه تغییر تم در هدر -->
            <button class="theme-toggle-header" id="themeToggleHeader" title="تغییر تم">
                <i class="fas fa-moon" id="themeIconHeader"></i>
            </button>

            <div class="user-info">
                <span class="username">
                    <?= Yii::$app->user->isGuest ? 'میهمان' : Yii::$app->user->identity->username ?? 'کاربر' ?>
                </span>
                <div class="avatar">
                    <?php if(Yii::$app->user->identity->avatar){ ?>
                    <img src="<?= Yii::getAlias('@web/uploads/images/') . Yii::$app->user->identity->avatar ?>" style="height: 40px; width: 40px; border-radius: 100%;" alt="">
                    <?php }else{?>
                    <?= Yii::$app->user->isGuest ? 'G' : strtoupper(substr(Yii::$app->user->identity->username ?? 'U', 0, 1)) ?>
                    <?php } ?>
                </div>
                <?= Html::a(
                    '<i class="fas fa-sign-out-alt"></i>',
                    ['/site/logout'],
                    [
                        'class' => 'logout',
                        'title' => 'خروج',
                        'data-method' => 'post'
                    ]
                ) ?>
            </div>
        </div>
    </header>