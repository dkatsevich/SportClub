<?php

class Sc_Widget_Phone extends WP_Widget {
	public function __construct() {
		parent:: __construct(
			'sc_widget_phone',
			'SportClub - Виджет мобильного',
			[
				'name' => 'SportClub - Виджет мобильного',
				'description' => 'SportClub - Виджет телефона и адреса',
			]
		);
	}

	public function form( $instance ) {
		?>

		<p>
            <label for="<?= $this->get_field_id('id-phone') ?>">Введите телефон:</label>
            <input
                    class="widefat"
                    type="text"
                    value="<?= $instance['phone']?>"
                    name="<?= $this->get_field_name('phone')?>"
                    id="<?= $this->get_field_id('id-phone') ?>">
        </p>
		<p>
            <label for="<?= $this->get_field_id('id-address') ?>">Введите адресс:</label>
            <input
                    class="widefat"
                    type="text"
                    value="<?= $instance['address']?>"
                    name="<?= $this->get_field_name('address')?>"
                    id="<?= $this->get_field_id('id-address') ?>">
        </p>

		<?php
	}

	public function widget( $args, $instance ) {
        $tel_text = $instance['phone'];
        $pattern = '/[^+0-9]/';
        $trimmed_tel = preg_replace($pattern, '', $tel_text);
		?>
        <address class="main-header__widget widget-contacts">
            <a href="tel:<?=$trimmed_tel?>" class="widget-contacts__phone"><?= $instance['phone']?></a>
            <p class="widget-contacts__address"><?= $instance['address']?></p>
        </address>
        <?php
	}

    public function update( $new_instance, $old_instance ) {
	    return $new_instance;
    }
}