<?php
// define('ICL_LANGUAGE_CODE', 'ar');


function sess_start() {
    if (!session_id())
        session_start();
}
add_action('init', 'sess_start');



//Enable error logging.
@ini_set('log_errors', 'On');
@ini_set('error_log', '/var/www/oceanomedicina.com/htdocs/wp-content/elm-error-logs/php-errors.log');

//Don't show errors to site visitors.
@ini_set('display_errors', 'Off');
if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false);
}


/**
 * oceano functions and definitions
 *
 */

// define('ALLOW_UNFILTERED_UPLOADS', true);

require_once('functions/functions_post_types.php');
require_once('functions/functions_products.php');
require_once('functions/functions_helpers.php');
require_once('functions/functions_pricing.php');
require_once('functions/functions_menus.php');
require_once('functions/functions_woocommerce.php');

require_once('functions/functions_fetchAmount.php');



define('WPCF7_AUTOP', false);
add_filter('wpcf7_autop_or_not', '__return_false');



if (!function_exists('oceano_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features
     *
     *  It is important to set up these functions before the init hook so that none of these
     *  features are lost.
     *
     *  @since oceanoNuevo 1.0
     */
    function oceano_setup() {

        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on oceano, use a find and replace
		 * to change 'oceano' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('oceano', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        add_theme_support('woocommerce');

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support('title-tag');

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(

            'header-comunidad' => esc_html__('Menú header comunidad', 'oceano'),
            'footer-columna-1' => esc_html__('Menú footer columna 1', 'oceano'),
            'footer-columna-2' => esc_html__('Menú footer columna 2', 'oceano'),

        ));

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('oceano_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));
    }
endif; // oceano_setup
add_action('after_setup_theme', 'oceano_setup');


function add_theme_styles_scripts() {
    $rand = rand(1, 99999999999);

    wp_enqueue_style('swiper', 'https://unpkg.com/swiper@7/swiper-bundle.min.css', $rand, false);
    wp_enqueue_style('bulma', 'https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css', $rand, false);
    wp_enqueue_style('font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', $rand, false);
    wp_enqueue_style('material_design_icons', 'https://cdn.jsdelivr.net/npm/@mdi/font@6.4.95/css/materialdesignicons.min.css', $rand, false);

    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', $rand, true);
    wp_enqueue_script('loader-button', get_template_directory_uri() . '/assets/js/loader-button.js', array('jquery'),  $rand, true);
    wp_enqueue_script('general-scripts', get_template_directory_uri() . '/assets/js/general-scripts.js', array('jquery'),  $rand, true);
    wp_enqueue_script('navbar-script', get_template_directory_uri() . '/assets/js/navbar.js', array('jquery'),  $rand, true);
    wp_enqueue_script('modal-script', get_template_directory_uri() . '/assets/js/modal.js', array('jquery'),  $rand, true);
    wp_enqueue_script('swiper', 'https://unpkg.com/swiper@7/swiper-bundle.min.js', array('jquery'), $rand, true);


    if (is_page_template('pages/home.php')) {
        wp_enqueue_style('home', get_template_directory_uri() . '/assets/css/home.css', [], $rand, false);
        wp_enqueue_script('filter-home-destacados', get_template_directory_uri() . '/assets/js/home/filter-home.js', array('jquery'), $rand, true);

        wp_enqueue_script('swiper-sliders', get_template_directory_uri() . '/assets/js/home/swiper-sliders.js', array('jquery'), 1, true);
    };

    if (is_page_template('pages/plan-de-estudio.php')) {
        wp_enqueue_style('plan-estudio', get_template_directory_uri() . '/assets/css/plan-de-estudio.css');

        wp_enqueue_script('plan-estudio', get_template_directory_uri() . '/assets/js/plan-estudio/plan-de-estudio.js', array('jquery'), $rand, true);
        wp_enqueue_script('plan-estudio-swiper', get_template_directory_uri() . '/assets/js/plan-estudio/swiper-plan-estudio.js', array('jquery'), $rand, true);
    };
    if (is_page_template('pages/template_base.php')) {
        wp_enqueue_style('estilos-base', get_template_directory_uri() . '/assets/css/landing-terms.css');
    }
    if (is_page_template('pages/pagina-base.php')) {
        $current_page =  get_queried_object()->post_name;
        switch ($current_page) {
            case 'terminos-y-condiciones':
                wp_enqueue_style('terminos-y-condiciones', get_template_directory_uri() . '/assets/css/landing-terms.css');
                break;
            case 'contacto':
            case 'instituciones':
            case 'programa-de-instituciones':
                wp_enqueue_style('instituciones-contacto', get_template_directory_uri() . '/assets/css/instituciones.css');
                break;
            case 'nuestra-mision':
                wp_enqueue_style('nuestra-mision', get_template_directory_uri() . '/assets/css/landing-mision.css');
                wp_enqueue_script('nuestra-mision-swiper', get_template_directory_uri() . '/assets/js/pagina_base/nuestra_mision_scripts.js', array('jquery'), $rand, true);
                break;
            case 'politica-de-cookies':
            case 'condiciones-de-contratacion':
                wp_enqueue_style('politica-de-cookies', get_template_directory_uri() . '/assets/css/landing-politicas.css');
                break;
            case 'politicas-de-privacidad':
                wp_enqueue_style('politicas-de-privacidad', get_template_directory_uri() . '/assets/css/landing-politicas.css');
                break;
            case 'politicas-de-privacidad':
                wp_enqueue_style('politicas-de-privacidad', get_template_directory_uri() . '/assets/css/landing-terms.css');
                break;

            default:
                wp_enqueue_style('construccion', get_template_directory_uri() . '/assets/css/landing-terms.css');
                break;
        }
    };
    if (is_page_template('pages/tienda.php') || is_shop()) {
        wp_enqueue_style('tienda-estilos', get_template_directory_uri() . '/assets/css/tienda.css');

        wp_enqueue_script('tienda-swiper', get_template_directory_uri() . '/assets/js/tienda/swiper-tienda.js', array('jquery'), $rand, true);
        wp_enqueue_script('tienda-filtros', get_template_directory_uri() . '/assets/js/tienda/filters-tienda.js', array('jquery'), $rand, true);
    };
    if (is_page_template('pages/gracias.php')) {
        wp_enqueue_style('gracias-estilos', get_template_directory_uri() . '/assets/css/gracias.css');
        // wp_enqueue_script( 'gracias-scripts', get_template_directory_uri() . '/assets/js/tienda/script-gracias.js', array( 'jquery' ), $rand, true); 
    };

    if (is_product()) {
        wp_enqueue_style('ficha-producto', get_template_directory_uri() . '/assets/css/ficha-producto.css', array(), $rand);

        wp_enqueue_script('swiper-producto', get_template_directory_uri() . '/assets/js/product/swiper-products.js', array('jquery'), $rand, true);
        wp_enqueue_script('tabs', get_template_directory_uri() . '/assets/js/tabs.js', array('jquery'), $rand, true);
        wp_enqueue_script('modal', get_template_directory_uri() . '/assets/js/product/modal.js', array('jquery'), $rand, true);
        wp_enqueue_script('scripts-productos', get_template_directory_uri() . '/assets/js/product/scripts-products.js', array('jquery'), $rand, true);
    };
    if (is_page_template('pages/carrito.php') || is_cart()) {

        wp_enqueue_style('carrito-estilos', get_template_directory_uri() . '/assets/css/cart.css');
        wp_register_script('scripts', get_template_directory_uri() . '/assets/js/cart/scripts.js', array('jquery'), $rand, true);
        wp_enqueue_script('scripts');
        wp_localize_script(
            'scripts',
            'php_vars_passed',
            array(
                'icl_language' => ICL_LANGUAGE_CODE,
                'carriten' => admin_url('admin-ajax.php')
            )
        );

        wp_register_script('cart-scripts', get_template_directory_uri() . '/assets/js/cart/cart-scripts.js', array('jquery'), $rand, true);
        wp_enqueue_script('cart-scripts');
        wp_localize_script(
            'cart-scripts',
            'php_vars_passed',
            array(
                'icl_language' => ICL_LANGUAGE_CODE,
                'carriten' => admin_url('admin-ajax.php')
            )
        );


        wp_enqueue_script('ajax-add-to-cart', get_template_directory_uri() . '/assets/js/cart/ajax-add-to-cart.js', array('jquery'), $rand, true);

        wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/cart/modernizr.js', array('jquery'), $rand, true);
        wp_enqueue_script('navigation', get_template_directory_uri() . '/assets/js/cart/navigation.js', array('jquery'), $rand, true);
        wp_enqueue_script('scripts-global', get_template_directory_uri() . '/assets/js/cart/scripts-global.js', array('jquery'), $rand, true);
        wp_enqueue_script('skip-link-focus-fix', get_template_directory_uri() . '/assets/js/cart/skip-link-focus-fix.js', array('jquery'), $rand, true);
    };

    if (is_single() && 'post' == get_post_type()) {
        wp_enqueue_style('post-estilos', get_template_directory_uri() . '/assets/css/post-magazine.css', [], $rand, false);

        wp_enqueue_script('scripts-post', get_template_directory_uri() . '/assets/js/magazine/scripts_sinlge_post.js', array('jquery'), $rand, true);
    }

    if (is_page_template('pages/archive-magazine.php')) {
        wp_enqueue_style('magazine-archive-estilos', get_template_directory_uri() . '/assets/css/magazine-categorias.css');
        wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css');
        wp_enqueue_style('daterangepicker', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css');

        wp_enqueue_script('moment', 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js', array('jquery'), $rand, true);
        wp_enqueue_script('daterangepicker', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', array('jquery'), $rand, true);
        wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.13.1/jquery-ui.js', array('jquery'), $rand, true);
        wp_enqueue_script('scripts-magazine', get_template_directory_uri() . '/assets/js/magazine/scripts_archivo_magazine.js', array('jquery'), $rand, true);
    };

    if (is_page_template('pages/convenios_avales.php')) {
        wp_enqueue_style('avales-styles', get_template_directory_uri() . '/assets/css/avales.css');
        wp_enqueue_style('materialdesign', 'https://cdn.jsdelivr.net/npm/@mdi/font@6.4.95/css/materialdesignicons.min.css');
        wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');


        wp_enqueue_script('select', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), $rand, true);
        wp_enqueue_script('accordion', get_template_directory_uri() . '/assets/js/convenios_avales/accordion.js', array('jquery'), $rand, true);   /* wp_enqueue_script( 'avales-filter', get_template_directory_uri() . '/assets/js/convenios_avales/avales-filter.js', array( 'jquery' ), $rand, true); */

        wp_enqueue_script('cursos-filter', get_template_directory_uri() . '/assets/js/convenios_avales/cursos-filter.js', array('jquery'), $rand, true);
        wp_enqueue_script('modal', get_template_directory_uri() . '/assets/js/convenios_avales/modal.js', array('jquery'), $rand, true);
        wp_enqueue_script('navbar', get_template_directory_uri() . '/assets/js/convenios_avales/navbar.js', array('jquery'), $rand, true);
        wp_enqueue_script('tabs', get_template_directory_uri() . '/assets/js/convenios_avales/tabs.js', array('jquery'), $rand, true);
        wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/convenios_avales/avales-scripts.js', array('jquery'), $rand, true);
    };

    if (is_page_template('pages/magazine.php')) {
        wp_enqueue_style('magazine-archive-estilos', get_template_directory_uri() . '/assets/css/magazine.css');

        wp_enqueue_script('scripts-magazine', get_template_directory_uri() . '/assets/js/magazine/scripts-magazine-home.js', array('jquery'), $rand, true);
    };

    if (is_page_template('pages/pagos.php')) {
        wp_enqueue_style('pagos-estilos', get_template_directory_uri() . '/assets/css/pagos.css', $rand, false);
        wp_enqueue_style('pagos-anexo', get_template_directory_uri() . '/assets/css/pagos-anexo.css', $rand, false);
        wp_enqueue_style('picker', get_template_directory_uri() . '/assets/css/picker.min.css', $rand, false);
        wp_enqueue_script('picker', get_template_directory_uri() . '/assets/js/picker.js', array(), '', true);

        wp_enqueue_script('oceano-skip-link-focus-fix', 'https://ar.oceanomedicina.com/wp-content/themes/oceano/js/skip-link-focus-fix.js', array('jquery'), $rand, true);
    };
    if (is_page_template('pages/gracias_pagos.php')) {
        wp_enqueue_style('gracias-estilos', get_template_directory_uri() . '/assets/css/gracias_pagos.css', $rand, false);

        wp_register_script('scripts-pagos', get_template_directory_uri() . '/assets/js/gracias_pagos/gracias_pagos.js', array('jquery'), $rand, true);
        wp_enqueue_script('scripts-pagos');
        wp_localize_script(
            'scripts-pagos',
            'php_vars_passed',
            array(
                'carriten' => admin_url('admin-ajax.php')
            )
        );
    };
    if (is_page_template('pages/pagos_rechazados.php')) {
        wp_enqueue_style('gracias-estilos', get_template_directory_uri() . '/assets/css/gracias_pagos.css', $rand, false);
    };
    if (is_page_template('pages/productos.php')) {
        wp_enqueue_style('pagos-estilos', get_template_directory_uri() . '/assets/css/pagos.css', $rand, false);
    };

    wp_enqueue_script('jquery-dgwt-wcas', 'https://oceanomedicina.tech/wp-content/plugins/ajax-search-for-woocommerce/assets/js/search.min.js?ver=1.15.0', array('jquery'), $rand, true);
}
add_action('wp_enqueue_scripts', 'add_theme_styles_scripts');

add_action('rest_api_init', function () {
    register_rest_route('oceanoAPI', '/empty-cart/', array(
        'methods' => 'GET',
        'callback' => 'inu_empty_cart',
    ));
    register_rest_route('oceanoAPI', '/reload-cart/', array(
        'methods' => 'GET',
        'callback' => 'reload_mini_cart',
    ));
    register_rest_route('oceanoAPI', '/get-redirect-url/', array(
        'methods' => ['POST', 'GET'],
        'callback' => 'get_redirect_ajax_url',
    ));
    register_rest_route('oceanoAPI', '/create-whatsapp-reference-code/', array(
        'methods' => ['POST', 'GET'],
        'callback' => 'create_whatsapp_reference_code',
    ));
    register_rest_route('oceanoAPI', '/get-reference-code-data/', array(
        'methods' => ['POST', 'GET'],
        'callback' => 'get_reference_code_data',
    ));
});

function inu_empty_cart() {
    global $woocommerce;
    $woocommerce->cart->empty_cart();
    return true;
}

function reload_mini_cart() {
    inudev_display_cart();
    die();
}

function inudev_display_cart($refresh_cart = true) {
?>
<div class="cart">
    <?php display_woocommerce_cart($refresh_cart); ?>
    <?php /* echo do_shortcode('[custom-techno-mini-cart]'); */ ?>
</div>
<?php
}
//If it should redirect, return the URL to redirect
function get_redirect_ajax_url() {
}

///oceanomedicina.com/wp-json/oceanoAPI/create-whatsapp-reference-code
function create_whatsapp_reference_code() {
    global $wpdb;
    $wpdb->insert('wp_reference_codes', array(
        'url' => $_POST['url'],
        'utm_source' => $_POST['utm_source'],
        'utm_medium' => $_POST['utm_medium'],
        'utm_campaign' => $_POST['utm_campaign'],
        'utm_content' => $_POST['utm_content'],
        'gclid' => $_POST['gclid'],
        'origin' => $_POST['origin'],
    ));
    return wp_send_json_success([
        "wsp_url" => "https://api.whatsapp.com/send?phone=5491139045804&text=Hola!%20Neceisto%20asistencia,%20mi%20c%C3%B3digo%20de%20referencia%20es:%20" . $wpdb->insert_id,
        "reference_code" => $wpdb->insert_id
    ]);
}

function get_reference_code_data() {
    global $wpdb;
    $data = $wpdb->get_row("SELECT * FROM wp_reference_codes WHERE id = " . intval($_GET['reference_code']));
    return wp_send_json_success($data);
}


//AJAX para vaciar carrito
add_action('wp_ajax_nopriv_hookvaciarcarrito', 'ajax_vaciar_carrito');
add_action('wp_ajax_hookvaciarcarrito', 'ajax_vaciar_carrito');

//revisa si tenés algo en el carrito
//si no tenés nada... pues te manda al inicio! (no podés estar en pagos)
function pagos_redirect() {
    global $post;

    if (isset($post)) {

        if (is_page_template('pages/pagos.php')) {
            if (WC()->cart->get_cart_contents_count() == 0) {
                wp_redirect(get_home_url());
                exit;
            }
        }
    }
}
//Comprueba si estan en el subdominio de argentina o mexico para mostrar las cosas del plan de estudio
$show_plan_estudio = (get_country_code_from_subdomain() == 'ec' || get_country_code_from_subdomain() == 'ar' || get_country_code_from_subdomain() == 'mx') ? true : false;
$enMantenimiento = false;
$isTestEnv = explode('.', $_SERVER['HTTP_HOST'])[2] == 'tech' ? true : false;


//tengo que agregar los JS para el form de pagos y resto
function enqueue_scripts_general() {

    $url = $_SERVER['SERVER_NAME'];
    if (is_page_template('pages/pagos.php')) {
        $rand = rand(1, 99999999999);


        wp_register_script('scripts', get_template_directory_uri() . '/assets/js/pagos/scripts.js', array('jquery'), $rand, true);
        wp_enqueue_script('scripts');
        wp_localize_script(
            'scripts',
            'php_vars_passed',
            array(
                'icl_language' => ICL_LANGUAGE_CODE,
                'carriten' => admin_url('admin-ajax.php')
            )
        );

        if (explode(".", $_SERVER['SERVER_NAME'])[0] == 'ar' || explode(".", $_SERVER['SERVER_NAME'])[0] == 'mx') {
            //adicionales

            wp_enqueue_script('scripts-global', get_template_directory_uri() . '/assets/js/pagos/scripts-global.js', array('jquery'), $rand, true);
            wp_enqueue_script('parsley', get_template_directory_uri() . '/assets/js/parsley.min.js', array('jquery'), $rand, true);
            wp_enqueue_script('thumbs', get_template_directory_uri() . '/assets/js/pagos/thumbs.js', array('jquery'), $rand, true);
            wp_enqueue_script('visualsteps', get_template_directory_uri() . '/assets/js/pagos/visualsteps.js', array('jquery'), $rand, true);
            wp_enqueue_script('utility', get_template_directory_uri() . '/assets/js/pagos/utility.js', array('jquery'), $rand, true);
            wp_enqueue_script('populator', get_template_directory_uri() . '/assets/js/pagos/populator.js', array('jquery'), $rand, true);
            wp_enqueue_script('tokenmsg', get_template_directory_uri() . '/assets/js/pagos/tokenmsg.js', array('jquery'), $rand, true);
            wp_enqueue_script('validador', get_template_directory_uri() . '/assets/js/pagos/validador.js', array('jquery'), $rand, true);
            wp_enqueue_script('save-data', get_template_directory_uri() . '/assets/js/pagos/saveData.js', array('jquery'), $rand, true);
            wp_enqueue_script('mercadopago', "https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js", array('jquery'), $rand, true);

            // wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/pagos/pagos_new/main.js', array( 'jquery' ), $rand, true); 
            // wp_enqueue_script('validator', get_template_directory_uri() . '/assets/js/pagos/pagos_new/validator.js', array( 'jquery' ), $rand, true); 
            // wp_enqueue_script('thumbs', get_template_directory_uri() . '/assets/js/pagos/pagos_new/thumbs.js', array( 'jquery' ), $rand, true); 
            // wp_enqueue_script('utility', get_template_directory_uri() . '/assets/js/pagos/pagos_new/utility.js', array( 'jquery' ), $rand, true); 
            // wp_enqueue_script('populator', get_template_directory_uri() . '/assets/js/pagos/pagos_new/populator.js', array( 'jquery' ), $rand, true); 

            wp_register_script('main', get_template_directory_uri() . '/assets/js/pagos/main.js', array('jquery'), $rand, true);
            wp_enqueue_script('main');
            wp_localize_script(
                'main',
                'php_vars_passed',
                array(
                    'carriten' => admin_url('admin-ajax.php')
                )
            );

            wp_enqueue_script('installments', get_template_directory_uri() . '/assets/js/pagos/installments.js', array('jquery'), $rand, true);
        } else {


            wp_enqueue_script('scripts-global', get_template_directory_uri() . '/assets/js/pagos/scripts-global.js', array('jquery'), $rand, true);

            wp_enqueue_script('parsley', get_template_directory_uri() . '/assets/js/parsley.min.js', array('jquery'), $rand, true);
            wp_enqueue_script('utility', get_template_directory_uri() . '/assets/js/pagos/utility.js', array('jquery'), $rand, true);
            wp_enqueue_script('populator', get_template_directory_uri() . '/assets/js/pagos/populator.js', array('jquery'), $rand, true);
            wp_enqueue_script('save-data', get_template_directory_uri() . '/assets/js/pagos/saveData.js', array('jquery'), $rand, true);
            wp_enqueue_script('visualsteps', get_template_directory_uri() . '/assets/js/pagos/visualsteps.js', array('jquery'), $rand, true);
            wp_enqueue_script('stripeLibrary', 'https://js.stripe.com/v3/');
            wp_register_script('stripe', get_template_directory_uri() . '/assets/js/pagos/stripe.js', array('jquery', 'stripeLibrary'), $rand, true);
            wp_enqueue_script('stripe');
            wp_localize_script(
                'stripe',
                'php_vars_passed',
                array(
                    'carriten' => admin_url('admin-ajax.php')
                )
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_general');




/* la funcion show_header() obtiene un string el cual compara para saber si renderizar el header 'header-1-translucent' o el header
'header-2-solid' dependiendo lo que necesite cada pagina */
function show_header($headerOption) {
    if ($headerOption == 'translucent') {
        get_template_part('./template-parts/header/header-1-translucent');
    }
    if ($headerOption == 'magazine') {
        get_template_part('./template-parts/header/header-2-magazine');
    }
}

/* la funcion show_footer() obtiene un string el cual compara para saber si renderizar el header 'header-1-full' o el header
'header-2-simple' dependiendo lo que necesite cada pagina */
function show_footer($footerOption) {
    if ($footerOption == 'full') {
        get_template_part('./template-parts/footer/footer-1-full');
    }
}

// add_action( 'template_redirect', 'redirect_to_specific_page' );
// function redirect_to_specific_page() {
// if ( (is_page('magazine') || is_page('resultados-de-busqueda') || (is_single() && 'post' == get_post_type() )) && ! is_user_logged_in() ) {
//         wp_redirect( '/', 301 ); 
//         exit;
//     }
// }

// *Archivo de importacion para post
// require_once('functions/function_importPost.php');

// *Actualizar los post con su categoria correspondiete
// require_once('functions/function_UpdateCategory.php');

//* Actualizar el campo de articulos relacionados con dos articulos con tags similares desde el 2020 a la actualizad
// require_once('functions/function_relatePostByTagOrCategory.php');

//* Eliminar campos de los post
// require_once('functions/function_deleteFields.php');s

//* Actualizar datos faltantes de los post (Fuentes y aspectos relevantes)
// require_once('functions/function_updateFieldsEmpty.php');


//* Funcion para generar el endpoint de productos
require_once('functions/function_endpoint.php');

function VaciarPlanDeEstudio() {
    global $woocommerce;
    $woocommerce->cart->empty_cart();
    $_SESSION['plan_de_estudio'] = 0;

    echo json_encode('Plan de estudio eliminado del carrito');
    die();
}
add_action('wp_ajax_nopriv_vaciarpl', 'VaciarPlanDeEstudio');
add_action('wp_ajax_vaciarpl', 'VaciarPlanDeEstudio');


// Admit SVG files
function dmc_add_svg_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'dmc_add_svg_mime_types');