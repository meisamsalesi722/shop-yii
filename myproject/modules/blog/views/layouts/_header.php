<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\NavBar;
use app\modules\blog\models\BlogCategory;

$parentCategories = BlogCategory::find()
    ->where(['parent_id' => null])
    ->orderBy(['title' => SORT_ASC])
    ->all();

?>

<header id="header">

<?php
NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top'
    ]
]);
?>

<div class="collapse navbar-collapse">

    <ul class="navbar-nav me-auto">

        <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['/']) ?>">
                خانه
            </a>
        </li>



        <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['/blog/admin/dashboard']) ?>">
                پنل
            </a>
        </li>


        <?php foreach ($parentCategories as $parent): ?>

            <?php
            $children = BlogCategory::find()
                ->where(['parent_id' => $parent->id])
                ->orderBy(['title' => SORT_ASC])
                ->all();
            ?>

            <?php if ($children): ?>

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="<?= Url::to(['/blog/category/view', 'id' => $parent->id]) ?>">

                        <?= Html::encode($parent->title) ?>

                    </a>

                    <ul class="dropdown-menu">

                        <?php foreach ($children as $child): ?>

                            <li>

                                <a class="dropdown-item"
                                   href="<?= Url::to(['/blog/category/view', 'id' => $child->id]) ?>">

                                    <?= Html::encode($child->title) ?>

                                </a>

                            </li>

                        <?php endforeach; ?>

                    </ul>

                </li>

            <?php else: ?>

                <li class="nav-item">

                    <a class="nav-link"
                       href="<?= Url::to(['/blog/category/view', 'id' => $parent->id]) ?>">

                        <?= Html::encode($parent->title) ?>

                    </a>

                </li>

            <?php endif; ?>

        <?php endforeach; ?>

    </ul>

    <ul class="navbar-nav">

        <?php if (Yii::$app->user->isGuest): ?>

            <li class="nav-item">

                <a class="nav-link"
                   href="<?= Url::to(['/blog/site/login']) ?>">

                    ورود

                </a>

            </li>

        <?php else: ?>

            <li class="nav-item">

                <?= Html::beginForm(['/blog/site/logout'], 'post') ?>

                <button class="btn btn-link nav-link">

                    خروج (<?= Html::encode(Yii::$app->user->identity->username) ?>)

                </button>

                <?= Html::endForm() ?>

            </li>

        <?php endif; ?>

    </ul>

</div>

<?php NavBar::end(); ?>

</header>