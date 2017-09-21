<form id="master_search_form" class="mb-4 p-3 bg-light border border-secondary">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Локация</label>
        <div class="col-sm-10">

            <select id="master_search_section" class="form-control" name="change_section">
                <?php
                    $selected_section_id = pror_get_section()->term_id;
                    $sections = get_terms(array(
                        'taxonomy' => 'section',
                        'hide_empty' => false,
                    ));
                ?>
                <?php foreach ($sections as $section) : ?>
                    <option value="<?php echo $section->slug; ?>"<?php if ($selected_section_id == $section->term_id): ?> selected="selected"<?php endif; ?>>
                        <?php echo $section->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>

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
    <div class="form-group mb-0">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Поиск</button>
        </div>
    </div>
</form>
