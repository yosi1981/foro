/*
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

// Username Search feature
$(function () {
    $("#username-search").find('#username').autocomplete({
        source: $('#username-api-url').val(),
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $('#username').val(ui.item.info);
        },
        response: function (event, ui) {
            var noResults = $('#no-user-found');
            ui.content.length === 0 ? noResults.show() : noResults.hide();
        }

    });
});

// Hide/show element if checkbox checked
function checkboxHideElement(checkboxElement, toHideElement) {
    $(document).ready(function () {
        checkboxElement.is(':checked') ? toHideElement.show() :toHideElement.hide();
    });
    checkboxElement.change(function () {
        if(this.checked) {
            toHideElement.slideDown();
        } else {
            toHideElement.slideUp()
        }
    });
}