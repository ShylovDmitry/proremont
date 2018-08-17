<!DOCTYPE html>
<html lang="<?php echo pll_current_language(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title('&ndash;', true, 'right'); ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php module_img('theme/favicon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php module_img('theme/favicon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php module_img('theme/favicon/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?php module_img('theme/favicon/manifest.json'); ?>">
    <link rel="mask-icon" href="<?php module_img('theme/favicon/safari-pinned-tab.svg'); ?>" color="#5bbad5">
    <link rel="shortcut icon" href="<?php module_img('theme/favicon/favicon.ico'); ?>">
    <meta name="apple-mobile-web-app-title" content="ProRemont">
    <meta name="application-name" content="ProRemont">
    <meta name="theme-color" content="#ffffff">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action('pror_body_before'); ?>

<?php module_template('theme/header'); ?>
