jQuery(function ($) {
    $('#create-tender-response').submit(function(e) {
        e.preventDefault();

        var params = {
            action: 'pror_tender_action',
            type: 'create_tender_response',
            tender_id: $('[name=tender_id]', this).val(),
            comment: $('[name=comment]', this).val(),
            comment_visibility: $('[name=comment_visibility]', this).val()
        };
        $.post(ProRemontObj.ajaxurl, params, function (response) {
            console.log(response);
        });

    });
});
