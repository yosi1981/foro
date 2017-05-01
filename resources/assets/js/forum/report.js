/*
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

function reportPost(API_URL_TO_FORM) {

    // Reason select box
    var reason;
    // Form
    var form = $('#report-post');
    // Post ID of the post that the report is being sent to...
    var postID;
    // Loading Icon
    var loadingIcon = $('.modal-loading-icon');
    // Hide other reason textbox if the selected option is not set to "other"
    function hideOtherReasonTextbox() {
        var otherReason = $('#other-reason-report');
        reason = $('#reason-report-post');
        otherReason.hide();
        reason.bind('change', function () {
            reason.val() == 'Other' ? otherReason.show() : otherReason.hide();
        });
    }

    // On page load, pass URL to the form so it can be submitted and unique for each report post
    $('#report-post-modal').on('show.bs.modal', function (e) {
        loadingIcon.show();
        postID = e.relatedTarget.dataset.post;
        // Reset the modal
        resetModal();
        var submitURL = e.relatedTarget.dataset.url;
        form.attr("action", submitURL);
    });

    /**
     * When user submits form, fire off an ajax request
     */
    form.submit(function (e) {
        // Hide the report button after report successful
        var postReported = function () {
            resetModal();
        };
        var alertElement = $('#report-alert-field');
        ajaxRequest($(this), alertElement, e, postReported);
    });

    // Reset modal for each report button click
    function resetModal() {
        $.get(API_URL_TO_FORM + '/' + postID, function (data) {
            $('#report-body').html(data);
            hideOtherReasonTextbox();
        }).done(function() {
            loadingIcon.hide();
        }).fail(function() {
            loadingIcon.hide();
            alert('Error! Please try again later.');
        });
    }
}