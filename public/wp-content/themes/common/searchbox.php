<form class="mb-4">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Локация</label>
        <div class="col-sm-10">
            <?php
                $city_term = pror_get_city_object();
                $selected_location = $city_term ? $city_term->term_id : 0;

                wp_dropdown_categories(array(
                    'taxonomy' => 'location',
                    'orderby' => 'name',
                    'selected' => $selected_location,
                    'hierarchical'       => 1,
                    'name'               => 'change_city',
                    'class'              => 'form-control',
                    'value_field'	     => 'term_id',
                ));
            ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Тип</label>
        <div class="col-sm-10">
            <?php
                $master_types = array(
                        '' => 'Все',
                        'master' => 'Мастер',
                        'brіgada' => 'Бригада',
                        'kompania' => 'Компания',
                );
                $selected_type = isset($_GET['filter'], $_GET['filter']['master_type']) ? $_GET['filter']['master_type'] : key($master_types);
            ?>
            <?php foreach ($master_types as $type_key => $type_value): ?>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="filter[master_type]" value="<?php echo $type_key; ?>"<?php if ($selected_type == $type_key): ?> checked<?php endif; ?>>
                        <?php echo $type_value; ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-8 text-right">
            <button type="submit" class="btn btn-primary">Поиск</button>
        </div>
    </div>
</form>
