<ul class="list-unstyled profile-menu">
    <?php foreach ($__data['menu'] as $slug => $item): ?>
        <?php
            $class = (empty($_GET['section']) || $_GET['section'] == $slug) ? 'active' : '';
        ?>
        <li>
            <a href="<?php echo pror_get_permalink_by_slug('profile'); ?>?section=<?php echo $slug; ?>" class="<?php echo $class; ?>">
                <?php if ($item['name']): ?>
                    <span class="oi oi-<?php echo $item['icon']; ?>"></span>
                <?php endif; ?>
                <?php echo $item['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
