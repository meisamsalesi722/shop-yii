<?php 

?>


            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?= Yii::$app->session->getFlash('warning') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>