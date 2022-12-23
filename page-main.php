<?php /* Template Name: Шаблон для главной страницы */ ?>


<?php
	get_header();
?>

<main class="main-content">
	<h1 class="sr-only"> Домашняя страница спортклуба SportIsland. </h1>
	<div class="banner">
		<span class="sr-only">Будь в форме!</span>
		<a href="<?php echo get_post_type_archive_link('services')?>" class="banner__link btn">записаться</a>
	</div>
    <?php
        if (is_active_sidebar('sc-post-in-main')) {
            dynamic_sidebar('sc-post-in-main');
        }
        $sales = get_posts([
            'numberposts' => -1,
            'category_name' => 'sales',
            'meta_key' => 'sales_actual',
            'meta_value' => '1'
        ]);
        if ($sales):
    ?>
	<section class="sales">
		<div class="wrapper">
			<header class="sales__header">
				<h2 class="main-heading sales__h"> акции и скидки </h2>
				<p class="sales__btns">
					<button class="sales__btn sales__btn_prev">
						<span class="sr-only"> Предыдущие акции </span>
					</button>
					<button class="sales__btn sales__btn_next">
						<span class="sr-only"> Следующие акции </span>
					</button>
				</p>
			</header>
			<div class="sales__slider slider">
				<?php
                    global $post;
                    foreach ($sales as $post):
                        setup_postdata($post)
                ?>

                        <section class="slider__slide stock">
                            <a href="<?php the_permalink(); ?>" class="stock__link" aria-label="Подробнее об акции скидка 20% на групповые занятия">
	                            <?php  the_post_thumbnail('full', ['class' => 'stock__thumb', 'height' => '207']);?>
                                <h3 class="stock__h"><?php the_title() ?></h3>
                                <p class="stock__text"><?php echo get_the_excerpt() ?></p>
                                <span class="stock__more link-more_inverse link-more">Подробнее</span>
                            </a>
                        </section>

                <?php
                    endforeach;
                    wp_reset_postdata();
                ?>
			</div>
		</div>
	</section>
	<?php
        endif;
        $query = new WP_Query([
            'numberposts' => -1,
            'post_type' => 'cards',
            'meta_key' => 'card_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        ]);

        if ($query->have_posts()):
    ?>
        <section class="cards cards_index">
            <div class="wrapper">
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
            </div>
        </section>
    <?php
        endif;
    ?>
</main>


<?php
get_footer();
?>