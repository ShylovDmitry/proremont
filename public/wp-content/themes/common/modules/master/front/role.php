<?php

add_action('after_switch_theme', function() {
    add_role(
        'master',
        'Мастер',
        array(
            'read' => true,
        )
    );
});

add_action('switch_theme', function() {
    remove_role('master');
});

//////////////////////////////////////////
//add_action('init', function() {
//    remove_role('master');
//    add_role(
//        'master',
//        'Мастер',
//        array(
//            'read' => true,
//            'upload_files' => true,
//        )
//    );

//    remove_role('visitor');
//    add_role(
//        'visitor',
//        'Посетитель',
//        array(
//            'read' => true,
//        )
//    );
//});
//////////////////////////////////////////
