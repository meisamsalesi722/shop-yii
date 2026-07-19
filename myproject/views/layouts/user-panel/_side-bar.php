<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
                       <?php 
                        $user = Yii::$app->user->identity;
                        $currentRoute = Yii::$app->controller->getRoute();
                       ?>
                       <!-- start page-aside -->
                        <div class="page-aside">
                            <!-- start top-aside -->
                            <div class="top-aside text-center d-flex justify-content-lg-center align-items-center mb-4">
                                <button>
                                    <?php if($user->avatar){?>
                                        <img style="border-radius: 100%;width: 80px;height: 80px;object-fit: cover;" src="<?= Yii::getAlias('@web/uploads/images/') . $user->avatar?>" alt="">
                                    <?php }else{ ?>
                                            <i class="fad fa-user"></i>
                                    <?php } ?>
                                </button>
                                <div class="user-details">
                                    <span class="name"><?= $user->username ?></span>
                                    <span class="tel"><?= $user->mobile ?? '' ?></span>
                                </div>
                            </div>
                            <!-- end top-aside -->
                            <div class="profile-box d-none d-lg-block">
                                <!-- start profile-menu -->
                                <div class="profile-menu">
                                    <div class="profile-title">
                                        <i class="fad fa-user"></i> نمایه کاربری
                                    </div>
                                    <ul>
                                        <li class="<?=  str_contains($currentRoute , 'userpanel/user-info') ? 'active' : '' ?>">
                                            <a href="<?= Url::to('/userpanel/user-info') ?>">
                                                <span class="icon"><i class="fal fa-user"></i></span>
                                                <span class="title">اطلاعات کاربر</span>
                                            </a>
                                        </li>
                                        <li class="<?=  str_contains($currentRoute , 'userpanel/user-favorite') ? 'active' : '' ?>" >
                                            <a href="<?= Url::to('/userpanel/user-favorite') ?>" >
                                                <span class="icon"><i class="fal fa-heart"></i></span>
                                                <span class="title"> علاقه مندی ها</span>
                                            </a>
                                        </li>
                                        <li class="<?= str_contains($currentRoute , 'userpanel/order-history') ? 'active' : '' ?>">
                                            <a href="<?= Url::to('/userpanel/order-history') ?>">
                                                <span class="icon"><i class="fal fa-box"></i></span>
                                                <span class="title"> تاریخچه سفارشات</span>
                                            </a>
                                        </li>
                                        <li class="<?= str_contains($currentRoute , 'userpanel/ticket')   ? 'active' : '' ?>">
                                            <a href="<?= Url::to('/userpanel/ticket') ?>">
                                                <span class="icon"><i class="fal fa-check"></i></span>
                                                <span class="title"> تیکت</span>
                                            </a>
                                        </li>
                                        
                                        <li>
                                           <?php  ActiveForm::begin([
                                            'action' => Url::to('/login-register/logout'),
                                            'id' => 'logoutFormMobile'
                                           ]) ?>
                                            <a onclick="$('#logoutFormMobile').submit()">
                                                <span class="icon"><i class="fal fa-sign-out"></i></span>
                                                <span class="title">خروج</span>
                                            </a>
                                            <?php ActiveForm::end() ?>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end profile-menu -->
                            </div>
                        <!------------------ start mobile --------------------->
                            <div class="profile-btn d-lg-none" id="btn-menu-show">
                                <div class="btn-menu" >
                                    <i class="fal fa-bars"></i>
                                    <span>منوی دسترسی</span>
                                </div>
                            </div>
                            <!-- start profile-box-mobile -->
                            <div class="profile-box-mobile mt-3">
                                <!-- start profile-menu-responsive -->
                                <div class="profile-menu profile-menu-responsive d-lg-none">
                                    <div class="profile-title">
                                        <i class="fad fa-user"></i> نمایه کاربری
                                    </div>
                                    <ul>
                                        <li class="<?=  str_contains($currentRoute , 'userpanel/user-info') ? 'active' : '' ?>">
                                            <a href="<?= Url::to('/userpanel/user-info') ?>">
                                                <span class="icon"><i class="fal fa-user"></i></span>
                                                <span class="title">اطلاعات کاربر</span>
                                                <i class="far fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="<?=  str_contains($currentRoute , 'userpanel/user-favorite') ? 'active' : '' ?>">
                                            <a href="<?= Url::to('/userpanel/user-favorite') ?>">
                                                <span class="icon"><i class="fal fa-heart"></i></span>
                                                <span class="title"> علاقه مندی ها</span>
                                                <i class="far fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="<?= str_contains($currentRoute , 'userpanel/order-history') ? 'active' : '' ?>">
                                            <a href="<?= Url::to('/userpanel/order-history') ?>">
                                                <span class="icon"><i class="fal fa-box"></i></span>
                                                <span class="title"> تاریخچه سفارشات</span>
                                                <i class="far fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="<?= str_contains($currentRoute , 'userpanel/ticket')   ? 'active' : '' ?>">
                                            <a href="<?= Url::to('/userpanel/ticket') ?>">
                                                <span class="icon"><i class="fal fa-check"></i></span>
                                                <span class="title"> تیکت</span>
                                                <i class="far fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        
                                        <li>
                                           <?php  ActiveForm::begin([
                                            'action' => Url::to('/login-register/logout'),
                                            'id' => 'logoutForm'
                                           ]) ?>
                                            <a onclick="$('#logoutForm').submit()">
                                                <span class="icon"><i class="fal fa-sign-out"></i></span>
                                                <span class="title">خروج</span>
                                            </a>
                                            <?php ActiveForm::end() ?>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end profile-menu-responsive -->
                            </div>
                            <!-- end profile-box-mobile -->
                        <!------------------ end mobile --------------------->
                        </div>
                        <!-- end page-aside -->