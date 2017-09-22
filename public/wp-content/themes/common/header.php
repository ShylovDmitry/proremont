<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title('&ndash;', true, 'right'); ?></title>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php module_template('theme/header'); ?>
