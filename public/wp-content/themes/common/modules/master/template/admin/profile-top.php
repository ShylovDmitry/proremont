<?php
$profileuser = isset($__data['profileuser']) ? $__data['profileuser'] : new stdClass();
?>
<?php if (pror_user_has_role('administrator')): ?>
<table class="form-table profile-info">
    <tbody>
        <tr>
            <th>
                <label>&nbsp;</label>
            </th>
            <td>
                <?php
                    $posts = get_posts(array(
                        'author' => $profileuser->ID,
                        'posts_per_page' => 1,
                        'post_type' => 'master',
                        'post_status' => 'any',
                    ));
                    $post_id = isset($posts, $posts[0], $posts[0]->ID) ? $posts[0]->ID : false;
                ?>
                <?php if ($post_id): ?>
                    <a href="<?php echo get_edit_post_link($post_id); ?>">Редактировать страницу (ID <?php echo $post_id; ?>)</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?php echo get_the_permalink($post_id); ?>" target="_blank">Перейти на сайт</a>
                    <br />
                    <br />
                    За последнии 30 дней:
                        <b><?php echo pror_stats_get_period('master_page_view', $post_id, 30); ?></b> просмотров,
                        <b><?php echo pror_stats_get_period('master_show_phone', $post_id, 30); ?></b> звонков
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
<?php endif; ?>
