<?php

class Sc_Widget_Text extends WP_Widget {
	public function __construct() {
		parent:: __construct(
			'sc_widget_text',
			'SportClub - Текстовый виджет',
			[
				'name' => 'SportClub - Текстовый виджет',
				'description' => 'SportClub - Виджет текста без верстки',
			]
		);
	}

	public function form( $instance ) {
		?>

		<label for="<?= $this->get_field_id('id-text') ?>">Введите текст:</label>
		<textarea
			class="widefat"
			type="text"
            value="<?= $instance['text']?>"
			name="<?= $this->get_field_name('text')?>"
			id="<?= $this->get_field_id('id-text') ?>"><?= $instance['text']?></textarea>

		<?php
	}

	public function widget( $args, $instance ) {
		echo apply_filters('sc_widget_text', $instance['text']);
	}

    public function update( $new_instance, $old_instance ) {
	    return $new_instance;
    }
}