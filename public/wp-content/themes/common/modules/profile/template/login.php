<?php if (have_posts()): the_post(); ?>
    <div class="colored-box p-3">
        <h1 class="page-title header-underlined"><?php the_title(); ?></h1>

        <div class="content mt-3">
            <form name="loginform" id="loginform" action="/wp/wp-login.php" method="post">
                <input type="text" name="log" id="user_login" />
                <input type="password" name="pwd" id="user_pass" />

                <input type="submit" value="Ввійти" />
            </form>
        </div>
    </div>
<?php endif; ?>
