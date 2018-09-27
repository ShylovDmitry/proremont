jQuery(function ($) {

    $('#loginform').submit(function(e) {
        e.preventDefault();

        // TODO: display loading

        var data = {
            action: 'pror_profile_login',
            log: $('#user_login').val(),
            pwd: $('#user_pass').val()
        };

        $.post(ProRemontObj.ajaxurl, data, function (response) {
            if (response.success) {
                // TODO: redirect to profile page
            } else {
                // TODO: display error
                console.log(response);
            }
        });
    });

    $('#registerform').submit(function(e) {
        e.preventDefault();

        // TODO: display loading

        var data = {
            action: 'pror_profile_register',
            user_first_name: $('#user_first_name').val(),
            user_last_name: $('#user_last_name').val(),
            user_email: $('#user_email').val(),
            user_tel: $('#user_tel').val()
        };

        $.post(ProRemontObj.ajaxurl, data, function (response) {
            if (response.success) {
                // TODO: redirect to profile page
            } else {
                // TODO: display error
                console.log(response);
            }
        });
    });
});
