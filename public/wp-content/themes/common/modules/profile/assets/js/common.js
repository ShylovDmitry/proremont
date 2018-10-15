jQuery(function ($) {

    if (typeof tinyMCE != 'undefined') {
        tinyMCE.PluginManager.add('header-button', function (editor, url) {
            ['h2'].forEach(function (name) {
                editor.addButton("header", {
                    tooltip: "Header",
                    text: "Header",
                    onClick: function () {
                        editor.execCommand('mceToggleFormat', false, name);
                    },
                    onPostRender: function () {
                        var self = this, setup = function () {
                            editor.formatter.formatChanged(name, function (state) {
                                self.active(state);
                            });
                        };
                        editor.formatter ? setup() : editor.on('init', setup);
                    }
                })
            });
        });
    }


    $('#categories').select2({
        maximumSelectionLength: 3,
        matcher: function(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }
            if (typeof data.children === 'undefined') {
                return null;
            }

            var filteredChildren = [];
            $.each(data.children, function (idx, child) {
                if ($.trim(child.text).toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
                    filteredChildren.push(child);
                }
            });

            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                return modifiedData;
            }
            return null;
        }
    });


    $('#user_city').select2({
        escapeMarkup: function(markup) {
            return markup;
        },
        templateResult: function(data) {
            if (!data.parent) {
                return data.text;
            }

            return data.text + ' <span>(' + data.parent + ')</span>';
        },
        ajax: {
            url: ProRemontObj.ajaxurl,
            dataType: 'json',
            data: function (params) {
                var query = {
                    action: 'pror_profile_search_city',
                    term: params.term
                };

                return query;
            }
        }
    });

    function enableFiles() {
        $("#files").removeClass('loading').sortable('enable');
    }

    function disableFiles() {
        $("#files").addClass('loading').sortable('disable');
    }

    $('#fileupload').fileupload({
        url: ProRemontObj.ajaxurl,
        dataType: 'json',
        formData: {
            action: 'pror_profile_image_upload'
        },
        start: function (e) {
            disableFiles();
        },
        stop: function (e) {
            enableFiles();
        },
        add: function(e, data) {
            data.submit();
        },
        done: function(e, data) {
            var res = data.result;

            if (!res.success) {
                // TODO: display error
                return;
            }

            $('#files').append('' +
                '<div class="image-col" data-image-id="' + res.data.id + '">' +
                    '<input type="hidden" name="user_images[]" value="' + res.data.id + '">' +
                    '<div class="image-wrapper">' +
                        '<button type="button" class="close" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '<img src="' + res.data.url + '">' +
                    '</div>' +
                '</div>' +
                '');
        }
    });

    $("#files").sortable({
        revert: true,
        cursor: "move"
    });

    $("#files").on('click', '.close', function(e) {
        $(this).parents('[data-image-id]').remove();
    });






    $('#logoupload').fileupload({
        url: ProRemontObj.ajaxurl,
        dataType: 'json',
        formData: {
            action: 'pror_profile_image_upload'
        },
        start: function (e) {
            // disableFiles();
        },
        stop: function (e) {
            // enableFiles();
        },
        add: function(e, data) {
            data.submit();
        },
        done: function(e, data) {
            var res = data.result;

            if (!res.success) {
                // TODO: display error
                return;
            }

            $('#logo-block').append('' +
                    '<div data-image-id="' + res.data.id + '">' +
                        '<input type="hidden" name="logo_id" value="' + res.data.id + '">' +
                        '<div class="image-wrapper">' +
                            '<button type="button" class="close" aria-label="Close">' +
                                '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '<img src="' + res.data.url + '">' +
                        '</div>' +
                    '</div>' +
                '');

            $('.upload-logo').addClass('d-none');
        }
    });

    $("#logo-block").on('click', '.close', function(e) {
        $(this).parents('[data-image-id]').remove();
        $('.upload-logo').removeClass('d-none');
    });


    function prorErrorPlacement(label, element) {
        // position error label after generated textarea
        if (element.is("#categories") || element.is("#user_city")) {
            label.insertAfter(element.next());
        } else if (element.is("#user_description")) {
            label.insertAfter(element.parent());
        } else {
            label.insertAfter(element)
        }
    }

    $('.from-validation-advanced').submit(function() {
        tinyMCE.triggerSave();
    }).validate({
        ignore: "",
        rules: {
            user_description: 'required'
        },
        errorPlacement: prorErrorPlacement
    });

    $('.from-validation-simple').validate({
        errorPlacement: prorErrorPlacement
    });
});
