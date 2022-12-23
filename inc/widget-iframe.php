<?php

class Sc_Widget_Iframe extends WP_Widget {
	public function __construct() {
		parent:: __construct(
			'sc_widget_iframe',
			'SportClub - Виджет для Iframe',
			[
				'name' => 'SportClub - Виджет для Iframe',
				'description' => 'SportClub - Виджет для Iframe',
			]
		);
	}

	public function form( $instance ) {
		?>

		<label for="<?= $this->get_field_id('id-code') ?>">Вставьте iframe:</label>
		<textarea
			class="widefat"
			type="text"
            value="<?= esc_html($instance['code'])?>"
			name="<?= $this->get_field_name('code')?>"
			id="<?= $this->get_field_id('id-code') ?>"
        ><?= esc_html($instance['code'])?></textarea>

		<?php
	}

	public function widget( $args, $instance ) {
		echo $instance['code'];
	}

}