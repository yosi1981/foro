/*
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

// All checked values
var checkedValues = [];
// The class name of the checkbox input that selects ONE result
var modCheckboxInput = $('input:checkbox.mod-checkbox-select-result');
// The class name of the "Select all" checkbox
var modCheckAllInput = $(".mod-checkbox-select-all-results");
// The class name of the hidden field which has all selected ID of the results
var modSelectedModelInput = $('.mod-selected-results');
// The total number of results that have been selected
var modTotalSelected = $('.mod-selected-results-total');


/*
 * Find all the checkboxes that needs to be checked and check them
 */
modCheckAllInput.click(function () {
    modCheckboxInput.not(this).prop('checked', this.checked);
    findCheckedCheckboxes();
});

/*
 * If an individual checkbox is checked, check only one individual result,
 * check if all individual checkboxes have been checked and act accordingly.
 * If all checkboxes have been checked, show that all have been checked,
 * by checking the "select all checkbox"
 */
modCheckboxInput.click(function () {
    // If all checkboxes have been individually checked, check the "select all" checkbox
    if (modCheckboxInput.length == modCheckboxInput.filter(':checked').length) {
        modCheckAllInput.prop('checked', true);
        modCheckAllInput.prop('indeterminate', false);
    } else {
        // If not all have been checked, set the indeterminate to true (half crossed)
        modCheckAllInput.prop('checked', false);
        modCheckAllInput.prop('indeterminate', true);
    }
    findCheckedCheckboxes();
});

/*
 * Find all the checked checkboxes (only the ones that are applicable
 */
function findCheckedCheckboxes() {
    checkedValues = modCheckboxInput.filter(':checked').map(function () {
        return this.value;
    }).get();
    if (checkedValues.length == 0)
        modCheckAllInput.prop('indeterminate', false);

    outputCheckedCheckboxesNumber(checkedValues.length);
}

/*
 * Output the checked values and display results to user
 */
function outputCheckedCheckboxesNumber(selectedPosts) {
    selectedPosts = checkedValues.length;
    modSelectedModelInput.val(checkedValues);
    modTotalSelected.text(selectedPosts);
}