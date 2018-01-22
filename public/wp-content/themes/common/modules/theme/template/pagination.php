<?php
$container_class = isset($__data['container_class']) ? $__data['container_class'] : '';

$links = paginate_links(array(
    'type' => 'array',
    'prev_text' => '&laquo;',
    'next_text' => '&raquo;',
));
?>
<?php if (is_array($links)): ?>
    <div class="<?php echo $container_class; ?>">
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php foreach ($links as $link): ?>
                    <?php $link = str_replace('page-numbers', 'page-numbers page-link', $link); ?>
                    <?php $active_class = strpos($link, ' current') !== false ? ' active' : ''; ?>

                    <li class="page-item<?php echo $active_class; ?>"><?php echo $link; ?></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>
