jQuery(function ($) {

    tinyMCE.PluginManager.add('header-button', function(editor, url) {
        ['h2'].forEach(function(name){
            editor.addButton("header", {
                tooltip: "Header",
                text: "Header",
                onClick: function() { editor.execCommand('mceToggleFormat', false, name); },
                onPostRender: function() {
                    var self = this, setup = function() {
                        editor.formatter.formatChanged(name, function(state) {
                            self.active(state);
                        });
                    };
                    editor.formatter ? setup() : editor.on('init', setup);
                }
            })
        });
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
});
