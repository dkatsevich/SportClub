<?php

class Sc_Widget_Info extends WP_Widget {
	public function __construct() {
		parent:: __construct(
			'sc_widget_info',
			'SportClub - Виджет для информации',
			[
				'name' => 'SportClub - Виджет для информации',
				'description' => 'SportClub - Виджет для информации, под картой',
			]
		);
	}

	public function form( $instance ) {
        $vars = [
            'address' => 'Адресс',
            'time' => 'Время',
            'phone' => 'Телефон',
            'mail' => 'Почта'
        ]
		?>

        <p>
            <label for="<?= $this->get_field_id('id-info') ?>">Введите информацию:</label>
            <input
                    class="widefat"
                    type="text"
                    value="<?= $instance['info']?>"
                    name="<?= $this->get_field_name('info')?>"
                    id="<?= $this->get_field_id('id-info') ?>">
        </p>
        <p>
            <label for="<?= $this->get_field_id('id-select') ?>">Выберете тип:</label>
            <select
                    class="widefat"
                    name="<?= $this->get_field_name('select')?>"
                    id="<?= $this->get_field_id('id-select') ?>">

				<?php foreach ($vars as $var => $value):?>
                    <option
                            value="<?= $var?>"
						<?php selected($instance['select'], $var, true) ?>
                    >
						<?= $value?>
                    </option>
				<?php endforeach;?>

            </select>
        </p>

		<?php
	}

	public function widget( $args, $instance ) {
        switch ($instance['select']) {
            case 'address':
                ?>
                <span class="widget-address"><?= $instance['info']?></span>

                <?php
                break;
            case 'time':
                ?>
                <span class="widget-working-time"><?= $instance['info']?></span>

                <?php
                break;
            case 'phone':
                $tel = preg_replace('/[^+0-9]/', '', $instance['info'])
                ?>
                <a href="tel:<?=$tel?>" class="widget-phone"><?= $instance['info']?></a>

                <?php
                break;
            case 'mail':
                ?>
                <a href="mailto:<?= $instance['info']?>" class="widget-email"><?= $instance['info']?></a>

                <?php
                break;
            default:
                echo '';
                break;
        }
	}
}