<div class="modal">
    <div class="wrapper">
        <section class="modal-content modal-form" id="modal-form">
            <button class="modal__closer">
                <span class="sr-only">Закрыть</span>
            </button>
            <form
                method="post"
                action="<?php echo esc_url(admin_url('admin-post.php'))?>"
                class="modal-form__form"
            >
                <h2 class="modal-content__h"> Отправить заявку </h2>
                <p> Оставьте свои контакты и менеджер с Вами свяжется </p>
                <p>
                    <label>
                        <span class="sr-only">Имя: </span>
                        <input type="text" name="si-user-name" placeholder="Имя">
                    </label>
                </p>
                <p>
                    <label>
                        <span class="sr-only">Телефон:</span>
                        <input type="text" name="si-user-phone" placeholder="Телефон" pattern="^\+{0,1}[0-9]{4,}$"
                               required>
                    </label>
                </p>
                <button class="btn" type="submit">Отправить</button>
                <input type="hidden" name="action" value="sc-modal-form">
            </form>
        </section>
    </div>
</div>
<div class="footer">
    <header class="main-header">
        <div class="wrapper main-header__wrap">
            <p class="main-header__logolink">
				<?php the_custom_logo(); ?>
                <a href="<?= get_home_url() ?>" class="slogan">
                    <?php echo get_option('sc_settings_slogan_field') ?>
                </a>
            </p>
			<?php
			$locations  = get_nav_menu_locations();
			$menu_id    = $locations['footer-menu'];
			$menu_items = wp_get_nav_menu_items( $menu_id );
			?>
            <nav class="main-navigation">
                <ul class="main-navigation__list">
					<?php
					$http_s = 'http' . ( ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) ? 's' : '' );
					$url    = $http_s . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
					foreach ( $menu_items as $item ):
						$class_text = '';
						if ( $item->url === $url ) {
							$class_text = 'class="active" ';
						}
						?>
                        <li <?= $class_text; ?>>
                            <a href=<?= $item->url ?>><?= $item->title ?></a>
                        </li>
					<?php endforeach; ?>
                </ul>
            </nav>
			<?php
			if ( is_active_sidebar( 'sc-footer' ) ) {
				dynamic_sidebar( 'sc-footer' );
			}
			?>
        </div>
    </header>
    <footer class="main-footer wrapper">
        <div class="row main-footer__row">
            <div class="main-footer__widget main-footer__widget_copyright">
                <span class="widget-text">
                    <?php
                    if ( is_active_sidebar( 'sc-footer-col-1' ) ) {
	                    dynamic_sidebar( 'sc-footer-col-1' );
                    }
                    ?>
                </span>
            </div>

            <div class="main-footer__widget">
                <p class="widget-contact-mail">
					<?php
                        if ( is_active_sidebar( 'sc-footer-col-2' ) ) {
                            dynamic_sidebar( 'sc-footer-col-2' );
                        }
					?>
                </p>
            </div>
            <div class="main-footer__widget main-footer__widget_social">
	            <?php
                    if ( is_active_sidebar( 'sc-footer-col-3' ) ) {
                        dynamic_sidebar( 'sc-footer-col-3' );
                    }
	            ?>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
