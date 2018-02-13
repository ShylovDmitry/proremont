<?php
$profileuser = isset($__data['profileuser']) ? $__data['profileuser'] : new stdClass();
?>
<table class="form-table profile-info">
    <tbody>
    <?php if (pror_current_user_has_role('master')): ?>
        <tr>
            <th>
                <label>PRO-аккаунт</label>
            </th>
            <td>
                <?php if (get_field('master_is_pro', "user_" . get_current_user_id())): ?>
                    <span class="oi oi-circle-check text-success"></span> Поздравлям! Вам открыты все функции сайта.
                <?php else: ?>
                    <span class="oi oi-circle-x text-danger"></span> Вы <strong>НЕ используете</strong> все возможности сайта. Узнайте <a href="https://proremont.co/pro-akkaunt-dlya-masterov/?utm_source=adminpanel&utm_medium=content&utm_campaign=status_link" target="_blank">как привлечь внимание посетителей</a>.
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>
                <label>Аккаунт проверен</label>
            </th>
            <td>
                <?php if (get_field('master_is_confirmed', "user_" . get_current_user_id())): ?>
                    <span class="oi oi-circle-check text-success"></span> Ваш аккаунт подтверждень. Тепер посетители Вам доверяют.
                <?php else: ?>
                    <span class="oi oi-circle-x text-danger"></span> Ваш аккаунт <strong>НЕ подтвержден</strong>. Доверие посетителей к Вам ниже. Узнайте <a href="#" data-toggle="modal" data-target="#modalConfirmAccount">как подтвердить аккаунт</a>.
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>
                <label>Рейтинг</label>
            </th>
            <td>
                <?php
                    $ratings = get_post_meta( $comment_id, 'crfp-totals', true );
                    $averageRating = get_post_meta( $comment_id, 'crfp-average-rating', true );
                ?>
                <?php if (is_array($ratings) && $averageRating > 4): ?>
                    <span class="oi oi-circle-check text-success"></span> У вас хороший рейтинг. Так держать!
                <?php elseif (is_array($ratings)): ?>
                    <span class="oi oi-circle-x text-danger"></span> Ваш рейтинг нуждается в улучшени. Попросите своих клиентов оставить хорошие оценки.
                <?php else: ?>
                    <span class="oi oi-circle-x text-danger"></span> У вас <strong>нет отзывов</strong>. Узнайте <a data-toggle="modal" data-target="#modalAboutReviews">как отображаться в ТОПе</a>.
                <?php endif; ?>
            </td>
        </tr>
    <?php elseif (pror_current_user_has_role('administrator')): ?>
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
    <?php endif; ?>
    </tbody>
</table>
