<?php
$profileuser = isset($__data['profileuser']) ? $__data['profileuser'] : new stdClass();
?>
<div class="modal fade" id="modalCatalogLimitreached" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Лимит на категории</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Тебе доступно только <u>5 категорий</u>.</p>
                <p><strong>Необходимо больше?</strong><br />
                    Что бы снять ограничения приобретай <a href="https://proremont.co/pro-akkaunt-dlya-masterov/?utm_source=adminpanel&utm_medium=popup&utm_campaign=link" target="_blank">PRO-аккаунта</a>.</p>
            </div>

            <div class="modal-footer">
                <a class="btn btn-pror-primary" href="https://proremont.co/pro-akkaunt-dlya-masterov/?utm_source=adminpanel&utm_medium=popup&utm_campaign=button" target="_blank">Узнать цену &raquo;</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmAccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Как подтвердить аккаунт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php
                    $master_phones = pror_get_master_phones(get_current_user_id());
                    $master_phones_count = count($master_phones)-1;
                ?>
                <p>Позвони персональному менеджеру с своего телефона
                        <?php foreach ($master_phones as $pos => $phone): ?>
                            <a href="tel:<?php echo $phone['tel']; ?>"><?php echo $phone['text']; ?></a><?php if ($pos != $master_phones_count): ?>, <?php endif; ?>
                        <?php endforeach; ?>
                    и подтверди свои данные в телефонном режиме <i>(займет менее 1 минуты)</i>.</p>
                <p><strong>Персональный менеджер</strong> — Александр, тел.: <a href="tel:+380631996304">063 199 63 04</a>.</p>
                <p>После подтверждения ты получить бейдж "Проверено" <span class="oi oi-circle-check is-confirmed" data-toggle="tooltip" data-placement="top" title="Проверено"></span>.<br />
                    Посетители доверяют таким профилям больше.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-pror-primary" data-dismiss="modal">Уже подтвердил</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAboutReviews" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Как повысить доверие</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php
                    $posts = get_posts(array(
                        'author' => $profileuser->ID,
                        'posts_per_page' => 1,
                        'post_type' => 'master',
                        'post_status' => 'any',
                    ));
                    $post_id = isset($posts, $posts[0], $posts[0]->ID) ? $posts[0]->ID : false;
                ?>
                <p>Предложи своим клиентам оставить отзыв на <a href="<?php echo get_permalink($post_id); ?>" target="_blank">твоей страничке</a>.</p>
                <p>Выше оценка - больше новых клиентов.</p>
                <p>ProRemont использует <u>сложный алгоритм сортировки</u> исполнителей который учитывает кол-во отзывов, их оценки и заполненость самого профиля.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
