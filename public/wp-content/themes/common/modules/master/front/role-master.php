<?php

add_action('init', function() {
//    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

//    $role = get_role('subscriber');
//    $role->remove_cap('upload_files');

    if (!get_role('master')) {
        pror_create_master_role();
    }
});

add_action('after_switch_theme', function() {
    pror_create_master_role();
});

add_action('switch_theme', function() {
    remove_role('master');
});

function pror_create_master_role() {
    add_role(
        'master',
        'Мастер',
        array(
            'read' => true,
            'upload_files' => true,
        )
    );
}
