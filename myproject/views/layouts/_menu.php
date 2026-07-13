<?php
use yii\helpers\Url;
use app\models\Category;
?>
<!------------------------------------- START MENU --------------------------------->

<div class="menu text-right">
    <a href="/site" class="img-menu-mobile">
        <img src="img/2بج سه.png" alt="لیموناد" title="لیموناد" class="img-fluid">
    </a>
    <div class="main-menu text-right">
        <div class="in-main-menu">
            <!------------------------------------ START LEVEL ONE ------------------------------------>
            <div class="level-one">
                <?php 
                    $categories = Category::find()->with('children.children')->where(['parent_id' => null])->all();
                ?>
                <?php foreach ($categories as $key => $category) { ?>
                    <div class="item-level-one">
                        <i class="far fa-circle"></i>
                        <a href="<?= Url::to(['/list/index' , 'categoryId' => $category->id]) ?>"> <?= $category->name  ?> </a>
                        <span onclick="open_level_two('#body-level-two-<?= $key ?>')"><i class="fas fa-chevron-left"></i></span>
                    </div>
                <?php } ?>

                <a onclick="show_login()" class="item-login"><i class="fal fa-user"></i> ورود به پنل کاربری </a>
                <a onclick="show_signup()" class="item-login item-login-1"> <i class="fas fa-lock"></i>ثبت نام در
                    فروشگاه</a>

            </div>
            <!------------------------------------ END LEVEL ONE ------------------------------------>

                <!------------------------------------ START LEVEL TWO ------------------------------------>
                <div class="level-two">

                <?php foreach ($categories as $key => $category) { ?>
                    <div class="body-level-two" id="body-level-two-<?= $key ?>">
                        <div class="go-back-menu" onclick="back_level_one()">
                            <a href="<?= Url::to(['/list/index' , 'categoryId' => $category->id]) ?>">زیر گروه های <strong class="red-menu"> <?= $category->name ?> </strong></a>
                            <span><i class="fas fa-arrow-right"></i></span>
                        </div>
                    <?php foreach ($category->children as $index => $children) { ?>
                        <div class="item-level-one">
                            <a href="<?= Url::to(['/list/index' , 'children' => $category->id]) ?>"> <?= $children->name ?></a>
                            <span onclick="open_level_three('#body-level-three-<?= $index ?>')"><i
                                    class="fas fa-chevron-left"></i></span>
                        </div>
                    <?php } ?>
                    </div>
                <?php } ?>

                </div>
                <!------------------------------------ END LEVEL TWO ------------------------------------>

                <!------------------------------------ START LEVEL THREE FILTER ------------------------------------>
                <div class="level-three">

                    <!------------- START LEVEL THREE SUB GROUP -------------->

<?php foreach ($categories as $key => $category) { ?>
    <?php foreach ($category->children as $index => $children) { ?>

        <div class="body-level-three" id="body-level-three-<?= $index ?>">

            
            <div class="go-back-menu" onclick="back_level_two()">
                <a href="<?= Url::to(['/list/index' , 'categoryId' => $children->id]) ?>">زیر گروه های <strong class="red-menu"> <?= $children->name ?></strong></a>
                <span><i class="fas fa-arrow-right"></i></span>
            </div>

            <?php foreach ($children->children as $key => $subChildren) { ?>

                        <div class="item-level-one">
                            <a href="<?= Url::to(['/list/index' , 'categoryId' => $subChildren->id]) ?>"><?= $subChildren->name ?></a>
                            <span onclick="open_level_four('#body-level-four-1')"><i
                                    class="fas fa-chevron-left"></i></span>
                        </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php } ?>




                    <!------------- END LEVEL THREE SUB GROUP -------------->


                    <!-------------- START LEVEL THREE FILTER -------------->
























                    <!-------------- END LEVEL THREE FILTER -------------->

                </div>
                <!------------------------------------ END LEVEL THREE FILTER ------------------------------------>


        </div>
    </div>
    </div>

<!------------------------------------- END MENU --------------------------------->