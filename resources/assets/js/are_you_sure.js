$('button[name="ays-confirm"]').on('click', function (e) {
    var $form = $(this).closest('form');
    e.preventDefault();
    $('#are-you-sure-modal').modal({backdrop: 'static', keyboard: false})
        .one('click', '.ays-yes-btn', function (e) {
            $('#are-you-sure-modal').modal('hide');
            $form.trigger('submit');
        });
});