<?php
$tender_id = isset($__data['tender_id']) ? $__data['tender_id'] : 0;
?>

<div class="modal fade" id="createTenderResponseModal" tabindex="-1" role="dialog" aria-labelledby="createTenderResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTenderResponseModal"><?php _e('Ответить на тендер', 'common'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="create-tender-response">
                    <input type="hidden" name="tender_id" value="<?php echo $tender_id; ?>" />

                    <div class="form-group">
                        <label for="tenderResponseComment"><?php _e('Комментарий', 'common'); ?></label>
                        <textarea name="comment" class="form-control" id="tenderResponseComment" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comment_visibility" id="tenderResponseCommentVisibilityAll" value="all" checked>
                            <label class="form-check-label" for="tenderResponseCommentVisibilityAll">
	                            <?php _e('Все будут видеть ваш комментарий.', 'common'); ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comment_visibility" id="tenderResponseCommentVisibilityClientOnly" value="client_only">
                            <label class="form-check-label" for="tenderResponseCommentVisibilityClientOnly">
                                <?php _e('Только клиент будет видеть ваш комментарий.', 'common'); ?>
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-danger d-none" role="alert" id="tenderResponseError"></div>

                    <div class="text-right mt-2">
                        <button class="btn" data-dismiss="modal" aria-label="Закрыть"><?php _e('Закрыть', 'common'); ?></button>
                        <button class="btn btn-pror-primary"><?php _e('Ответить', 'common'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>