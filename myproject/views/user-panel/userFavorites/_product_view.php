<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\ProductUser;
?>
                        <!-- <div class=" col-lg-4 col-md-6 mt-lg-3"> -->
                           
                           <a href="<?= \yii\helpers\Url::to(['product/' , 'id' => $model->product->id]) ?>">
                           <div class="item-product">
                              <img src="<?= Yii::getAlias('@web/uploads/images/') . ($model->product->image ?? '') ?>" alt="" class="img-fluid">
                              <div class="item-product-description">
                                 <p>
                                    <?= $model->product->name ?>
                                 </p>
                                 <div class="item-product-price">
                                    <?php if($model->product->discountAmounts){ ?>
                                    <?php 
                                       $price = $model->product->price;
                                       $discount =($price / 100) * ($model->product->discountAmounts->percentage);
                                       $finalyPrice = $discount > $model->product->discountAmounts->discount_ceiling ? 
                                       $price - $model->product->discountAmounts->discount_ceiling
                                       : $price - $discount;
                                    ?>
                                    <span class="price-befor"><?= $price ?></span>
                                    <div class="price-off"><?= $model->product->discountAmounts->percentage ?></div>
                                    <div class="item-product-price-new">
                                       <span class="price"><?= $finalyPrice ?></span>
                                       <span class="unit">تومان</span>
                                    </div>
                                    <?php }else{?>
                                    <div class="item-product-price-new">
                                       <span class="price"><?= $model->product->price  ?></span>
                                       <span class="unit">تومان</span>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                              <div class="product-left-favorit">
                               <?php
                                   $user_id = Yii::$app->user->id;
                                   $product_id = $model->product->id;
                                  $isFavorite = ProductUser::isFavorite($user_id , $product_id);
                                   ?>
   
                                   <?= Html::a(
                                        $isFavorite ? 'حذف از علاقه مندی ها<i class="fas fa-heart text-danger"></i>' : 'افزودن به علاقه مندی ها<i class="far fa-heart text-danger"></i>',
                                       Url::to( ['//userpanel/user-favorite/toggle-favorite' , 'id' => $product_id]),
                                       ['class' => 'text-dark']
                                   ) ?>
                           </div>
                           </div>
                           </a>
                        <!-- </div> -->