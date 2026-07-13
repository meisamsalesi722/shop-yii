                        <!-- <div class=" col-lg-4 col-md-6 mt-lg-3"> -->
                           <a href="<?= \yii\helpers\Url::to(['product/' , 'id' => $model->id]) ?>">
                           <div class="item-product">
                              <img src="<?= Yii::getAlias('@web/uploads/images/') . ($model->image ?? '') ?>" alt="" class="img-fluid">
                              <div class="item-product-description">
                                 <p>
                                    <?= $model->name ?>
                                 </p>
                                 <div class="item-product-price">
                                    <?php if($model->discountAmounts){ ?>
                                    <?php 
                                       $price = $model->price;
                                       $discount =($price / 100) * ($model->discountAmounts->percentage);
                                       $finalyPrice = $discount > $model->discountAmounts->discount_ceiling ? 
                                       $price - $model->discountAmounts->discount_ceiling
                                       : $price - $discount;
                                    ?>
                                    <span class="price-befor"><?= $price ?></span>
                                    <div class="price-off"><?= $model->discountAmounts->percentage ?></div>
                                    <div class="item-product-price-new">
                                       <span class="price"><?= $finalyPrice ?></span>
                                       <span class="unit">تومان</span>
                                    </div>
                                    <?php }else{?>
                                    <div class="item-product-price-new">
                                       <span class="price"><?= $model->price  ?></span>
                                       <span class="unit">تومان</span>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                           </a>
                        <!-- </div> -->