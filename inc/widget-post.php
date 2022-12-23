<?php

class Sc_Widget_Post extends WP_Widget {
	public function __construct() {
		parent:: __construct(
			'sc_widget_post',
			'SportClub - Виджет для поста',
			[
				'name' => 'SportClub - Виджет для поста',
				'description' => 'SportClub - Виджет для поста на главной',
			]
		);
	}

	public function form( $instance ) {
		    $posts = get_posts([
                'numberposts' => -1,
                'post_type'   => 'post',
            ] );

		?>

        <p>
            <label for="<?= $this->get_field_id('id-sc-post') ?>">Выберете пост для отображения:</label>
            <select
                    class="widefat"
                    name="<?= $this->get_field_name('sc-post')?>"
                    id="<?= $this->get_field_id('id-sc-post') ?>">
				<?php foreach ($posts as $post):?>

                    <option
                            value="<?= $post->ID?>"
						<?php selected($instance['sc-post'], $post->ID) ?>
                    >
	                    <?= $post->post_title?>
                    </option>
				<?php endforeach;?>
            </select>
        </p>
		<?php
	}

	public function widget( $args, $instance ) {
        $id = $instance['sc-post'];
        global $post;
		$post = get_post($id);
        setup_postdata($post)
        ?>

            <article class="about">
                <div class="wrapper about__flex">
                    <div class="about__wrap">
                        <h2 class="main-heading about__h"><?php the_title() ?></h2>
                        <p class="about__text"><?php echo get_the_excerpt() ?></p>
                        <a href="<?php the_permalink(); ?>" class="about__link btn">подробнее</a>
                    </div>
                    <figure class="about__thumb">
                        <?php the_post_thumbnail('full') ?>
                    </figure>
                </div>
            </article>

        <?php
        wp_reset_postdata();
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}