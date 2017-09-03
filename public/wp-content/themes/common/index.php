<?php get_header(); ?>

<h1 class="text-center">Зробити файний ремонт</h1>


<?php $tops = get_field( 'frontpage_tops', 'option' ); ?>
<div class="container colored-box py-3">
    <div class="row">
        <div class="col-12 mx-auto mt-3">
            <ul class="list-inline list-unstyled text-center mb-0">
                <li class="list-inline-item">Вибери своє місто:</li>
                <li class="list-inline-item"><a href="#">Київ</a></li>
                <li class="list-inline-item"><a href="#">Львів</a></li>
                <li class="list-inline-item"><a href="#">Одеса</a></li>
            </ul>
        </div>
        <div class="col-2 mx-auto mb-3">
            <hr />
        </div>
    </div>

    <div class="row">

    <?php foreach ($tops as $pos => $top) : ?>
        <div class="col-6">
            <h4 class="text-center"><?php echo $top['frontpage_top_title']; ?></h4>

            <ul class="list-unstyled mb-0">
            <?php foreach ($top['frontpage_top_items'] as $top_item) : ?>
                <?php $item = get_post($top_item['frontpage_top_item_id']); ?>

                <li class="media mt-4">
                    <a href="<?php echo esc_url( get_permalink($item) ); ?>">
                        <img class="d-flex mr-3" src="http://via.placeholder.com/64" alt="" width="64" />
                    </a>
                    <div class="media-body">
                        <h5 class="mt-0 mb-1"><a href="<?php echo esc_url( get_permalink($item) ); ?>"><?php echo $item->post_title; ?></a></h5>
                        <?php echo $top_item['frontpage_top_item_text']; ?>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

        <?php if (($pos+1) % 2 == 0): ?><div class="w-100 my-3"></div><?php endif; ?>
    <?php endforeach; ?>

    </div>

    <hr class="my-5"/>
<?php
$main_katalogs = get_terms(array(
    'parent' => 0,
    'hierarchical' => false,
    'taxonomy' => 'katalog',
    'hide_empty' => false,
));
?>
    <div class="row">
    <?php foreach ($main_katalogs as $pos => $main_katalog): ?>
        <div class="col-4">
            <h6><a href="<?php echo esc_url( get_term_link($main_katalog) ); ?>"><?php echo $main_katalog->name; ?></a> (<?php echo $main_katalog->count; ?>)</h6>

            <?php
            $sub_katalogs = get_terms(array(
                'parent' => $main_katalog->term_id,
                'hierarchical' => false,
                'taxonomy' => 'katalog',
                'hide_empty' => false,
            ));
            ?>
            <ul class="list-unstyled">
            <?php foreach ($sub_katalogs as $sub_katalog): ?>
                <li><a href="<?php echo esc_url( get_term_link($sub_katalog) ); ?>"><?php echo $sub_katalog->name; ?></a></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php if (($pos+1) % 3 == 0): ?><div class="w-100"></div><?php endif; ?>
    <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>
