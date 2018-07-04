<form id="master_search_form" class="mb-4 p-3 bg-light border border-secondary">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label"><?php _e('Каталог', 'common'); ?></label>
        <div class="col-sm-10">

            <?php
//                wp_dropdown_categories(array(
//                    'hide_empty' => 0,
//                    'taxonomy' => 'catalog_master',
//                    'selected' => get_queried_object_id(),
//                    'hierarchical' => 1,
//                    'name' => 'f_switch_catalog',
//                    'id' => 'master_search_catalog',
//                    'class' => 'form-control',
//                ));
            ?>

        </div>
    </div>

   <div class="form-group mb-0">
        <div class="text-right">
            <button type="submit" class="btn btn-primary"><?php _e('Поиск', 'common'); ?></button>
        </div>
    </div>
</form>
