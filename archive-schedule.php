<?php
get_header();
?>

	<main class="main-content">
		<div class="wrapper">
			<?php get_template_part( 'template-parts/breadcrumbs' ) ?>
            <h1 class="main-heading schedule-page__h">расписание</h1>
			<div class="tabs">
				<ul class="tabs-btns">
                    <?php
                        $days = get_terms([
                            'taxonomy' => 'schedule_days',
                            'orderby' => 'slug',
                            'order' => 'ASC'
                        ]);
                        $index = 0;
                        foreach ($days as $day):
                            $index === 0 ? $active_class = 'active-tab' : $active_class = '';
                    ?>
					<li class="tabs-btns__item <?php echo $active_class?>">
						<a
                            aria-label="<?php echo $day->description?>"
                            href="#<?php echo $day->slug?>"
                            class="tabs-btns__btn"
                        >
                            <?php echo $day->name?>
                        </a>
					</li>
					<?php
                        $index++;
                        endforeach;
                    ?>
				</ul>
				<ul class="tabs-content">
                    <?php
                        $index = 0;
                        foreach ($days as $day):
	                        $index === 0 ? $active_class = 'active-tab' : $active_class = '';

                    ?>
					<li class="tabs-content__item <?php echo $active_class?>" id="<?php echo $day->slug?>">
						<h2 class="sr-only"> <?php echo $day->description?> </h2>
						<ul class="schedule tabs-content__list">
                            <?php
                                $query = new WP_Query([
                                    'posts_per_page' => -1,
                                    'post_type' => 'schedule',
                                    'tax_query' => [
	                                   [
		                                   'taxonomy' => 'schedule_days',
		                                   'field'    => 'slug',
		                                   'terms'    => $day->slug
                                       ]
                                    ],
                                    'meta_key' => 'exercise_time_start',
                                    'order' => 'ASC',
                                    'orderby' => 'meta_value_num'

                                ]);
                                if ($query->have_posts()):
                                while ($query->have_posts()):
                                    $query->the_post();
                                    $place = get_the_terms($id, 'schedule_places')[0];
                                    $trainer = esc_html(get_post(get_field('exercise_trainer'))->post_title);
//                                    $color = get_field('exercise_color', 'schedule_places_' . $place->term_id);
                                    $color = get_field('exercise_color', $place);
                            ?>
							<li class="schedule__item">
								<p class="schedule__time">
                                    <?php the_field('exercise_time_start'); ?>
                                    -
                                    <?php the_field('exercise_time_end'); ?>
                                </p>
								<h2 class="schedule__h"> <?php  the_field('exercise_name');?> </h2>
								<p class="schedule__trainer"> <?php echo $trainer?> </p>
								<p
                                    style="color: <?php echo $color ?>"
                                    class="schedule__place"
                                >
                                    <?php
                                        if ($place->name) {
	                                        echo $place->name;
                                        }
                                    ?>
                                </p>
							</li>
                            <?php
                                wp_reset_postdata();
                                endwhile;
                                endif;
                            ?>
						</ul>
					</li>
                    <?php
                        $index++;
                        endforeach;
                    ?>
				</ul>
			</div>
		</div>
	</main>


<?php
get_footer();
?>