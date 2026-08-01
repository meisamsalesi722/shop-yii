
<div class="toast-container position-fixed top-0 start-0 p-3 ">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success">
      <strong class="me-auto text-white">عملیات موفق</strong>
      <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?= Yii::$app->session->getFlash('success') ?>
    </div>
  </div>
</div>

    <script>
      $(document).ready(function(){
        $('.toast').toast('show')
      })
    </script>

