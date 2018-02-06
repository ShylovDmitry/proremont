<div class="modal fade" id="modalCatalogLimitreached" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Достигнут лимит по категориям</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Вы достигли лимита по категориям для бесплатного аккаунта.</p>
                <p>Если Вам необходимо больше категорий, заказывайте <a href="https://proremont.co/pro-akkaunt-dlya-masterov/?utm_source=adminpanel&utm_medium=popup&utm_campaign=link" target="_blank">PRO-аккаунт</a> без ограничения по категориям. А так же много другого. Узнайте все преймущества PRO-аккаунта.</p>
            </div>

            <div class="modal-footer">
                <a class="btn btn-primary" href="https://proremont.co/pro-akkaunt-dlya-masterov/?utm_source=adminpanel&utm_medium=popup&utm_campaign=button" target="_blank">Узнать больше</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmAccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Как подтвердить свой аккаунт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php
                    $master_phones = pror_get_master_phones(get_current_user_id());
                    $master_phones_count = count($master_phones)-1;
                ?>
                <p>Для того, что бы подтвердить свой аккаунт, получить бейдж "Проверено" - <span class="oi oi-circle-check is-confirmed" data-toggle="tooltip" data-placement="top" title="Проверено"></span> и повысить доверие посетителей к своему профилю, Вам необходимо выполнить следующие действия:</p>
                <p>Позвонить нашему менеджеру с Вашего телефона (
                        <?php foreach ($master_phones as $pos => $phone): ?>
                            <a href="tel:<?php echo $phone['tel']; ?>"><?php echo $phone['text']; ?></a><?php if ($pos != $master_phones_count): ?>, <?php endif; ?>
                        <?php endforeach; ?>
                    ) и подтвердить свои данные в телефонном режиме <i>(займет не более 1 минуты)</i>.</p>
                <p><strong>Ваш персональный менеджер</strong> — Алёна (тел.: <a href="tel:+380935519695">093 551 96 95</a>).</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAboutReviews" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Как отображаться в ТОПе</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Наш сайт использует сложный алгоритм сортировки исполнителей и учитывает много переменных, в том числе и заполненость Вашего профиля.</p>
                <p>Самый <strong>простой способ</strong> - это <a href="https://proremont.co/pro-akkaunt-dlya-masterov/?utm_source=adminpanel&utm_medium=popup&utm_campaign=empty_review" target="_blank">преобрести PRO-аккаунт</a>.</p>
                <p><strong>Другой способ</strong> - попросить Ваших клиентов оставить отзывы на <a href="#">Вашей страничке</a>. Чем больше отзывов и чем лучше оценка, тем выше будет отображаться Ваша страничка.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
