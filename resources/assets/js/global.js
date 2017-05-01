/*
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

var submitButton;

/*
 * Handle ajax requests for all forms that require such task
 */

/*
 * If a form has a use-ajax class, then automatically assume that it wants to do an ajax request
 */
$('.use-ajax').submit(function (e) {
    var alertElement = $('#alert-field');
    ajaxRequest($(this), alertElement, e);
});

function ajaxRequest(form, alertElement, e, optionalFunction) {
    submitButton = (form).find('button[type=submit]');
    $.ajax({
        type: form.attr('method'),
        dataType: 'JSON',
        url: form.attr('action'),
        data: form.serialize(),
        beforeSend: function () {
            // Show loading icon and enable submit button
            showLoadingIcon();
        },
        success: function (data) {
            // Hide the loading icon and enable submit button
            hideLoadingIcon();
            // Display the success message
            successMessage(data, alertElement);
            // If optional function is to be run, run it
            if (typeof optionalFunction !== 'undefined') {
                optionalFunction(data);
            }
        },
        // If there is an error such as validation
        error: function (data) {
            hideLoadingIcon();
            errorMessage(data, alertElement);
        }
    });
    e.preventDefault();
}
/**
 * Hide the error class in form
 */
function hideHasErrorClass() {
    $('.form-control').closest('.form-group').removeClass('has-error');
}

/**
 * Remove the loading icon from button
 */
function hideLoadingIcon() {
    submitButton.prop('disabled', false);
    submitButton.find('i').show();
    $('#loading-icon').remove();
}

/**
 * Show the loading icon near the button before doing the ajax request
 */
function showLoadingIcon() {
    submitButton.prop('disabled', true);
    if (!$('#loading-icon').length) {
        submitButton.find('i').hide();
        submitButton.prepend($("<i id='loading-icon' class='fa fa-refresh fa-spin'></i>"));
    }
}

/**
 * Parse and show error message to user that the server sends
 * Also show error message if there are any exceptions thrown to user
 * @param data
 * @param alertElement
 */
function errorMessage(data, alertElement) {
    var errors = $.parseJSON(data.responseText);
    alertMessageDisplay(errors, 'danger', alertElement);
}

/**
 * Parse and show success message to user that the server sends
 * @param data
 * @param alertElement
 */
function successMessage(data, alertElement) {
    // If the server requests no alert to be shown, don't show any alert.
    alertElement.html('');
    if (data.redirect) {
        window.location.href = data.redirect;
    }
    if (!data.noAlert && data.success)
        alertMessageDisplay(data, 'success', alertElement);
    if (!data.noAlert && data.error)
        alertMessageDisplay(data, 'danger', alertElement);

}

/**
 * Display the alert
 * @param data
 * @param type
 * @param alertElement
 */
function alertMessageDisplay(data, type, alertElement) {

    hideHasErrorClass();

    var alertHtml = '<div class="alert alert-' + type + '">';
    // Hide any flash message (in includes/error.blade.php)
    $('.flash-alert').hide();

    // If the alert type is error or not success, put it in a list
    if (type != 'success') {
        alertHtml += '<ul>';
        $.each(data, function (key, value) {
            $('.form-control[name=' + key + ']').closest('.form-group').addClass('has-error');
            alertHtml += '<li>' + value + '</li>';
        });
        alertHtml += "</ul>";

        // If the alert type is success, don't put the message in a list
    } else {
        //$.each(data, function (key, value) {
        //    alertHtml += value;
        //});
        alertHtml += data.success;
    }
    alertHtml += "</div>";
    alertElement.html(alertHtml);
}

// Scroll method to scroll to anything - most specifically single posts.
var hash = window.location.hash;
if (hash) scrollTo(hash);

// If an element with the "scroll" class is clicked, scroll.
$(".scroll").click(function (event) {
    event.preventDefault();

    if (history.pushState)
        history.pushState(null, null, this.hash);
    else
        location.hash = this.hash;

    scrollTo(this.hash);

});

/*
 *  Scroll to a certain position on a page.
 */
function scrollTo(hash) {
    if (hash) {
        try {
            $('html, body').animate({scrollTop: $(hash).offset().top - 60});
        } catch (ex) {
            // Do nothing bro
        }
    }
}

/*
 * On anchor tag (<a></a>) click, do an ajax request if there is a "showAjaxModal" class.
 */
$('.showAjaxModal').click(function () {

    var ajaxModal = $('#ajax-modal');
    ajaxModal.modal('show');
    // The loading icon is shown/hidden while the modal requests from server
    var loadingIcon = $('.modal-loading-icon');
    // The URL is passed as an "data-url" attribute
    var ajaxUrl = $(this).attr('data-url');

    var modalSize = $(this).attr('data-size');

    // If there is modal size then change the size
    if (typeof modalSize != typeof undefined && modalSize !== false) {
        ajaxModal.find('.modal-dialog').addClass(modalSize);
    } else {
        // Reset the modal size to default if no size found
        ajaxModal.find('.modal-dialog').attr('class', 'modal-dialog');
    }

    $.ajax({
        url: ajaxUrl,
        beforeSend: function () {
            // Show loading icon
            loadingIcon.show();
        }
    }).success(function (data) {
        // Change the modal title to the info from database
        $('.modal-title').html(data.title);
        // Change the modal view to the info from database
        $('.modal-body').html(data.view);

        loadingIcon.hide();
    });
});
