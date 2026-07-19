<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;

$this->registerCssFile(
    '@web/css/list.css',
    ['depends' => [\app\assets\FrontendAsset::class]]
);
?>
<!-- start page-content -->
<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0 bg-transparent">
                <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                <li class="breadcrumb-item active" aria-current="page">علاقه مندی ها</li>
            </ol>
        </nav>
    </div>
    <div class="content-in">
                  <div id="content-left">


                        <?= ListView::widget([
                           'dataProvider' => $dataProvider,
                           'itemView' => '_product_view',
                           'layout' => "{items}\n{pager}",
                           'options' => ['class' => 'row'],
                           'itemOptions' => ['class' => 'col-lg-4 col-md-6 mt-lg-3'],
                           'pager' => [
                              'class' => 'yii\bootstrap5\LinkPager',
                              'options' => [
                                 'class' => 'col-12  d-flex justify-content-center align-items-center m-3',
                              ]
                           ],
                           ]) ?>
                  </div>
            
    </div>
</div>
<!-- end page-content -->