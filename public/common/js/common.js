var AjaxErrorMsgCommon = "Oops, Something went wrong.";

/* Search With Pagination */
var page_selectore = "#_page";
var sorted_order_selectore = "#sortedOrder";
var sorted_by_selectore = "#sortedBy";

function setSortedBy(_sortedBy){
    jQuery( form +" "+ sorted_by_selectore ).val(_sortedBy);
}

function setSortedOrder(_sortedOrder){
    jQuery( form +" "+ sorted_order_selectore ).val(_sortedOrder);
}

function sortWithSearch(_sortedBy){

    var current_sortedBy = jQuery(sorted_by_selectore).val();
    var current_sorted_order = jQuery(sorted_order_selectore).val();
    setSortedBy(_sortedBy);
    if(_sortedBy != current_sortedBy){
        setSortedOrder('ASC');
    }else{
        setSortedOrder(((current_sorted_order.toLowerCase() == ('DESC').toLowerCase()) ? 'ASC' : 'DESC'));
    }

    serialize_data = jQuery(form).serialize().replace(/[^&]+=\.?(?:&|$)/g, '').replace(/&*jQuery/, "");
    window.location.href = jQuery(form).attr('action')+'?'+serialize_data;
    //jQuery(form).submit();
}

/* Hide Loader*/
function hideLoader(){
    jQuery("div#loader").hide();
}

/* show Loader */
function showLoader(){
    jQuery("div#loader").show();
}

/* Profile Picture */
jQuery("#select_photo").click(function(e) {
    jQuery("#profile_photo").click();
});

jQuery("#select_notification_photo").click(function(e) {
    jQuery("#notification_photo").click();
});

jQuery("#profile_photo").on('change', function(){
    var bname = jQuery(this).data('name');
    jQuery("."+bname).text("Select file");
    readURL(this);
});

jQuery("#notification_photo").on('change', function(){
    var bname = jQuery(this).data('name');
    jQuery("."+bname).text("Select file");
    readURL(this);
});

jQuery("#select_attachment").click(function(e) {
    jQuery("#attachment_file").click();
});

jQuery("#attachment_file").on('change', function(){
    var bname = jQuery(this).data('name');
    jQuery("."+bname).text("Select file");
    readURL(this);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var fileName = input.files[0].name;
        var bname = jQuery(input).data('name');
        jQuery("."+bname).text(fileName);
    }
}
/* Profile Picture end */

/* Open Model Event */
function openModal(modelElement){
    jQuery(modelElement).modal({
        backdrop: 'static',
        keyboard: false
    });
}

/* Close Model Event */
jQuery(".add-edit-model").on("hidden.bs.modal", function () {
    ResetForm();
});

/* Hide Notification Message On Load */
function hideNotificationMessageOnLoad() {
    setTimeout(function () {jQuery(".notification").hide(500)},4000);
}

/* Hide Notification Message Instant */
function hideNotificationMessageInstant() {
    jQuery(".notification").hide(500);
}

/* State Drop-Down */
function getStateDropDown(selfEle = '#country_id', stateEle = '#state_id'){
    jQuery(stateEle).empty().trigger('change');
    showLoader();
    jQuery.ajax({
        url: window.getStateDropDownUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'country_id': jQuery(selfEle).val(),
        },
        success: function (response) {
            jQuery(stateEle).append('<option value="">Select state</option>');
            if(response != ''){
                jQuery.each(response, function(key, value) {
                    jQuery(stateEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
            hideLoader();
        }
    });
}

/* City Drop-Down */
function getCityDropDown(selfEle = '#state_id', cityEle = '#city_id'){
    jQuery(cityEle).empty().trigger('change');
    showLoader();
    jQuery.ajax({
        url: window.getCityDropDownUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'state_id': jQuery(selfEle).val(),
        },
        success: function (response) {
            jQuery(cityEle).append('<option value="">Select city</option>');
            if(response != ''){
                jQuery.each(response, function(key, value) {
                    jQuery(cityEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
            hideLoader();
        }
    });
}

/* Class Drop-Down */
function getClassDropDown(selfEle = '#grade_id', classEle = '#class_id', schoolEle = '#school_id'){
    jQuery(classEle).empty().trigger('change');
    showLoader();
    jQuery.ajax({
        url: window.getClassDropDownUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'grade_id': jQuery(selfEle).val(),
            'school_id': jQuery(schoolEle).val(),
        },
        success: function (response) {
            jQuery(classEle).append('<option value="">Select class</option>');
            if(response != ''){
                jQuery.each(response, function(key, value) {
                    jQuery(classEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }else{
                /*jQuery(classEle).append('<option value="">Select class</option>');*/
            }
            if(window.classIdElementForAjaxTime != undefined && window.classIdElementForAjaxTime.length >= 1 && window.currentClassIdElementForAjaxTime != undefined){
                window.classIdElementForAjaxTime.val(window.currentClassIdElementForAjaxTime);
                window.currentClassIdElementForAjaxTime = undefined;
            }
            hideLoader();
        }
    });
}

/* Grade Drop-Down */
function getGradeDropDown(selfEle = '#school_id', classEle = '#grade_id'){

    jQuery(classEle).empty().trigger('change');
    showLoader();
    jQuery.ajax({
        url: window.getGradeDropDownUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'school_id': jQuery(selfEle).val(),
        },
        success: function (response) {
            jQuery(classEle).append('<option value="">Select grade</option>');
            if(response != ''){
                jQuery.each(response, function(key, value) {
                    jQuery(classEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }else{
                /*jQuery(classEle).append('<option value="">Select grade</option>');*/
            }
            // gradeDropDownTrigger();
            hideLoader();
        }
    });
}

/* Student Drop-Down */
function getStudentDropDown(selfEle = '#school_id', classEle = '#student_id'){

    jQuery(classEle).empty().trigger('change');
    showLoader();
    jQuery.ajax({
        url: window.getStudentDropDownUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'school_id': jQuery(selfEle).val(),
        },
        success: function (response) {
            if(response != ''){
                jQuery.each(response, function(key, value) {
                    jQuery(classEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }else{
                jQuery(classEle).append('<option value="">Select student</option>');
            }
            // gradeDropDownTrigger();
            hideLoader();
        }
    });
}

/* Class Drop-Down */
function getUserDropDownBySchoolId(selfEle = '#role_id', classEle = '#user_id', schoolId = '0'){
    jQuery(classEle).empty().trigger('change');
    showLoader();
    roleId = jQuery(selfEle).val();
    if(roleId == 1 || roleId == '1'){
        schoolId = 0;
    }
	if( jQuery(classEle).attr('multiple')) {
		jQuery(classEle).multiselect({
            columns: 1,
            search: true,
            selectAll: true,
            placeholder: 'Select user',
        });
	}
    jQuery.ajax({
        url: window.getUserDropDownBySchoolIdUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'role_id': roleId,
            'school_id': schoolId,
        },
        success: function (response) {
            if(response != ''){
                jQuery.each(response, function(key, value) {
                    jQuery(classEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }else {
				if( !jQuery(classEle).attr('multiple') ) {
					jQuery(classEle).append('<option value="">Select user type</option>');
				}
            }
			if( jQuery(classEle).attr('multiple')) {
				jQuery(classEle).multiselect('reload');
			}
            hideLoader();
        }
    });
}

/* User Drop-Down by role id */
function getUserDropDownByRoleType(selfEle = '#role_id', userEle = '#user_id'){
    jQuery(userEle).empty();
    window.currentSearchRoleId = jQuery(selfEle).val();
    showLoader();
    jQuery.ajax({
        url: window.getUserDropDownByRoleTypeUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'role_id': window.currentSearchRoleId,
        },
        success: function (response) {
            if(window.currentSearchRoleId == 2 || window.currentSearchRoleId == '2'){
                jQuery(userEle).append('<option value="">Schools</option>');
            }else {
                jQuery(userEle).append('<option value="">Users</option>');
            }
            if(response != ''){
                jQuery.each(response, function(key, value) {
                    jQuery(userEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
            hideLoader();
        }
    });
}

/* Student Drop-Down */
function getStudentMultipleDropDown(selfEle = '#school_id', classEle = '#student_id'){

    jQuery(classEle).empty().trigger('change');
    jQuery(classEle).multiselect('reload');

    showLoader();
    jQuery.ajax({
        url: window.getStudentMultipleDropDownUrl,
        method: 'post',
        dataType: 'JSON',
        data: {
            '_token': window._token,
            'school_id': jQuery(selfEle).val(),
        },
        success: function (response) {
            if(response != '') {
                jQuery.each(response, function(key, value) {
                    jQuery(classEle).append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
            jQuery(classEle).multiselect('reload');
            // gradeDropDownTrigger();
            hideLoader();
        }
    });
}


/* Document Ready */
jQuery(document).ready(function () {

    if(jQuery('[data-toggle="datepicker"]').length > 0) {

        jQuery('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 4048,
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
    }

	if (jQuery('[data-toggle="timepicker"]').length > 0) {
        jQuery('[data-toggle="timepicker"]').timepicki({
            increase_direction:'up',
        });
    }

    if(jQuery('[data-toggle="datetimepicker"]').length > 0) {

        jQuery('[data-toggle="datetimepicker"]').datetimepicker({
            format: 'MM/DD/YYYY hh:00:00 A',
            formatTime: 'hh:00 A',
            minDate: 0,  // disable past date
            minTime: 0, // disable past time
        });

        jQuery.datetimepicker.setDateFormatter({
            parseDate: function (date, format) {
                var d = moment(date, format);
                return d.isValid() ? d.toDate() : false;
            },
            formatDate: function (date, format) {
                return moment(date).format(format);
            },
        });

    }

    if(jQuery("#start_date, #end_date").length > 0) {

        jQuery("#start_date, #end_date").datepicker({
            useCurrent: false
        });
    }

    jQuery("#start_date").change(function () {
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;

        if ((Date.parse(endDate) < Date.parse(startDate))) {
            alert("Start date should be less then than End date");
            document.getElementById("start_date").value = "";
        }
    });

    jQuery("#end_date").change(function () {
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;

        if ((Date.parse(endDate) < Date.parse(startDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("end_date").value = "";
        }
    });


	jQuery("#event_start_date").change(function () {
        var startDate = document.getElementById("event_start_date").value;
        var endDate = document.getElementById("event_end_date").value;

        if ((Date.parse(endDate) < Date.parse(startDate))) {
            alert("Start date should be less then than End date");
            document.getElementById("event_start_date").value = "";
        }
    });

    jQuery("#event_end_date").change(function () {
        var startDate = document.getElementById("event_start_date").value;
        var endDate = document.getElementById("event_end_date").value;

        if ((Date.parse(endDate) < Date.parse(startDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("event_end_date").value = "";
        }
    });

    jQuery("#date_of_birth").change(function () {
        var dateOfBirth = document.getElementById("date_of_birth").value;
        var today = new Date();
        var todayDate = (today.getMonth()+1)+'/'+(today.getDate())+'/'+today.getFullYear();
        debugger;
        if(dateOfBirth != undefined && dateOfBirth != '') {
            if ((Date.parse(dateOfBirth) > Date.parse(todayDate))) {
                alert("date of birth should not be greater than today date");
                document.getElementById("date_of_birth").value = "";
            }
        }
    });

    hideNotificationMessageOnLoad();

    jQuery(".notification .close-ntf").click(function(e) {
        jQuery(this.parentElement).hide(500);
    });

    /* eye toggle for password */
    jQuery(".toggle-password").click(function() {
        jQuery(this).toggleClass("fa-eye fa-eye-slash");
        var input = jQuery(jQuery(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    /* Mask */
    /*
    if(jQuery('#phone, #whatsapp, #phone_for_edit, .phone-format').length > 0) {

        jQuery('#phone, #whatsapp, #phone_for_edit, .phone-format').mask('000-000-0000');

        jQuery('form').submit(function() {
            jQuery("#phone, #whatsapp, #phone_for_edit, .phone-format").unmask();
        });
    }
    */
    /* Multi Select */
    if(jQuery('select[multiple].common').length > 0) {

        jQuery(form +' select[multiple].common').multiselect({
            columns: 1,
            placeholder: 'Select class',
            search: true,
            searchOptions: {
                'default': jQuery(this).attr('data-select-text')
            },
            selectAll: true
        });
    }

    jQuery('.digitonly').on('input propertychange paste', function() {
        this.value = this.value.replace(/\D/g,'');
    });

     jQuery('.price-validation').on('input propertychange paste', function() {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    /* word Count Validation */
    if( jQuery('[data-count-validation="word"]').length > 0 ) {
        jQuery('[data-count-validation="word"]').on("propertychange change keyup paste input", function () {
            var regex = /\s+/gi;
            var str = jQuery(this).val();
            var wordCount = jQuery(this).val().trim().replace(regex, ' ').split(' ').length;
            var totalWorldAccept = jQuery(this).attr('data-total-word-accept');
            var countrSelector = jQuery(this).attr('data-counter-selector');
            var remainWord = (totalWorldAccept - wordCount);
            jQuery(countrSelector).html( remainWord );
            jQuery(this).val(str.split(/\s+/).slice(0,totalWorldAccept).join(" "));
        });
    }
});
