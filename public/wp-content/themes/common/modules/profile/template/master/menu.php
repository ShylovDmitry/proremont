<?php
$menu = [
    [
        'slug' => 'settings',
        'name' => __('Настройки', 'common'),
    ],
];
?>
<ul>
    <?php foreach ($menu as $item): ?>
        <?php
            $class = (empty($_GET['section']) || $_GET['section'] == $item['slug']) ? 'active' : '';
        ?>
        <li>
            <a href="<?php echo home_url('profile/?section=' . $item['slug']); ?>" class="<?php echo $class; ?>"><?php echo $item['name']; ?></a>
        </li>
    <?php endforeach; ?>
</ul>
