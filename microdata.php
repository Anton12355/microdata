<?php
/**
 * Plugin Name: Microdata
 * Plugin URI:
 * Description:  Plugin for adding and managing address with microdata
 * Version:      1.0
 * Author:       Anton Shlobin
 * Author URI:   vk.com/id2804848
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  microdata
 * Domain Path:  /languages
 */
namespace microdata;

function contacts_template( $atts ) {
	$atts = shortcode_atts( array(
		//Значения по умолчанию
		'company_name'        => '"Лучшие телефоны"',
		'street'      => 'ул. Торговая, д. 1',
		'postal_code' => '123456',
		'locality'    => 'Москва',
		'phone'       => '+7 495 123–45–67',
		'fax'         => '+7 495 123–45–67',
		'email'       => 'admin@phones-best.ru',
	), $atts, 'contacts' );

	$out = '<div class="contacts" itemscope itemtype="http://schema.org/Organization">' .
	       '<div class="contacts__company">ЗАО <span itemprop="name">' . esc_html( $atts['company_name'] ) . '</span></div>' .
	       'Контакты:' .
	       '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">' .
	       'Адрес: ' .
	       '<span itemprop="streetAddress">' . esc_html( $atts['street'] ) . '</span>, ' .
	       '<span itemprop="postalCode">' . esc_html( $atts['postal_code'] ) . '</span>, ' .
	       '<span itemprop="addressLocality">' . esc_html( $atts['locality'] ) . '</span>' .
	       '</div>' .
	       '<div>Телефон: <span itemprop = "telephone" >' . esc_html( $atts['phone'] ) . '</span ></div>' .
	       '<div>Факс: <span itemprop = "faxNumber" >' . esc_html( $atts['fax'] ) . '</span ></div>' .
	       '<div>Электронная почта: <span itemprop = "email" >' . esc_html( $atts['email'] ) . '</span ></div>' .
	       '</div >';

	return $out;
}

add_shortcode( 'contacts', '\microdata\contacts_template' );

// Хуки
function true_add_mce_button() {
	// проверяем права пользователя - может ли он редактировать посты и страницы
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return; // если не может, то и кнопка ему не понадобится, в этом случае выходим из функции
	}
	// проверяем, включен ли визуальный редактор у пользователя в настройках (если нет, то и кнопку подключать незачем)
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', '\microdata\true_add_tinymce_script' );
		add_filter( 'mce_buttons', '\microdata\true_register_mce_button' );
	}
}
add_action('admin_head', '\microdata\true_add_mce_button');

// В этом функции указываем ссылку на JavaScript-файл кнопки
function true_add_tinymce_script( $plugin_array ) {
	$plugin_array['true_mce_button'] = get_stylesheet_directory_uri() .'/js/true_button.js'; // true_mce_button - идентификатор кнопки
	return $plugin_array;
}

// Регистрируем кнопку в редакторе
function true_register_mce_button( $buttons ) {
	array_push( $buttons, 'true_mce_button' ); // true_mce_button - идентификатор кнопки
	return $buttons;
}

function enqueue_styles() {
	wp_enqueue_style( 'microdata-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );

}

add_action( 'wp_enqueue_scripts', '\microdata\enqueue_styles' );