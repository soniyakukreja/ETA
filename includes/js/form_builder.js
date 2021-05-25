$(document).ready(function () {

    $(".form_bal_filefield").draggable({
        helper: function () {
            return getFileFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });

    $(".form_bal_textfield").draggable({
        helper: function () {
            return getTextFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_textarea").draggable({
        helper: function () {
            return getTextAreaFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_number").draggable({
        helper: function () {
            return getNumberFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    // $(".form_bal_email").draggable({
    //     helper: function () {
    //         return getEmailFieldHTML();
    //     },
    //     connectToSortable: ".form_builder_area"
    // });
    // $(".form_bal_password").draggable({
    //     helper: function () {
    //         return getPasswordFieldHTML();
    //     },
    //     connectToSortable: ".form_builder_area"
    // });
    // $(".form_bal_date").draggable({
    //     helper: function () {
    //         return getDateFieldHTML();
    //     },
    //     connectToSortable: ".form_builder_area"
    // });
    // $(".form_bal_button").draggable({
    //     helper: function () {
    //         return getButtonFieldHTML();
    //     },
    //     connectToSortable: ".form_builder_area"
    // });
    $(".form_bal_select").draggable({
        helper: function () {
            return getSelectFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_radio").draggable({
        helper: function () {
            return getRadioFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_checkbox").draggable({
        helper: function () {
            return getCheckboxFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });

    $(".form_builder_area").sortable({
        cursor: 'move',
        placeholder: 'placeholder',
        start: function (e, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
        },
        stop: function (ev, ui) {
            getPreview();
        }
    });
    $(".form_builder_area").disableSelection();

    function getFileFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>File Upload Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="file" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function getButtonFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Button Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="button" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="class_' + field + '" class="form-control form_input_button_class" placeholder="Class" value="btn btn-primary" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><input type="text" name="value_' + field + '" data-field="' + field + '" class="form-control form_input_button_value" value="Submit" placeholder="Value"/></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getTextFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Text Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="text" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><label>Placeholder</label><input type="text" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getNumberFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Numeric Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="number" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><label>Placeholder</label><input type="text" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getEmailFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Email Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="email" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><label>Placeholder</label><input type="text" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getPasswordFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Password Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="password" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><label>Placeholder</label><input type="text" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getDateFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Date Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="date" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getTextAreaFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Paragraph Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><div class="row li_row form_output" data-type="textarea" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><label>Placeholder</label><input type="text" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getSelectFieldHTML() {
        var field = generateField();
        var opt1 = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Select Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div><div class="row li_row form_output" data-type="select" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><select name="select_' + field + '" class="form-control"><option data-opt="' + opt1 + '" value="Value">Option</option></select></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_' + field + '"><div data-field="' + field + '" class="row select_row_' + field + '" data-opt="' + opt1 + '"><div class="col-md-4"><div class="form-group"><input type="text" value="Option" class="s_opt form-control"/></div></div><input type="hidden" value="Value" class="s_val form-control"/><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_select" data-field="' + field + '"></i></div></div></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getRadioFieldHTML() {
        var field = generateField();
        var opt1 = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Radio Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div><div class="row li_row form_output" data-type="radio" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><div class="mt-radio-list radio_list_' + field + '"><label class="mt-radio mt-radio-outline"  style="padding-right:25px !important;"><input data-opt="' + opt1 + '" type="radio" name="radio_' + field + '" value="Option"> <p class="r_opt_name_' + opt1 + '">Option</p><span></span></label></div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_' + field + '"><div data-field="' + field + '" class="row radio_row_' + field + '" data-opt="' + opt1 + '"><div class="col-md-4"><div class="form-group"><input type="text" value="Option" class="r_opt form-control"/></div></div><input type="hidden" value="Value" class="r_val form-control"/><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="' + field + '"></i></div></div></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getCheckboxFieldHTML() {
        var field = generateField();
        var opt1 = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><b>Checkbox Field</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="' + field + '"><i class="fa fa-times"></i></button></div></div><div class="row li_row form_output" data-type="checkbox" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control form_input_label" value="Label" data-field="' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><div class="mt-checkbox-list checkbox_list_' + field + '"><label class="mt-checkbox mt-checkbox-outline" style="padding-right:25px !important;"><input data-opt="' + opt1 + '" type="checkbox" name="checkbox_' + field + '" value="Value"> <p class="c_opt_name_' + opt1 + '">Option</p><span></span></label></div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_' + field + '"><div data-field="' + field + '" class="row checkbox_row_' + field + '" data-opt="' + opt1 + '"><div class="col-md-4"><div class="form-group"><input type="text" value="Option" class="c_opt form-control"/></div></div><input type="hidden" value="Value" class="c_val form-control"/><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_checkbox" data-field="' + field + '"></i></div></div></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    $(document).on('click', '.add_more_select', function () {
        $(this).closest('.form_builder_field').css('height', 'auto');
        var field = $(this).attr('data-field');
        var option = generateField();
        $('.field_extra_info_' + field).append('<div data-field="' + field + '" class="row select_row_' + field + '" data-opt="' + option + '"><div class="col-md-4"><div class="form-group"><input type="text" value="Option" class="s_opt form-control"/></div></div><input type="hidden" value="Option" class="s_val form-control"/><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_select" data-field="' + field + '"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_select" data-field="' + field + '"></i></div></div>');
        var options = '';
        $('.select_row_' + field).each(function () {
            var opt = $(this).find('.s_opt').val();
            var val = $(this).find('.s_val').val();
            var s_opt = $(this).attr('data-opt');
            options += '<option data-opt="' + s_opt + '" value="' + opt + '">' + opt + '</option>';
        });
        $('select[name=select_' + field + ']').html(options);
        getPreview();
    });
    $(document).on('click', '.add_more_radio', function () {
        $(this).closest('.form_builder_field').css('height', 'auto');
        var field = $(this).attr('data-field');
        var option = generateField();
        $('.field_extra_info_' + field).append('<div data-opt="' + option + '" data-field="' + field + '" class="row radio_row_' + field + '"><div class="col-md-4"><div class="form-group"><input type="text" value="Option" class="r_opt form-control"/></div></div><input type="hidden" value="Value" class="r_val form-control"/><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="' + field + '"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_radio" data-field="' + field + '"></i></div></div>');
        var options = '';
        $('.radio_row_' + field).each(function () {
            var opt = $(this).find('.r_opt').val();
            var val = $(this).find('.r_val').val();
            var s_opt = $(this).attr('data-opt');
            options += '<label class="mt-radio mt-radio-outline" style="padding-right:25px !important;"><input data-opt="' + s_opt + '" type="radio" name="radio_' + field + '" value="' + opt + '"> <p class="r_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
        });
        $('.radio_list_' + field).html(options);
        getPreview();
    });
    $(document).on('click', '.add_more_checkbox', function () {
        $(this).closest('.form_builder_field').css('height', 'auto');
        var field = $(this).attr('data-field');
        var option = generateField();
        $('.field_extra_info_' + field).append('<div data-opt="' + option + '" data-field="' + field + '" class="row checkbox_row_' + field + '"><div class="col-md-4"><div class="form-group"><input type="text" value="Option" class="c_opt form-control"/></div></div><input type="hidden" value="Value" class="c_val form-control"/><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_checkbox" data-field="' + field + '"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_checkbox" data-field="' + field + '"></i></div></div>');
        var options = '';
        $('.checkbox_row_' + field).each(function () {
            var opt = $(this).find('.c_opt').val();
            var val = $(this).find('.c_val').val();
            var s_opt = $(this).attr('data-opt');
            options += '<label class="mt-checkbox mt-checkbox-outline" style="padding-right:25px !important;"><input data-opt="' + s_opt + '" name="checkbox_' + field + '" type="checkbox" value="' + opt + '"> <p class="c_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
        });
        $('.checkbox_list_' + field).html(options);
        getPreview();
    });
    $(document).on('keyup', '.s_opt', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('select[name=select_' + field + ']').find('option[data-opt=' + option + ']').html(op_val);
        getPreview();
    });
    $(document).on('keyup', '.s_val', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('select[name=select_' + field + ']').find('option[data-opt=' + option + ']').val(op_val);
        getPreview();
    });
    $(document).on('keyup', '.r_opt', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.radio_list_' + field).find('.r_opt_name_' + option).html(op_val);
        $('.radio_list_' + field).find('.r_opt_name_' + option).val(op_val);
        getPreview();
    });
    $(document).on('keyup', '.r_val', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.radio_list_' + field).find('input[data-opt=' + option + ']').val(op_val);
        getPreview();
    });
    $(document).on('keyup', '.c_opt', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.checkbox_list_' + field).find('.c_opt_name_' + option).html(op_val);
        getPreview();
    });
    $(document).on('keyup', '.c_val', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.checkbox_list_' + field).find('input[data-opt=' + option + ']').val(op_val);
        getPreview();
    });
    $(document).on('click', '.edit_bal_textfield', function () {
        var field = $(this).attr('data-field');
        var el = $('.field_extra_info_' + field);
        el.html('<div class="form-group"><label>Label</label><input type="text" name="label_' + field + '" class="form-control" placeholder="Enter Text Field Label"/></div><div class="mt-checkbox-list"><label class="mt-checkbox mt-checkbox-outline" style="padding-right:25px !important;"><input name="req_' + field + '" type="checkbox" value="1">Required<span></span></label></div>');
        getPreview();
    });
    $(document).on('click', '.remove_bal_field', function (e) {
        e.preventDefault();
        var field = $(this).attr('data-field');
        $(this).closest('.li_' + field).hide('400', function () {
            $(this).remove();
            getPreview();
        });
    });
    $(document).on('click', '.remove_more_select', function () {
        var field = $(this).attr('data-field');
        $(this).closest('.select_row_' + field).hide('400', function () {
            $(this).remove();
            var options = '';
            $('.select_row_' + field).each(function () {
                var opt = $(this).find('.s_opt').val();
                var val = $(this).find('.s_val').val();
                var s_opt = $(this).attr('data-opt');
                options += '<option data-opt="' + s_opt + '" value="' + opt + '">' + opt + '</option>';
            });
            $('select[name=select_' + field + ']').html(options);
            getPreview();
        });
    });
    $(document).on('click', '.remove_more_radio', function () {
        var field = $(this).attr('data-field');
        $(this).closest('.radio_row_' + field).hide('400', function () {
            $(this).remove();
            var options = '';
            $('.radio_row_' + field).each(function () {
                var opt = $(this).find('.r_opt').val();
                var val = $(this).find('.r_val').val();
                var s_opt = $(this).attr('data-opt');
                options += '<label class="mt-radio mt-radio-outline" style="padding-right:25px !important;"><input data-opt="' + s_opt + '" type="radio" name="radio_' + field + '" value="' + opt + '"> <p class="r_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
            });
            $('.radio_list_' + field).html(options);
            getPreview();
        });
    });
    $(document).on('click', '.remove_more_checkbox', function () {
        var field = $(this).attr('data-field');
        $(this).closest('.checkbox_row_' + field).hide('400', function () {
            $(this).remove();
            var options = '';
            $('.checkbox_row_' + field).each(function () {
                var opt = $(this).find('.c_opt').val();
                var val = $(this).find('.c_val').val();
                var s_opt = $(this).attr('data-opt');
                options += '<label class="mt-checkbox mt-checkbox-outline" style="padding-right:25px !important;"><input data-opt="' + s_opt + '" name="checkbox_' + field + '" type="checkbox" value="' + opt + '"> <p class="r_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
            });
            $('.checkbox_list_' + field).html(options);
            getPreview();
        });
    });
    $(document).on('keyup', '.form_input_button_class', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_button_value', function () {
        getPreview();
    });
    $(document).on('change', '.form_input_req', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_placeholder', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_label', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_name', function () {
        getPreview();
    });
    function generateField() {
        return Math.floor(Math.random() * (100000 - 1 + 1) + 57);
    }
    function getPreview(plain_html = '') {
        //var el = $('.form_builder_area .form_output');
        var el = $('#abcDiv .form_output');
        var html = '';
        var namecount=0;
        el.each(function () {
            namecount++;
            var name =  'add_field'+namecount;
            var data_type = $(this).attr('data-type');
            var label = $(this).find('.form_input_label').val();
            var label = makeCamelCase(label);
            if (data_type === 'file') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).find('.form-check-input');
                var required = reqclass = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
                }

                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><input type="file" name="' + name + '" class="form-control add_field add_field_file" is_valid="1" ' + required + '/><input type="hidden" name="'+name+'_label" value="'+label+'"/><small style="font-weight:bold;">Only Supported Files are JPG, JPEG, PNG, PDF</small><span class="invalidText image_err" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }

            if (data_type === 'text') {
                var placeholder = makeCamelCase($(this).find('.form_input_placeholder').val());
                var checkbox = $(this).find('.form-check-input');
                var required = reqclass = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
                }

                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><input type="text" name="' + name + '" placeholder="' + placeholder + '" class="form-control add_field" ' + required + '/><input type="hidden" name="'+name+'_label" value="'+label+'"/><span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'number') {
                var placeholder = makeCamelCase($(this).find('.form_input_placeholder').val());
                var checkbox = $(this).find('.form-check-input');
                var required = reqclass = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
                }
                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><input type="number" name="' + name + '" placeholder="' + placeholder + '" class="form-control add_field" ' + required + '/><input type="hidden" name="'+name+'_label" value="'+label+'"/><span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'email') {
                var placeholder = makeCamelCase($(this).find('.form_input_placeholder').val());
                var checkbox = $(this).find('.form-check-input');
                var required = reqclass = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
                }
                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><input type="email" name="' + name + '" placeholder="' + placeholder + '" class="form-control add_field" ' + required + '/><input type="hidden" name="'+name+'_label" value="'+label+'"/><span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'password') {
                var placeholder = makeCamelCase($(this).find('.form_input_placeholder').val());
                var checkbox = $(this).find('.form-check-input');
                var required = reqclass = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
                }
                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><input type="password" name="' + name + '" placeholder="' + placeholder + '" class="form-control add_field" ' + required + '/><input type="hidden" name="'+name+'_label" value="'+label+'"/><span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'textarea') {
                var placeholder = makeCamelCase($(this).find('.form_input_placeholder').val());
                var checkbox = $(this).find('.form-check-input');
                var required = reqclass = '';
                if (checkbox.is(':checked')) {
                    reqclass = 'required';
                    required = 'required';
                }
                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><textarea rows="5" name="' + name + '" placeholder="' + placeholder + '" class="form-control add_textarea" ' + required + '></textarea><input type="hidden" name="'+name+'_label" value="'+label+'"/><span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'date') {
                var checkbox = $(this).find('.form-check-input');
                var required = reqclass = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
               }
                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><input type="date" name="' + name + '" class="form-control add_field" ' + required + '/><input type="hidden" name="'+name+'_label" value="'+label+'"/><span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'button') {
                var btn_class = $(this).find('.form_input_button_class').val();
                var btn_value = $(this).find('.form_input_button_value').val();
                html += '<button name="' + name + '" type="submit" class="' + btn_class + '">' + btn_value + '</button>';
            }
            if (data_type === 'select') {
                var option_html = '';
                $(this).find('select option').each(function () {
                    var option = $(this).html();
                    var value = $(this).val();
                    option_html += '<option value="' + option + '">' + option + '</option>';
                });

                var required = reqclass = '';
                var checkbox = $(this).parents('.form_builder_field').find('.form-check-input');
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
                }

                html += '<div class="form-group '+reqclass+'"><label class="control-label">' + label + '</label><input type="hidden" name="'+name+'_label" value="'+label+'"/><select class="form-control add_dropdown" name="' + name + '"  ' + required + '>' + option_html + '</select><span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'radio') {
                var required = reqclass = '';
                var checkbox = $(this).parents('.form_builder_field').find('.form-check-input');
                if (checkbox.is(':checked')) {
                    required = 'required';
                    reqclass = 'required';
                }                   

                var option_html = '';
                $(this).find('.mt-radio').each(function () {
                    var option = $(this).find('p').html();
                    var value = $(this).find('input[type=radio]').val();
                    option_html += '<div class="form-check"><small style="font-weight:bold;"><input type="hidden" name="'+name+'_label" value="'+label+'"/><input type="radio" class="form-check-input add_radio" name="' + name + '" value="' + option + '" ' + required + '> ' + option + '</small></div>';
                });
             

                html += '<div class="form-group  '+reqclass+'"><label class="control-label">' + label + '</label>' + option_html + '<span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
            if (data_type === 'checkbox') {

                var option_html = '';

                $(this).find('.mt-checkbox').each(function () {
                    var option = $(this).find('p').html();
                    var value = $(this).find('input[type=checkbox]').val();
                
                    var required = reqclass = '';
                    var checkbox = $(this).parents('.form_builder_field').find('.form-check-input');
                    if (checkbox.is(':checked')) {
                        required = 'required';
                        reqclass = 'required';
                    }                     
                    option_html += '<div class="form-check"><small style="font-weight:bold;"><input type="hidden" name="'+name+'_label" value="'+label+'"/><input type="checkbox" class="form-check-input add_checkbox" name="' + name + '[]" value="' + option + '" ' + required + '> ' + option + '</small></div>';
                });
                html += '<div class="form-group  '+reqclass+'"><label class="control-label">' + label + '</label>' + option_html + '<span class="invalidText" style="display: none;padding: 5px 0px 3px 0px;"></span></div>';
            }
        });
    
        if (plain_html === 'html' || plain_html === 'update_html') {
            console.log('html',html);

            $('.plain_html').find('textarea').val(html);
            var temp_name =  $('#frm_temp_name').val();
            if(temp_name==''){ 
                $('#frm_temp_name').focus();
                $('#temp_name_err').html('Please add Template name').css('display','block');
                return false;
            }

            if(html==''){ 
                $('#html_err').html('Please add Form fields').css('display','block');
                return false;
            }else{
                var editable_html = $('#EditView_html_div').html();
            }
            console.log('editable_html',editable_html);
        }
        if (plain_html === 'html') {
            url = $('#add_frm_template').attr('action');
            //$('.plain_html').find('textarea').val(html);

            // var temp_name =  $('#frm_temp_name').val();
            // if(temp_name==''){ 
            //     $('#frm_temp_name').focus();
            //     $('#temp_name_err').html('Please add Template name').css('display','block');
            //     return false;
            // }

            // if(html==''){ 
            //     $('#html_err').html('Please add Form fields').css('display','block');
            //     return false;
            // }else{
            //     var editable_html = $('#EditView_html_div').html();
            // }

            // console.log('addnew editable_html',editable_html);
            $.ajax({
                url: url,
                type: "POST",
                data:{'temp_name':temp_name,'frm_manager':html,'editable_html':editable_html},
                dataType: "json",
                beforeSend:function(){
                    ajaxindicatorstart();
                    $('.invalidText').hide();
                },
                success: function(res) {
                    ajaxindicatorstop();
                    if(res.success) {
                        $('#add_frm_template')[0].reset();
                        $('#preview').html('');
                        $('#abcDiv .form_builder_field').remove();


                        $('#errorMsg').addClass('hide').removeClass('show');
                        $('#successMsg').addClass('show').removeClass('hide').html(res.msg);
                        
                        setTimeout( function(){ 
                            $('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
                          }  , 10000 );
                    }else{
                        $('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
                        $('#successMsg').addClass('hide').removeClass('show');
                        allIsOk = false;
                    }
                    $('html, body').animate({
                        scrollTop: $(".dashBody").offset().top
                    }, 1000);
                }
            });

        }else if(plain_html === 'update_html'){

            url = $('#update_frm_template').attr('action');
            // $('.plain_html').find('textarea').val(html);
            // var temp_id =  $('#temp_id').val();
            // var temp_name =  $('#frm_temp_name').val();
            // if(temp_name==''){ 
            //     $('#frm_temp_name').focus();
            //     $('#temp_name_err').html('Please add Template name');
            //     return false;
            // }

            // if(html==''){ 
            //     $('#html_err').html('Please add Form fields');
            //     return false;
            // }else{
            //     var editable_html = $('#EditView_html_div').html();
            // }
            var tmp_id = $('#tmp_id').val();

            $.ajax({
                url: url,
                type: "POST",
                data:{'tmp_id':tmp_id,'temp_name':temp_name,'frm_manager':html,'editable_html':editable_html},
                dataType: "json",
                beforeSend:function(){
                    ajaxindicatorstart();
                    $('.invalidText').hide();
                },
                success: function(res) {
                    ajaxindicatorstop();
                    if(res.success) {
                        $('#errorMsg').addClass('hide').removeClass('show');
                        $('#successMsg').addClass('show').removeClass('hide').html(res.msg);
                        
                        setTimeout( function(){ 
                            $('#errorMsg , #successMsg').addClass('hide').removeClass('show').fadeOut('slow');
                          }  , 10000 );
                    }else{
                        $('#errorMsg').addClass('show').removeClass('hide').html(res.msg);
                        $('#successMsg').addClass('hide').removeClass('show');
                        allIsOk = false;
                    }
                    $('html, body').animate({
                        scrollTop: $(".dashBody").offset().top
                    }, 1000);
                }
            });
        }
         else {
            $('.preview').html(html).show();
        }
    }

    function makeHtmlForEditView(){
        $('#EditView_html_div').html('');
        var el = $('#abcDiv .form_output');
        var EditView_html = '<div class="form_builder_area ui-sortable">';
        var namecount=0;
        el.each(function () {
            var data_type = $(this).attr('data-type');
            var label = $(this).find('.form_input_label').val();
            var label = makeCamelCase(label);           
            if($(this).find('.form_input_placeholder').length>0){
                var placeholder = makeCamelCase($(this).find('.form_input_placeholder').val());
            }else{
                var placeholder = '';
            }

            var checkbox = $(this).find('.form-check-input');

            var part1 = '<div class="li_'+namecount+' form_builder_field" style="width: 376px; height: 239px;"><div class="all_div"><div class="row li_row"><div class="col-md-12"><b>';
            
            if (data_type === 'text'){
                var part2='Text Field';
            }else if(data_type === 'textarea'){
                var part2='Paragraph Field';
            }else if(data_type === 'select'){
                var part2='Select Field';
                var checkbox = $(this).next('.li_row').find('.form-check-input');
            }else if(data_type === 'radio'){
                var part2='Radio Field';
                var checkbox = $(this).next('.li_row').find('.form-check-input');
            }else if(data_type === 'checkbox'){
                var part2='Checkbox Field';
                var checkbox = $(this).next('.li_row').find('.form-check-input');
            }else if(data_type === 'number'){
                var part2='Numeric Field';
            }else if(data_type === 'file'){
                var part2='File Upload Field';
            }

            var part3 = '</b><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="'+namecount+'"><i class="fa fa-times"></i></button></div></div></div>';
            var part4 = '<div class="row li_row form_output" data-type="'+data_type+'" data-field="'+namecount+'">';


            if(data_type === 'select'){
                var option_html = '';
                var opt = '';
                var f=0;
                $(this).find('select option').each(function () {
                    var option = $(this).html();
                    var value = $(this).val();
                    option_html += '<option value="' + option + '">' + option + '</option>';

                    if(f>0){
                        opt +='<div data-field="'+namecount+'" class="row select_row_'+namecount+'" data-opt="'+f+'"><div class="col-md-4"><div class="form-group"><input type="text" value="'+option+'" class="s_opt form-control"></div></div><input type="hidden" value="'+option+'" class="s_val form-control"><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_select" data-field="'+namecount+'"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_select" data-field="'+namecount+'"></i></div></div>';
                    }else{
                        opt +='<div data-field="'+namecount+'" class="row select_row_'+namecount+'" data-opt="'+f+'"><div class="col-md-4"><div class="form-group"><input type="text" value="'+option+'" class="s_opt form-control"></div></div><input type="hidden" value="'+option+'" class="s_val form-control"><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_select" data-field="'+namecount+'"></i></div></div>';
                    }
                    f++;
                });
                var part5 ='<div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_'+namecount+'" class="form-control form_input_label" value="'+label+'" data-field="'+namecount+'"></div></div><div class="col-md-12"><div class="form-group"><select name="select_'+namecount+'" class="form-control">'+option_html+'</select></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_'+namecount+'">'+opt+'</div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label">';    
            }else if(data_type === 'radio'){
                var option_html = '';
                var opt = '';
                var f=0;
                $(this).find('.mt-radio').each(function () {

                    var option = $(this).find('p').html();
                    console.log('option',option);
                    option_html += '<label class="mt-radio mt-radio-outline" style="padding-right:25px !important;"><input data-opt="'+f+'" name="radio_'+namecount+'" type="radio" value="'+option+'"><p class="r_opt_name_'+f+'"> '+option+'</p><span></span></label>';

                    if(f>0){
                        opt +='<div data-field="'+namecount+'" class="row radio_row_'+namecount+'" data-opt="'+f+'"><div class="col-md-4"><div class="form-group"><input type="text" value="'+option+'" class="r_opt form-control"></div></div><input type="hidden" value="'+option+'" class="r_val form-control"><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="'+namecount+'"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_radio" data-field="'+namecount+'"></i></div></div>';
                    }else{
                        opt +='<div data-field="'+namecount+'" class="row radio_row_'+namecount+'" data-opt="'+f+'"><div class="col-md-4"><div class="form-group"><input type="text" value="'+option+'" class="r_opt form-control"></div></div><input type="hidden" value="'+option+'" class="r_val form-control"><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="'+namecount+'"></i></div></div>';
                    }
                    f++;

                });
                var part5 ='<div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_'+namecount+'" class="form-control form_input_label" value="'+label+'" data-field="'+namecount+'"></div></div><div class="col-md-12"><div class="form-group"><div class="mt-radio-list radio_list_'+namecount+'">'+option_html+'</div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_'+namecount+'">'+opt+'</div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label">';    
            }else if(data_type === 'checkbox'){
                var option_html = '';
                var opt = '';
                var f=0;
                $(this).find('.mt-checkbox').each(function () {
                    var option = $(this).find('p').html();
                    option_html += '<label class="mt-checkbox mt-checkbox-outline" style="padding-right:25px !important;"><input data-opt="'+f+'" name="checkbox_'+namecount+'" type="checkbox" value="'+option+'"><p class="c_opt_name_'+f+'"> '+option+'</p><span></span></label>';

                    if(f>0){
                        opt +='<div data-field="'+namecount+'" class="row checkbox_row_'+namecount+'" data-opt="'+f+'"><div class="col-md-4"><div class="form-group"><input type="text" value="'+option+'" class="c_opt form-control"></div></div><input type="hidden" value="'+option+'" class="c_val form-control"><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_checkbox" data-field="'+namecount+'"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_checkbox" data-field="'+namecount+'"></i></div></div>';
                    }else{
                        opt +='<div data-field="'+namecount+'" class="row checkbox_row_'+namecount+'" data-opt="'+f+'"><div class="col-md-4"><div class="form-group"><input type="text" value="'+option+'" class="c_opt form-control"></div></div><input type="hidden" value="'+option+'" class="c_val form-control"><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_checkbox" data-field="'+namecount+'"></i></div></div>';
                    }
                    f++;
                });
                var part5 ='<div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_'+namecount+'" class="form-control form_input_label" value="'+label+'" data-field="'+namecount+'"></div></div><div class="col-md-12"><div class="form-group"><div class="mt-checkbox-list checkbox_list_'+namecount+'">'+option_html+'</div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_'+namecount+'">'+opt+'</div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label">';    

            }else if(data_type === 'file'){
                var part5 ='<div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_'+namecount+'" class="form-control form_input_label" value="'+label+'" data-field="'+namecount+'"></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label">';
            }else{
                var part5 ='<div class="col-md-12"><div class="form-group"><label>Label</label><input type="text" name="label_'+namecount+'" class="form-control form_input_label" value="'+label+'" data-field="'+namecount+'"></div></div><div class="col-md-12"><div class="form-group"><label>Placeholder</label><input type="text" name="placeholder_'+namecount+'" data-field="'+namecount+'" class="form-control form_input_placeholder" placeholder="Placeholder" value="'+placeholder+'"></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label">';
            }
            
            if (checkbox.is(':checked')) {
                var part6 ='<input data-field="'+namecount+'" type="checkbox" checked class="form-check-input form_input_req">Required</label></div></div></div></div>';
            }else{
                var part6 ='<input data-field="'+namecount+'" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div></div>';
            }

            EditView_html += part1+part2+part3+part4+part5+part6;
            namecount++;

        });
        EditView_html += '</div>';
        $('#EditView_html_div').html(EditView_html);
    }

    $(document).on('click', '.export_html', function () {
        makeHtmlForEditView();
        getPreview('html');
    });

    $(document).on('click', '.update_html', function () {
        makeHtmlForEditView();
        getPreview('update_html');
    });
    
    if($('#temp_id').length>0){
        getPreview();
    }

function makeCamelCase(str){
    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });    
    return str;
}





});