<table class="form-table profile-info">
    <tbody>
        <tr>
            <th>
                <label for="pror-profile-ispro">PRO-аккаунт</label>
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
                <label for="pror-profile-ispro">Аккаунт проверен</label>
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
                <label for="pror-profile-ispro">Рейтинг</label>
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
    </tbody>
</table>
