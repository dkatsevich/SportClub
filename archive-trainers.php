<?php
get_header();
?>

	<main class="main-content">
		<div class="wrapper">
            <?php get_template_part('template-parts/breadcrumbs') ?>
		</div>
        <?php
            if (have_posts()):
        ?>
		<section class="trainers">
			<div class="wrapper">
				<h1 class="main-heading trainers__h">Тренеры</h1>
				<ul class="trainers-list">
                    <?php while (have_posts()):
                        the_post();
                    ?>
					<li class="trainers-list__item">
						<article class="trainer">
							<?php
                                $image = get_field('trainer_img');
                                $img_url = $image['url'];
                                $img_alt = $image['alt'];
							?>
                            <img src="<?php echo $img_url ?>" alt="<?php echo $img_alt?>" class="trainer__thumb">
							<div class="trainer__wrap">
								<h2 class="trainer__name"><?php the_title(); ?></h2>
								<p class="trainer__text"><?php the_field('trainer_description'); ?></p>
							</div>
                            <a data-post-id="<?php echo $id?>" href="#modal-form" class="trainer__subscribe btn btn_modal">записаться</a>
						</article>
					</li>
                    <?php
                        endwhile;
                    ?>
				</ul>
			</div>
		</section>
        <?php
            else:
	            get_template_part('template-parts/no-posts');
            endif;
        ?>
	</main>

<?php
get_footer();
?>