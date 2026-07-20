<?php
use app\modules\blog\models\Favorite;

/* @var $model app\models\Article */
/* @var $isFavorite boolean */
?>

<?php if (!Yii::$app->user->isGuest): ?>
    <button class="btn <?= $isFavorite ? 'btn-danger' : 'btn-outline-danger' ?> favorite-btn" 
            data-article-id="<?= $model->id ?>"
            onclick="toggleFavorite(<?= $model->id ?>, this)">
        <i class="fas fa-heart"></i>
        <span class="favorite-text">
            <?= $isFavorite ? 'حذف از علاقه‌مندی‌ها' : 'افزودن به علاقه‌مندی‌ها' ?>
        </span>
        <span class="favorite-count badge bg-light text-dark ms-1">
            <?= Favorite::find()->where(['article_id' => $model->id])->count() ?>
        </span>
    </button>
<?php endif; ?>

<script>
function toggleFavorite(articleId, btn) {
    const $btn = $(btn);
    const originalHtml = $btn.html();
    
    // غیرفعال کردن دکمه
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> در حال پردازش...');
    
    $.ajax({
        url: '/blog/favorite/toggle',
        type: 'POST',
        data: { article_id: articleId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // به‌روزرسانی دکمه
                const isFavorite = response.isFavorite;
                $btn.removeClass('btn-danger btn-outline-danger')
                    .addClass(isFavorite ? 'btn-danger' : 'btn-outline-danger');
                
                $btn.find('.favorite-text').text(
                    isFavorite ? 'حذف از علاقه‌مندی‌ها' : 'افزودن به علاقه‌مندی‌ها'
                );
                
                // به‌روزرسانی تعداد
                $btn.find('.favorite-count').text(response.favoriteCount || 0);
                
                // نمایش پیام
                showToast(response.isFavorite ? 'success' : 'info', response.message);
            } else {
                alert(response.message || 'خطا در عملیات');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        },
        complete: function() {
            // فعال کردن دکمه
            $btn.prop('disabled', false).html(originalHtml);
        }
    });
}

function showToast(type, message) {
    const toastHtml = `
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
            <div class="toast show align-items-center text-white bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    `;
    
    $('.position-fixed.bottom-0.end-0.p-3').remove();
    $('body').append(toastHtml);
    
    setTimeout(function() {
        $('.position-fixed.bottom-0.end-0.p-3').fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}
</script>