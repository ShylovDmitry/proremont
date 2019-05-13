<?php

add_filter('wpseo_og_og_image', 'pror_cover_og_tag_image');
add_filter('wpseo_og_og_image_secure_url', 'pror_cover_og_tag_image');

add_filter('wpseo_og_og_image_width', function($content) {
    if (in_array(get_post_type(), array('master', 'post', 'page', 'partner', 'tender'))) {
        return 1200;
    }
    return $content;
});
add_filter('wpseo_og_og_image_height', function($content) {
    if (in_array(get_post_type(), array('master', 'post', 'page', 'partner', 'tender'))) {
        return 630;
    }
    return $content;
});

function pror_cover_og_tag_image($content) {
	switch (get_post_type()) {
		case 'master':
			return home_url('/cover/m/' . get_the_author_meta('ID') . '/') . '?t=' . get_the_modified_date('U');

		case 'tender':
			return home_url('/cover/tender/' . get_the_ID() . '/') . '?t=' . get_the_modified_date('U');

		case 'post':
		case 'page':
		case 'partner':
			return home_url('/cover/post/' . get_the_ID() . '/') . '?t=' . get_the_modified_date('U');

		default:
			return $content;
	}
}

function pror_cover_generate_image($type, $id) {
	switch ($type) {
		case 'm':
			pror_cover_generate_master_image($id);
			break;

		case 'tender':
			$title = pror_tender_get_title($id);
			pror_cover_generate_post_image($id, $title);
			break;

		case 'post':
		case 'page':
		case 'partner':
			pror_cover_generate_post_image($id);
			break;

		default:
			break;
	}
}

function pror_cover_generate_master_image($user_id) {
    $title = get_field('master_title', "user_{$user_id}");
    $logo_id = get_field('master_logo', "user_{$user_id}");
    $padding = 50;
    $image_size = 260;

    $imagine = new Imagine\Gd\Imagine();
    $image = $imagine->open(__DIR__ . '/../assets/img/1200-master-fb2.jpg');

    try {
        $logo = wp_get_attachment_image_src($logo_id, 'pror-medium');
        if ($logo) {
            $image->paste($imagine->open($logo[0])->thumbnail(new \Imagine\Image\Box($image_size, $image_size)), new Imagine\Image\Point($padding, $padding));
        }
    } catch (Exception $e) {
    }

    try {
        $font_path = __DIR__ . '/../assets/font/GothamPro/GothamProMedium.ttf';
        $font = $imagine->font($font_path, 48, new \Imagine\Image\Color('fff'));

        $lines = pror_cover_split_lines($title, $font, $image->getSize()->getWidth() - $padding * 3 - $image_size);
        $line_height = $font->box($title)->getHeight() * 1.2;
        for ($i = 0; $i < min(4, count($lines)); $i++) {
            $image->draw()->text($lines[$i], $font, new \Imagine\Image\Point($image_size + $padding*2, $padding + $i*$line_height));
        }

        $image->show('jpg');
    } catch (Exception $e) {
        if (!WP_ENV_PROD) {
            var_dump($e);
        }
    }
}

function pror_cover_generate_post_image($post_id, $title = null) {
	if (!$title) {
		$title = get_the_title($post_id);
	}
    $padding = 50;

    $imagine = new Imagine\Gd\Imagine();
    $image = $imagine->open(__DIR__ . '/../assets/img/1200-master-fb2.jpg');

    try {
        $font_path = __DIR__ . '/../assets/font/GothamPro/GothamProMedium.ttf';
        $font = $imagine->font($font_path, 40, new \Imagine\Image\Color('fff'));

        $lines = pror_cover_split_lines($title, $font, $image->getSize()->getWidth() - $padding * 2);
        $line_height = $font->box($title)->getHeight() * 1.2;
        for ($i = 0; $i < min(5, count($lines)); $i++) {
            $image->draw()->text($lines[$i], $font, new \Imagine\Image\Point($padding, $padding + $i*$line_height));
        }

        $image->show('jpg');
    } catch (Exception $e) {
        if (!WP_ENV_PROD) {
            var_dump($e);
        }
    }
}


function pror_cover_split_lines($text, $font, $width) {
    $words = explode(' ', $text);
    $start = 0;
    $length = count($words)+1;
    $lines = [];

    for ($i = 0; $i < $length;) {
        $str = implode(' ', array_slice($words, $start, $i+1-$start));

        if ($font->box($str)->getWidth() < $width && $i+1 < $length) {
            $i++;
            continue;
        }
        if ($i+1 == $length) {
            $i++;
        }

        $lines[] = implode(' ', array_slice($words, $start, $i-$start));
        $start = $i;

    }

    return $lines;
}
