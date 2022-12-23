<?php
get_header();
?>

    <main class="main-content">
        <h1 class="sr-only">Цены на наши услуги и клубные карты</h1>
        <div class="wrapper">
	        <?php get_template_part( 'template-parts/breadcrumbs' ) ?>
            <section class="prices">
                <h2 class="main-heading prices__h">Цены</h2>
                <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            if (!get_field('prices_show')) {
                               continue;
                            }
	                        the_content();

                        endwhile;
                    else:
	                    get_template_part( 'template-parts/no-posts');
                    endif;
                ?>
                <style>
                    .prices tr:first-child {
                        border-bottom: 1px solid #555;
                    }
                </style>
            </section>
        <?php
            $query = new WP_Query([
                'numberposts' => -1,
                'post_type' => 'cards',
                'meta_key' => 'card_order',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            ]);

            if ($query->have_posts()):
        ?>
            <section class="cards">
                <h2 class="main-heading cards__h"> клубные карты </h2>
                <ul class="cards__list row">
                    <?php
                    while ($query->have_posts()):
                        $query->the_post();

                        $class = '';
                        if ( get_field('card_profit') ) {
                            $class = 'card_profitable';
                        }
                        $bg = get_field('card_img');
                        $default_bg = _sc_getFileUri('img/index__cards_card3.jpg');
                        $bg = $bg ? "style=\"background-image: url(${bg})\""
                            : "style=\"background-image: url(${default_bg})\"";

                        $list = explode("\n", get_field('card_list'));
                        ?>
                        <li class="card <?php echo $class?>" <?php echo $bg?>>
                            <h3 class="card__name"><?php the_title() ?></h3>
                            <p class="card__time">
                                <?php the_field('card_time_start'); ?>
                                &ndash;
                                <?php the_field('card_time_end'); ?>
                            </p>
                            <p class="card__price price"> <?php the_field('card_price'); ?> <span class="price__unit" aria-label="рублей в месяц">р.-/мес.</span>
                            </p>
                            <ul class="card__features">
                                <?php foreach ($list as $li): ?>
                                    <li class="card__feature"><?php echo $li?></li>
                                <?php endforeach ?>
                            </ul>
                            <a data-post-id="<?php echo $id?>" href="#modal-form" class="card__buy btn btn_modal">купить</a>
                        </li>

                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </ul>
            </section>
	        <?php
	        endif;
	        ?>
        </div>
    </main>

<?php
get_footer();
?>