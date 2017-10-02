<form id="master_search_form" class="mb-4 p-3 bg-light border border-secondary">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Каталог</label>
        <div class="col-sm-10">

            <?php
                wp_dropdown_categories(array(
                    'hide_empty' => 0,
                    'taxonomy' => 'catalog_master',
                    'selected' => get_queried_object_id(),
                    'hierarchical' => 1,
                    'name' => 'f_switch_catalog',
                    'id' => 'master_search_catalog',
                    'class' => 'form-control',
                ));
            ?>

        </div>
    </div>

<!--    <div class="form-group row">-->
<!--        <label class="col-sm-2 col-form-label">Локация</label>-->
<!--        <div class="col-sm-10">-->
<!---->
<!--            --><?php
//                wp_dropdown_categories(array(
//                    'hide_empty' => 0,
//                    'taxonomy' => 'section',
////                    'orderby' => 'order',
//                    'selected' => pror_get_section()->term_id,
//                    'hierarchical' => 0,
//                    'name' => 'f_switch_section',
//                    'id' => 'master_search_section',
//                    'class' => 'form-control',
//                ));
//            ?>
<!---->
<!--        </div>-->
<!--    </div>-->
<!--
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Тип</label>
        <div class="col-sm-10">
            <?php
/*                $master_types = array(
                        '' => 'Все',
                        'master' => 'Мастер',
                        'brіgada' => 'Бригада',
                        'kompania' => 'Компания',
                );
                $selected_type = isset($_GET['f_master_type']) ? $_GET['f_master_type'] : key($master_types);
            */?>
            <?php /*foreach ($master_types as $type_key => $type_value): */?>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="f_master_type" value="<?php /*echo $type_key; */?>"<?php /*if ($selected_type == $type_key): */?> checked<?php /*endif; */?>>
                        <?php /*echo $type_value; */?>
                    </label>
                </div>
            <?php /*endforeach; */?>
        </div>
    </div>
-->    <div class="form-group mb-0">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Поиск</button>
        </div>
    </div>
</form>
