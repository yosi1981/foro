// Hide action menu if there are none available
var modActions = $('#mod-actions');
if (modActions.find('option').length == 0) {
    modActions.hide();
}

// Mod dashboard
$('#mod-dashboard-user-search-form').submit(function (e) {
    var alertElement = $('#alert-field');
    var loadUserInfo = function (data) {
        $('#user-info').html(data);
    };
    ajaxRequest($(this), alertElement, e, loadUserInfo);
});

// Mod reported posts page
$('.mod-action-button').click(function (e) {
    e.preventDefault();
    $('#report-action').val(this.id);
    $('#report-form').submit();
});