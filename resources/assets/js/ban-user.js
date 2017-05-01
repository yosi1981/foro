/*
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

// Manage the form for ban user...
function manageBanUserForm() {
    $('#custom').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });

    $('#length').bind('change', function () {
        var customDate = $('#custom-date');
        $('#length').val() == 'custom' ? customDate.show() : customDate.hide();
    });
}

// When the ban user form is submitted...
$('#ban-user').submit(function (e) {
    var alertElement = $('#alert-field');
    // After successful ajax request
    var loadForm = function (data) {
        $('#banned').html(data);
        manageBanUserForm();
    };
    ajaxRequest($(this), alertElement, e, loadForm);
});

// Delete a ban form while viewing a ban
$('#banned-delete-form').submit(function (e) {
    var alertElement = $('#alert-field');
    ajaxRequest($(this), alertElement, e);
});

// Function is called when searching for user and clicking the "ban user" button
function banUser() {
    manageBanUserForm();
    $('#ban-user-form').submit(function (e) {
        var alertElement = $('#alert-field');
        ajaxRequest($(this), alertElement, e);
    });
}