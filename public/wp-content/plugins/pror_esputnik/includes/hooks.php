<?php

defined( 'ABSPATH' ) or die();

remove_action('register_new_user', 'wp_send_new_user_notifications');
add_action('register_new_user', function($user_id) {
    wp_send_new_user_notifications($user_id, 'admin');
});

add_action('user_register', function($user_id) {
    if (!pror_user_has_role('master subscriber', $user_id)) {
        return;
    }
    $contact = pror_esputnik_create_contact($user_id);

    if ($contact) {
        $data = [
            'contact' => $contact,
            'groups' => pror_user_has_role('master', $user_id) ? eSputnikApi::GROUP_MASTERS : eSputnikApi::GROUP_SUBSCRIBERS,
        ];
        pror_esputnik_queue_action('CONTACT_POST', $data);


        $user = get_userdata($user_id);
        if (!$user->user_url) {
            $email = $user->user_email;
            if ($email) {
                $adt_rp_key = get_password_reset_key($user);
                $user_login = $user->user_login;

                $data = [
                    'event' => [
                        'eventTypeKey' => 'user_registered',
                        'keyValue' => $email,
                        'params' => [
                            ['name' => 'EmailAddress', 'value' => $email],
                            ['name' => 'ResetPasswordLink', 'value' => site_url("wp-login.php?action=rp&key=$adt_rp_key&login=" . rawurlencode($user_login), 'login')],
                        ]
                    ],
                ];
                pror_esputnik_queue_action('EVENT_POST', $data);
            }
        }
    }
}, 11);

add_action('profile_update', function($user_id, $old_user_data) {
    $old_user = $old_user_data;
    $old_email = ($old_user) ? $old_user->user_email : null;

    $user = get_userdata($user_id);
    $email = $user->user_email;
    $contact = pror_esputnik_create_contact($user_id);

    if ($email && $contact) {
        $data = [
            'contact' => $contact,
            'groups' => pror_user_has_role('master', $user_id) ? eSputnikApi::GROUP_MASTERS : eSputnikApi::GROUP_SUBSCRIBERS,
            'new_email' => ($old_email != $email) ? $old_email : null,
        ];
        pror_esputnik_queue_action('CONTACT_POST', $data);


        if ($old_email != $email && strpos($old_email, 'ProRemont.Catalog+') === 0) {
            $data = [
                'event' => [
                    'eventTypeKey' => 'user_change_email',
                    'keyValue' => $email,
                    'params' => [
                        ['name' => 'EmailAddress', 'value' => $email],
                    ]
                ],
            ];
            pror_esputnik_queue_action('EVENT_POST', $data);
        }
    }
}, 11, 2);

add_action('delete_user', function($user_id, $reassign) {
    $contact = pror_esputnik_create_contact($user_id);

    if ($contact) {
        $data = [
            'contact' => $contact,
            'groups' => [],
        ];
        pror_esputnik_queue_action('CONTACT_POST', $data);
    }
}, 11, 2);

function pror_esputnik_create_contact($user_id) {
    $user = get_userdata($user_id);
    if (!$user || !$user->user_email) {
        return false;
    }

    $contact = [
        'firstName' => $user->first_name,
        'lastName' => $user->last_name,
        'channels' => [
                ['type' => 'email', 'value' => $user->user_email],
        ],
    ];

    $contact_phone = pror_format_phones(get_field("contact_phone", "user_{$user_id}"));
    if ($contact_phone) {
        $contact['channels'][] = ['type' => 'sms', 'value' => $contact_phone['tel']];
    }


    if (pror_user_has_role('master', $user_id)) {
        $CUSTOM_FIELDS = [
            'MASTER_PROFILE_URL' => 76993,
            'MASTER_CATALOG' => 76998,
            'MASTER_IS_CONFIRMED' => 77003,
            'MASTER_TYPE' => 77004,
            'MASTER_TITLE' => 89954,
        ];

        $contact['fields'] = [
            [
                'id' => $CUSTOM_FIELDS['MASTER_TITLE'],
                'value' => get_field('master_title', "user_{$user_id}"),
            ],
            [
                'id' => $CUSTOM_FIELDS['MASTER_IS_CONFIRMED'],
                'value' => get_field('master_is_confirmed', "user_{$user_id}") ? '1' : '',
            ],
            [
                'id' => $CUSTOM_FIELDS['MASTER_TYPE'],
                'value' => get_field('master_type', "user_{$user_id}"),
            ],
        ];

        $posts = get_posts(array(
            'author' => $user_id,
            'posts_per_page' => 1,
            'post_type' => 'master',
            'post_status' => 'any',
        ));
        $post_id = isset($posts, $posts[0], $posts[0]->ID) ? $posts[0]->ID : false;
        if ($post_id) {
            $contact['fields'][] = [
                'id' => $CUSTOM_FIELDS['MASTER_PROFILE_URL'],
                'value' => get_permalink($post_id),
            ];

            $catalogs = [];
            foreach (pror_get_master_catalogs($post_id) as $cat) {
                $term = pror_find_term_by('id', $cat->term_id, pll_current_language(), pll_default_language());
                $catalogs[] = $term->name;

                foreach ($cat->children as $child) {
                    $term = pror_find_term_by('id', $child->term_id, pll_current_language(), pll_default_language());
                    $catalogs[] = $term->name;
                }
            }
            $contact['fields'][] = [
                'id' => $CUSTOM_FIELDS['MASTER_CATALOG'],
                'value' => '|' . implode('|', $catalogs) . '|',
            ];


            $loc = pror_get_master_location($post_id);
            if ($loc) {
                $contact['address'] = ['region' => $loc[0], 'town' => $loc[1]];
            }
        }
    }

    return $contact;
}
