<?php if (have_posts()): the_post(); ?>
    <div class="colored-box p-3">
        <h1 class="page-title header-underlined"><?php the_title(); ?></h1>

        <div class="content mt-3">
            <form name="registerform" id="registerform" action="<?php home_url('/wp/wp-login.php?action=register'); ?>" method="post" novalidate="novalidate">
                <input type="text" name="user_first_name" id="user_first_name" />
                <input type="text" name="user_last_name" id="user_last_name" />
                <input type="email" name="user_email" id="user_email" />
                <input type="tel" name="user_tel" id="user_tel" />

                <input type="submit" value="Зареєструватись" />
            </form>
        </div>
    </div>
<?php endif; ?>
