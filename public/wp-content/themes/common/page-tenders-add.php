<?php get_header(); ?>

<?php module_template('breadcrumbs/breadcrumbs'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <div class="colored-box p-3">
                <h1 class="page-title header-underlined"><?php the_title(); ?></h1>

                <form action="" method="post" class="form-container from-validation-simple">

                    <div class="form-group">
                        <label for="title" class="form-label"><?php _e( 'Название', 'common' ); ?> <span class="required">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" required="required" />
                    </div>

                    <div class="form-group">
                        <label for="section" class="form-label"><?php _e( 'Город', 'common' ); ?> <span class="required">*</span></label>
                        <input type="text" name="section" class="section-search-input form-control" value="<?php echo pror_get_section_localized_name(pror_detect_section()); ?>" required="required" />
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?php _e( 'Бюджет', 'common' ); ?> <span class="required">*</span></label>

                        <div class="form-group">
                            <?php foreach (pror_tender_get_budgets() as $value => $text): ?>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="budget" value="<?php echo $value; ?>" />
                                        <?php echo $text; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?php _e( 'Актуальность', 'common' ); ?> <span class="required">*</span></label>

                        <div class="form-group">
                            <?php foreach (pror_tender_get_expires() as $value => $text): ?>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="expires" value="<?php echo $value; ?>" />
                                        <?php echo $text; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="description" class="form-label"><?php _e( 'Описание работ', 'common' ); ?> <span class="required">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="5" required="required"></textarea>
                    </div>

                    <button type="submit" class="btn btn-pror-primary"><?php _e( 'Создать заявку', 'common' ); ?></button>
                </form>
            </div>

            <?php if (get_the_content() && get_query_var('paged') <= 1): ?>
                <div class="colored-box mt-3 p-3">
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <?php module_template('prom/sidebar-col'); ?>
    </div>
</div>

<?php get_footer(); ?>
