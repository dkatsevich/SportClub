<?php

function _sc_getFileUri($path) {
	return get_template_directory_uri() . '/assets/' . $path;
}

$widgets = [
	'widget-text.php',
	'widget-phone.php',
	'widget-socials.php',
	'widget-iframe.php',
	'widget-info.php',
	'widget-post.php',
];

foreach ($widgets as $widget) {
	require_once(__DIR__ . '/inc/' . $widget);
}


add_action('after_setup_theme', 'sc_setup');
add_action('wp_enqueue_scripts', 'sc_scripts');
add_action( 'widgets_init', 'sc_sidebar' );
add_action('init', 'sc_custom_type');
add_action('add_meta_boxes', 'sc_meta_boxes');
//add_action('save_post', 'sc_save_meta_boxes');
add_action( 'admin_init', 'register_my_setting');
add_action( 'admin_post_nopriv_sc-modal-form', 'sc_modal_form_handler');
add_action( 'admin_post_sc-modal-form', 'sc_modal_form_handler');
add_action( 'wp_ajax_nopriv_post-likes', 'sc_post_likes');
add_action( 'wp_ajax_post-likes', 'sc_post_likes');
add_action( 'manage_posts_custom_column', 'sc_posts_column', 5,2);

add_shortcode('sc-paste-link', 'sc_paste_link');

add_filter('sc_widget_text', 'do_shortcode');
add_filter('manage_posts_columns', 'sc_posts_column_filter');


////////////////////////////////////////////////////////////////

function sc_setup() {
	register_nav_menu('header-menu', "Шапка");
	register_nav_menu('footer-menu', "Подвал");

	add_theme_support('custom-logo');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
}
function sc_scripts() {
	wp_enqueue_style(
		'css',
		get_template_directory_uri() . '/assets/css/style.css',
		[],
		'1.0'
	);

	wp_enqueue_script(
		'js',
		get_template_directory_uri() .'/assets/js/js.js',
		[],
		'1.0',
		true
	);

}

////////////////////////////////////////////////////////////////

function sc_sidebar() {
	register_sidebar( array(
		'name'          => "Контакты в шапке",
		'id'            => 'sc-header',
		'before_widget' => null,
		'after_widget'  => null,
	) );
	register_sidebar( array(
		'name'          => "Контакты в подвале",
		'id'            => 'sc-footer',
		'before_widget' => null,
		'after_widget'  => null,
	) );
	register_sidebar( array(
		'name'          => "Колонка в подвале 1",
		'id'            => 'sc-footer-col-1',
		'before_widget' => null,
		'after_widget'  => null,
	) );
	register_sidebar( array(
		'name'          => "Колонка в подвале 2",
		'id'            => 'sc-footer-col-2',
		'before_widget' => null,
		'after_widget'  => null,
	) );
	register_sidebar( array(
		'name'          => "Колонка в подвале 2",
		'id'            => 'sc-footer-col-2',
		'before_widget' => null,
		'after_widget'  => null,
	) );
	register_sidebar( array(
		'name'          => "Колонка в подвале 3",
		'id'            => 'sc-footer-col-3',
		'before_widget' => null,
		'after_widget'  => null,
	) );
	register_sidebar( array(
		'name'          => "Карта",
		'id'            => 'sc-map',
		'before_widget' => null,
		'after_widget'  => null,
	) );
	register_sidebar( array(
		'name'          => "Контакты под картой",
		'id'            => 'sc-after-map',
		'before_widget' => null,
		'after_widget'  => null,
	) );

	register_sidebar( array(
		'name'          => "Выбор поста для отображение на главной",
		'id'            => 'sc-post-in-main',
		'before_widget' => null,
		'after_widget'  => null,
	) );

	register_widget('sc_widget_text');
	register_widget('sc_widget_phone');
	register_widget('sc_widget_socials');
	register_widget('sc_widget_iframe');
	register_widget('sc_widget_info');
	register_widget('sc_widget_post');
}

////////////////////////////////////////////////////////////////

function sc_paste_link($attrs) {
	$params = shortcode_atts([
		'link' => '',
		'text' => '',
		'type' => 'link',
	], $attrs);
	$params['text'] = $params['text'] ? $params['text'] : $params['link'];
	if ($params['link']) {
		$protocol = '';
		switch ($params['type']) {
			case 'mail':
				$protocol = 'mailto:';
				break;
			case 'phone':
				$protocol = 'tel:';
				$params['link'] = preg_replace('/[^+0-9]/', '', $params['link']);
				break;
			default:
				echo '';
				break;
		}
		$text = $params['text'];
		$link = $protocol . $params['link'];
		return "<a href=\"$link\">$text</a>";
	} else {
		return '';
	}
}

////////////////////////////////////////////////////////////////


function sc_custom_type() {
	register_post_type( 'services', [
		'labels' => [
			'name'               => 'Услуги', // основное название для типа записи
			'singular_name'      => 'Услуга', // название для одной записи этого типа
			'add_new'            => 'Добавить новую услугу', // для добавления новой записи
			'add_new_item'       => 'Добавить новую услугу', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать услугу', // для редактирования типа записи
			'new_item'           => 'Новая услуга', // текст новой записи
			'view_item'          => 'Смотреть услуги', // для просмотра записи этого типа.
			'search_items'       => 'Искать услуги', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Услуги', // название меню
		],
		'public'              => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-smiley',
		'hierarchical'        => false,
		'supports'            => ['title'],
		'has_archive' => true
	]);
	register_post_type( 'trainers', [
		'labels' => [
			'name'               => 'Тренеры', // основное название для типа записи
			'singular_name'      => 'Тренер', // название для одной записи этого типа
			'add_new'            => 'Добавить нового тренера', // для добавления новой записи
			'add_new_item'       => 'Добавить нового тренера', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать тренера', // для редактирования типа записи
			'new_item'           => 'Новый тренер', // текст новой записи
			'view_item'          => 'Смотреть тренера', // для просмотра записи этого типа.
			'search_items'       => 'Искать тренера', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Тренеры', // название меню
		],
		'public'              => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-universal-access',
		'hierarchical'        => false,
		'supports'            => ['title'],
		'has_archive' => true
	]);
	register_post_type( 'schedule', [
		'labels' => [
			'name'               => 'Занятия', // основное название для типа записи
			'singular_name'      => 'Занятие', // название для одной записи этого типа
			'add_new'            => 'Добавить новое занятие', // для добавления новой записи
			'add_new_item'       => 'Добавить новое занятие', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать занятие', // для редактирования типа записи
			'new_item'           => 'Новое занятие', // текст новой записи
			'view_item'          => 'Смотреть занятия', // для просмотра записи этого типа.
			'search_items'       => 'Искать занятия', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Занятия', // название меню
		],
		'public'              => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-schedule',
		'hierarchical'        => false,
		'supports'            => ['title'],
		'has_archive' => true
	]);
	register_taxonomy('schedule_days', ['schedule'], [
		'labels'                => [
			'name'              => 'Дни недели',
			'singular_name'     => 'День',
			'search_items'      => 'Найти день недели',
			'all_items'         => 'Все дни недели',
			'view_item '        => 'Посмотреть дни недели',
			'edit_item'         => 'Редактировать дни недели',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить день недели',
			'new_item_name'     => 'Добавить день недели',
			'menu_name'         => 'Все дни недели',
		],
		'description'           => '',
		'public'                => true,
		'hierarchical'          => true
	]);
	register_taxonomy('schedule_places', ['schedule'], [
		'labels'                => [
			'name'              => 'Места занятий',
			'singular_name'     => 'Место занятий',
			'search_items'      => 'Найти место занятий',
			'all_items'         => 'Все места занятий',
			'view_item '        => 'Посмотреть место занятий',
			'edit_item'         => 'Редактировать место занятий',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить место занятий',
			'new_item_name'     => 'Добавить место занятий',
			'menu_name'         => 'Все места занятий',
		],
		'description'           => '',
		'public'                => true,
		'hierarchical'          => true
	]);

	register_post_type( 'prices', [
		'labels' => [
			'name'               => 'Цены', // основное название для типа записи
			'singular_name'      => 'Цена', // название для одной записи этого типа
			'add_new'            => 'Добавить новую цену', // для добавления новой записи
			'add_new_item'       => 'Добавить новую цену', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать цену', // для редактирования типа записи
			'new_item'           => 'Новая цена', // текст новой записи
			'view_item'          => 'Смотреть цены', // для просмотра записи этого типа.
			'search_items'       => 'Искать цены', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Цены', // название меню
		],
		'public'              => true,
		'menu_position'       => 20,
		'show_in_rest' => true,
		'menu_icon'           => 'dashicons-money-alt',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor'],
		'has_archive' => true
	]);
	register_post_type( 'cards', [
		'labels' => [
			'name'               => 'Прайс карты', // основное название для типа записи
			'singular_name'      => 'Прайс карта', // название для одной записи этого типа
			'add_new'            => 'Добавить новую карту', // для добавления новой записи
			'add_new_item'       => 'Добавить новую карту', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать карту', // для редактирования типа записи
			'new_item'           => 'Новая карта', // текст новой записи
			'view_item'          => 'Смотреть карту', // для просмотра записи этого типа.
			'search_items'       => 'Искать карту', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Прайс карта', // название меню
		],
		'public'              => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-analytics',
		'hierarchical'        => false,
		'supports'            => ['title'],
		'has_archive' => true
	]);
	register_post_type( 'orders', [
		'labels' => [
			'name'               => 'Заказы', // основное название для типа записи
			'singular_name'      => 'Заказ', // название для одной записи этого типа
			'add_new'            => 'Добавить новый заказ', // для добавления новой записи
			'add_new_item'       => 'Добавить новый заказ', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать заказ', // для редактирования типа записи
			'new_item'           => 'Новый заказ', // текст новой записи
			'view_item'          => 'Смотреть заказ', // для просмотра записи этого типа.
			'search_items'       => 'Искать заказ', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Заказы', // название меню
		],
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-tickets',
		'hierarchical'        => false,
		'supports'            => ['title'],
		'has_archive'         => true
	]);
}

function sc_meta_boxes() {
	add_meta_box(
		'sc-likes',
		'Количество лайков: ',
		'sc_meta_likes',
		'post'
	);

    $order_fields = [
        'sc_order_text' => 'Текст заказа',
        'sc_order_phone' => 'Телефон заказа',
        'sc_order_date' => 'Дата заказа',
        'sc_order_choice' => 'Выбор заказа',
    ];

	foreach ( $order_fields as $slug => $value ) {
		add_meta_box(
			$slug,
			$value,
			'sc_order_meta_cl',
			'orders'
		);
    }

}

function sc_order_meta_cl($post_obj, $args) {
    $slug = $args['id'];
    $data = '';
	switch ($args['id']) {
        case 'sc_order_date':
            $data = $post_obj->post_date;
            break;
        case 'sc_order_choice':
	        $id = get_post_meta( $post_obj->ID, $slug, true );
	        $title = get_the_title($id);
	        $category = get_post_type_object(get_post_type($id))->labels->name;
            $data = "Заявка <strong>$title</strong>.<br>Из раздела <strong>$category</strong>";
            break;
        default:
	        $data = get_post_meta( $post_obj->ID, $slug, true );
	        $data = $data ? $data : 'Нет данных';
	}
	echo "<p>$data</p>";
}

function sc_meta_likes($post_obj) {
	$likes = get_post_meta( $post_obj->ID, 'sc-likes', true );
	$likes = $likes ? $likes : '0';
	echo "<p>$likes</p>";

}


////////////////////////////////////////////////////////////////


function register_my_setting() {
	add_settings_field(
		'sc_settings_slogan_field',
		'Слоган сайта',
		'sc_settings_slogan_cb',
		'general',
		'default',
		['label_for' => 'sc_settings_slogan_field']
	);

	register_setting(
		'general',
		'sc_settings_slogan_field',
		'strval'
	);
}

function sc_settings_slogan_cb( $args ) {
	$slug = $args['label_for'];
?>
	<input class="regular-text code"
		type="text"
		id="<?php echo $slug?>"
		name="<?php echo $slug?>"
		value="<?php echo get_option($slug)?>"
	>
<?php
}


////////////////////////////////////////////////////////////////


function sc_modal_form_handler() {
    $text = $_POST['si-user-name'] ? $_POST['si-user-name'] : 'Аноним';
    $phone = $_POST['si-user-phone'] ? $_POST['si-user-phone'] : false;
    $choice = $_POST['form-post-id'] ? $_POST['form-post-id'] : 'empty';

    if ($phone) {
	    $text = wp_strip_all_tags($text);
        $phone = wp_strip_all_tags($phone);
        $choice = wp_strip_all_tags($choice);

        $id = wp_insert_post(wp_slash([
            'post_title' => "Заказ № ",
            'post_status'   => 'publish',
            'post_type'     => 'orders',
            'meta_input'    => [
                'sc_order_text' =>  $text,
                'sc_order_phone' =>  $phone,
                'sc_order_choice' =>  $choice,
            ],
        ]));

        if ($id !== 0) {
            $id = wp_update_post([
                'ID' => $id,
	            'post_title' => "Заказ № " . $id,
            ]);

             update_field('order_status', 'new', $id);
        }
    }

    header('Location:' . home_url());
}
function sc_post_likes() {
    $id = $_POST['id'];
    $todo = $_POST['todo'];
    $likes = get_post_meta($id, 'sc-likes', true);
    $likes = $likes ? $likes : 0;
    if ($todo === 'plus') {
        ++$likes;
    } else {
        --$likes;
    }
    $res = update_post_meta($id, 'sc-likes', $likes);
    if ($res) {
        echo $likes;
	    wp_die();
    } else {
	    wp_die('Сорри ошибка сервера 500');
    }
}


////////////////////////////////////////////////////////////////


function sc_posts_column($current_col, $id) {
    switch ($current_col) {
        case 'likes_col':
	        $likes = get_post_meta($id, 'sc-likes', true);
	        echo $likes ? $likes : 0;
            break;
        case 'status_col':
	        $field = get_post_meta($id, 'sc_order_choice', true);
            $title = get_the_title($field);
            echo $title;
	        break;
        default:
            return;
            break;
    }
}

function sc_posts_column_filter($defaults) {
    $type = get_current_screen();
    if ($type->post_type === 'post') {
        $defaults['likes_col'] = "Лайки";
    }
    if ($type->post_type === 'orders') {
        $defaults['status_col'] = "Статус заявки";
    }
    return $defaults;
}


////////////////////////////////////////////////////////////////
