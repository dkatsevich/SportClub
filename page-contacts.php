<?php /* Template Name: Шаблон для страницы контактов*/ ?>


<?php
get_header();
?>

    <main class="main-content">
        <div class="wrapper">
			<?php get_template_part( 'template-parts/breadcrumbs' ) ?>
        </div>
        <section class="contacts">
			<?php
            if (have_posts() ):
                while ( have_posts() ):
                    the_post();
            ?>
                <div class="wrapper">
                    <h1 class="contacts__h main-heading"><?php the_title(); ?></h1>
                    <div class="map">
                        <a href="#" class="map__fallback">
                            <img src="<?= _sc_getFileUri( '/img/map.jpg' ) ?>" alt="Карта клуба SportIsland">
                            <span class="sr-only"> Карта </span>
                        </a>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d20309.075323923767!2d30.4721233!3d50.4851493!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sua!4v1578565396276!5m2!1sru!2sua"
                                width="800" height="600" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                    <p class="contacts__info">
						<?php
						if ( is_active_sidebar( 'sc-after-map' ) ) {
							dynamic_sidebar( 'sc-after-map' );
						}
						?>
                    </p>
                    <?php the_content()?>

                </div>
			<?php
			    endwhile;
                endif;
			?>
        </section>
    </main>


<?php
get_footer();
?>