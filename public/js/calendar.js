//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// ◆予約削除モーダルオープン処理
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
$(function () {
    $('.delete-modal-open').on('click', function () {
        $('.js-modal').fadeIn();

        var reserve_date = $(this).attr('reserve_date');
        var reserve_part = $(this).attr('reserve_part');
        var reserve_id = $(this).attr('reserve_id');
        $('.modal_reserve_date').text(reserve_date);
        $('.modal_reserve_part').text(reserve_part);
        $('.modal_reserve_id').val(reserve_id);

        return false;
    });

    $('.js-modal-close').on('click', function () {
        $('.js-modal').fadeOut();
        return false;
    });
});
