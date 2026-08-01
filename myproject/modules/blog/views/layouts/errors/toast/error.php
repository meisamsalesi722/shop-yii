<?php 

?>

<div class="toast-container position-fixed top-0 strat-0 p-3 ">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-danger">
      <strong class="me-auto text-white">خطا</strong>
      <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?= Yii::$app->session->getFlash('error') ?>
    </div>
  </div>
</div>

     <script>
      $(document).ready(function(){
        $('.toast').toast('show')
      })
     </script>
