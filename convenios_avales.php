<?php

/**
 * Template Name: Convenios Avales
 */

get_header(null, ['type_header' => 'translucent']);

$uploadLocation = wp_get_upload_dir();

$actualCountry = get_country_full_name(ICL_LANGUAGE_CODE);

$titulo_hero = get_field('titulo_avales');
$bajada_hero = get_field('bajada_avales');
$info_hero = get_field('info_avales');

$titulo_publicidad = get_field('titulo');
$bajada_publicidad = get_field('bajada');
$imagen_de_fondo_publicidad = get_field('imagen_de_fondo');
$atributos_publicidad = get_field('atributos');
$sliders_promocionales = get_field('sliders_promocionales');

$lista_de_paises = get_field('lista_de_paises');
$lista_de_avales = get_field('lista_de_avales');

$lista_avales_paises = get_field('lista_avales_paises');

// print_r($lista_avales_paises);

foreach ($lista_avales_paises as $lista) :
    if ($lista['pais'] != 'Todos') continue;
    foreach ($lista['avales'] as $aval) :
        $campos = get_field('campos_para_pagina_de_convenios', $aval->ID);
        $imagen_aval =  $campos['imagen_svg_color'] != '' ?  "{$uploadLocation['baseurl']}/micrositio-avales/{$campos['imagen_svg_color']}" : wp_get_attachment_url(get_post_thumbnail_id($aval->ID, 'thumbnail'));
        $lista_avales[] = (object) array(
            'ID' => $aval->ID,
            'title' => $aval->post_title,
            'img' => $imagen_aval,
            'pais' => $lista['pais'],
            'campos' => $campos,
            'bajada' => $campos['bajada'],
            'cursos_relacionados' => $campos['cursos_relacionados'],
            'bloques_info' => $campos['bloques_info'],
            'mensajes_destacados' => $campos['mensajes_destacados'],
        );
    endforeach;
endforeach;

?>

<section id="hero" class="hero" pais-actual="<?= $actualCountry ?>">
    <div class="back-overlay"></div>
    <picture>
        <source media="(max-width: 480px)" srcset="<?= get_field('imagen_de_fondo_m') ?>">
        <source media="(max-width: 1920px)" srcset="<?= get_field('imagen_de_fondo_l') ?>">
        <img src="<?= get_field('imagen_de_fondo_m') ?>" alt="Imagen de fondo" loading="lazy" decoding="async">
    </picture>
    <article class="hero-cont contenedor mx-auto">
        <h1><?= $titulo_hero ?></h1>
        <h2><?= $bajada_hero ?></h2>
    </article>
    <div id="demo1" class="avales contenedor mx-auto">
        <div class="avales-header">
            <div class="filter-categories">
                <?php foreach ($lista_avales_paises as $pais) : ?>
                <span>
                    <input type="radio" id="<?= $pais['pais'] ?>" class="filter-input" name="filter-1"
                        <?= $pais['pais'] == 'Todos' ? 'checked' : '' ?>>
                    <label for="<?= $pais['pais'] ?>" class="filter-label"><?= $pais['pais'] ?></label>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="filter-wrap">

            <?php foreach ($lista_avales_paises as $lista) : ?>

            <div class="avales-grid" pais="<?= $lista['pais'] ?>">
                <?php
                    foreach ($lista['avales'] as $aval) :

                        $campos = get_field('campos_para_pagina_de_convenios', $aval->ID);

                        $imagen_aval = $campos['imagen_svg_blanco'];
                        $imagen_aval = $campos['imagen_svg_blanco'] != '' ? $campos['imagen_svg_blanco'] : $campos['imagen_svg_color'];
                        $imagen_aval = $imagen_aval != null ? "{$uploadLocation['baseurl']}/micrositio-avales/{$imagen_aval}" : wp_get_attachment_url(get_post_thumbnail_id($aval->ID, 'thumbnail'));
                    ?>
                <a class="avales-card filter-item" aval-id="<?= $aval->ID ?>" href="<?php echo '#aval=' . $aval->ID ?>">
                    <div class="avales-card-overlay"></div>
                    <img src="<?= $imagen_aval ?> " alt="<?= $aval->post_title ?>" class="avales-card-img"
                        loading="lazy" decoding="async">
                </a>
                <?php endforeach; ?>

                <div class="filter-no-item">

                    <div class="">
                        <h3><span class="is-size-5 is-block">¡Ups!</span>Intenta otra selección
                        </h3>

                    </div>
                </div>
            </div>

            <?php endforeach; ?>



            <div class="filter-mask"></div>
        </div>
        <?= $info_hero ?>
    </div>
</section>

<?php
$aval_contador = 0;
foreach ($lista_avales as $aval) :
?>
<div id="aval-<?= $aval->ID ?>" class="avales-list">
    <section class="aval">
        <article class="aval-grid contenedor mx-auto">
            <div class="aval-grid-section section-left">
                <div class="aval-img">
                    <img src="<?= $aval->img ?>" alt="Imagen del aval" loading="lazy" decoding="async">
                </div>

                <div class="aval-info-extra">
                    <div class="aval-info-extra-overlay"></div>
                    <picture>
                        <img src="<?= $imagen_de_fondo_publicidad ?>" alt="Imagen de fondo de publicidad" loading="lazy"
                            decoding="async">
                    </picture>
                    <div class="aval-info-extra-data">
                        <div>
                            <h4><?= $titulo_publicidad ?></h4>
                            <h5><?= $bajada_publicidad ?></h5>
                        </div>
                        <div>
                            <?php foreach ($atributos_publicidad as $atributo) : ?>
                            <h6><?= $atributo['atributo'] ?></h6>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aval-grid-section section-right">
                <div class="aval-info">
                    <h2 class="aval-grid-info-title"> <img
                            src="<?= get_template_directory_uri() ?>/assets/media/icon/Arrow-black.svg"
                            alt="icono de flecha" loading="lazy" decoding="async"><?= $aval->title ?></h2>
                    <h3 class="aval-grid-info-subtitle"><?= $aval->bajada ?></h3>
                </div>
                <div class="aval-details">
                    <?php foreach ($aval->bloques_info as $key => $bloque) : ?>
                    <div class="aval-details-card">
                        <div class="aval-details-card-img">
                            <img src="<?= get_template_directory_uri() ?>/assets/media/icon/aval-detail-<?= $key + 1 ?>.svg"" alt="
                                Icono del bloque de informacion" loading="lazy" decoding="async">
                        </div>
                        <h4><?= $bloque['titulo'] ?></h4>
                        <h5><?= $bloque['descripcion'] ?></h5>
                    </div>
                    <?php endforeach; ?>

                </div>
                <div class="aval-swiper">
                    <div class="swiper-avales">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->

                            <?php foreach ($sliders_promocionales as $slide) :
                                    $showSlide = false;
                                    foreach ($slide['en_que_avales_aparece'] as $aval_in_slide) {
                                        if ($aval_in_slide->ID == $aval->ID) $showSlide = true;
                                    }
                                    if (!($showSlide)) continue;
                                ?>
                            <div class="swiper-slide">
                                <div class="swiper-slide-overlay"></div>
                                <picture>
                                    <source media="(max-width: 480px)" srcset="<?= $slide['imagen_de_fondo_s'] ?>">
                                    <source media="(max-width: 1920px)" srcset="<?= $slide['imagen_de_fondo_l'] ?>">
                                    <img src="<?= $slide['imagen_de_fondo_l'] ?>" alt="Imagen de fondo de de slider"
                                        loading="lazy" decoding="async">
                                </picture>
                                <div class="swiper-slide-info">
                                    <h4 class="aval-grid-info-title"><?= $slide['titulo'] ?></h4>
                                    <h5><?= $slide['descripcion'] ?></h5>
                                    <a <?= $slide['link_del_boton'] ? "href={$slide['link_del_boton']}" : "redirectAnchor='{$slide['link_interno_boton']}'" ?>
                                        class="btn btn-big"><?= $slide['texto_del_boton'] ?></a>
                                </div>
                            </div>
                            <?php endforeach; ?>

                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>

                    </div>
                </div>
            </div>
        </article>
    </section>

    <!----4.CURSOS---->
    <section class="aval-related">
        <section id="cursos" class="cursos">
            <article class="cursos-cont contenedor mx-auto">
                <div class="cursos-cont-header">
                    <h3> <img src="<?= get_template_directory_uri() ?>/assets/media/icon/arrow-white.png"
                            alt="Icono de flecha" loading="lazy" decoding="async"> Descubrí cursos de acuerdo a tu
                        especialidad</h3>
                    <select id="selectEspecialidad" class="select2" name="filtersEspecialidad">
                        <option value="" disabled selected>Seleccione una opcion</option>
                        <option value="*" selected>Todos los cursos</option>
                        <?php

                            if (get_field('es_convenio', $aval->ID)) {
                                $args_productos = array(
                                    'post_type'      => 'product',
                                    'posts_per_page' => -1,
                                    'meta_query' => array(
                                        'show_post_query' => array(
                                            'key' => 'highlighted_product',
                                            'value' => '1'
                                        )
                                    ),
                                );

                                $producto_related = new WP_Query($args_productos);

                                if (!($producto_related->have_posts())) {
                                    continue;
                                }
                                while ($producto_related->have_posts()) : $producto_related->the_post();
                                    $product_categories = strip_tags(wc_get_product_category_list(get_the_ID(), '~', '', ''));
                                    $product_categories_array = explode('~', $product_categories);
                                    foreach ($product_categories_array as $category) {
                                        $saveActualCategoryArray[] = $category;
                                    }
                                endwhile;

                                foreach (array_unique($saveActualCategoryArray) as  $category) {
                                    echo '<option value="' . str_replace(' ', '-', removeAccents(strtolower($category))) . '">' . $category . '</option>';
                                }
                                $saveActualCategoryArray = [];
                            } else {
                                foreach ($aval->cursos_relacionados as $curso) :
                                    $args_productos = array(
                                        'post_type'      => 'product',
                                        'posts_per_page' => '1',
                                        'meta_query' => array(
                                            array(
                                                'key'     => 'father_post_id',
                                                'value'   => array($curso->ID),
                                                'compare' => 'IN'
                                            ),
                                        )
                                    );
                                    $producto_related = new WP_Query($args_productos);

                                    if (!($producto_related->have_posts())) {
                                        continue;
                                    }
                                    while ($producto_related->have_posts()) : $producto_related->the_post();
                                        $product_categories = strip_tags(wc_get_product_category_list(get_the_ID(), '~', '', ''));
                                        $product_categories_array = explode('~', $product_categories);
                                        foreach ($product_categories_array as $category) {
                                            $saveActualCategoryArray[] = $category;
                                        }
                                    endwhile;
                                endforeach;
                                foreach (array_unique($saveActualCategoryArray) as  $category) {
                                    echo '<option value="' . str_replace(' ', '-', removeAccents(strtolower($category))) . '">' . $category . '</option>';
                                }
                                $saveActualCategoryArray = [];
                            }
                            ?>

                    </select>
                </div>
                <div class="cursos-cont-grid">

                    <?php
                        if (get_field('es_convenio', $aval->ID)) {

                            $args_productos = array(
                                'post_type'      => 'product',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    'show_post_query' => array(
                                        'key' => 'highlighted_product',
                                        'value' => '1'
                                    )
                                ),
                            );
                            $producto_related = new WP_Query($args_productos);
                            if (!($producto_related->have_posts())) {
                                continue;
                            }
                            while ($producto_related->have_posts()) : $producto_related->the_post();
                                // $productID = $producto_related->posts[0]->ID;
                                $productID = get_the_ID();
                                $fatherID = get_field('father_post_id', $productID);
                                $card_title = get_field('short_name', $fatherID);
                                $card_title = ($card_title) ? $card_title : get_the_title($fatherID);
                                $card_img_url = get_field('thumbnail', $fatherID);
                                $card_img_url = ($card_img_url) ? $card_img_url : '/wp-content/uploads/2018/11/287x192.png';
                                $card_link = get_the_permalink($productID);

                                $purchase_option = (get_field('purchase_option', $productID)) ? get_field('purchase_option', $productID) : get_field('purchase_option', $fatherID);
                                $card_ribbon = ($purchase_option == 'catalogo') ? true : false;

                                $base_old_price = get_base_price($productID, get_installments());
                                $base_price = get_base_sale_price($productID, get_installments());

                                $card_precio = format_number(get_product_price_installments($productID, get_max_installments()));

                                $card_duracion = get_field("duration", $fatherID);

                                $product_categories_array = wc_get_product_category_list($productID, '_', '', '');

                                $product_categories = strip_tags(removeAccents(strtolower(str_replace('_', ' ', str_replace(' ', '-', $product_categories_array)))));

                                $product_categories_clean = strip_tags(str_replace('_', ' ', $product_categories_array));
                        ?>

                    <div class="card" category="<?= $product_categories ?>">
                        <div class="card-img">
                            <picture>
                                <img src="<?= $card_img_url ?>" alt="imagen de la tarjeta del curso" loading="lazy"
                                    decoding="async">
                            </picture>
                            <a href="" class="tags tags-medicina">Medicina</a>
                        </div>
                        <div class="card-info">
                            <div class="card-info-sup">
                                <p class="area"><?= $product_categories_clean ?></p>
                                <span class="horas"><i class="mdi mdi-clock-outline"></i><?= $card_duracion ?>
                                    horas</span>
                            </div>
                            <div class="card-info-title"><?= $card_title ?></div>
                            <div class="card-info-footer">

                                <div class="card-info-footer-precio">
                                    <?php if ($card_ribbon || !$base_old_price) : ?>
                                    <p class="cuotas"><?= get_max_installments(); ?> <?= get_installments_string(); ?>
                                    </p>
                                    <p class="price">Sin interés</p>
                                    <?php else : ?>
                                    <p class="cuotas"><?= get_max_installments(); ?> <?= get_installments_string() ?> de
                                    </p>
                                    <p class="price"><?= get_currency_symbol(); ?><?= $card_precio ?></p>
                                    <?php endif; ?>

                                </div>
                                <a href="<?= $card_link ?>" class="card-info-footer-boton btn btn-mid">Descubrir</a>
                            </div>
                        </div>
                    </div> <?php endwhile;
                                    wp_reset_postdata();
                                } else {


                                    foreach ($aval->cursos_relacionados as $curso) :

                                        $args_productos = array(
                                            'post_type'      => 'product',
                                            'posts_per_page' => '1',
                                            'meta_query' => array(
                                                array(
                                                    'key'     => 'father_post_id',
                                                    'value'   => array($curso->ID),
                                                    'compare' => 'IN'
                                                ),
                                            )
                                        );


                                        $producto_related = new WP_Query($args_productos);
                                        if (!($producto_related->have_posts())) {
                                            continue;
                                        }
                                        while ($producto_related->have_posts()) : $producto_related->the_post();
                                            // $productID = $producto_related->posts[0]->ID;
                                            $productID = get_the_ID();
                                            $card_title = get_field('short_name', $curso->ID);
                                            $card_title = ($card_title) ? $card_title : get_the_title($curso->ID);
                                            $card_img_url = get_field('thumbnail', $curso->ID);
                                            $card_img_url = ($card_img_url) ? $card_img_url : '/wp-content/uploads/2018/11/287x192.png';
                                            $card_link = get_the_permalink($productID);

                                            $purchase_option = (get_field('purchase_option', $productID)) ? get_field('purchase_option', $productID) : get_field('purchase_option', $curso->ID);
                                            $card_ribbon = ($purchase_option == 'catalogo') ? true : false;

                                            $base_old_price = get_base_price($productID, get_installments());
                                            $base_price = get_base_sale_price($productID, get_installments());

                                            $card_precio = format_number(get_product_price_installments($productID, get_max_installments()));

                                            $card_duracion = get_field("duration", $curso->ID);

                                            $product_categories_array = wc_get_product_category_list($productID, '_', '', '');

                                            $product_categories = strip_tags(removeAccents(strtolower(str_replace('_', ' ', str_replace(' ', '-', $product_categories_array)))));

                                            $product_categories_clean = strip_tags(str_replace('_', ' ', $product_categories_array));

                                        endwhile;
                                        wp_reset_postdata();
                                        ?>

                    <div class="card" category="<?= $product_categories ?>">
                        <div class="card-img">
                            <picture>
                                <img src="<?= $card_img_url ?>" alt="imagen de la tarjeta del curso" loading="lazy"
                                    decoding="async">
                            </picture>
                            <a href="" class="tags tags-medicina">Medicina</a>
                        </div>
                        <div class="card-info">
                            <div class="card-info-sup">
                                <p class="area"><?= $product_categories_clean ?></p>
                                <span class="horas"><i class="mdi mdi-clock-outline"></i><?= $card_duracion ?>
                                    horas</span>
                            </div>
                            <div class="card-info-title"><?= $card_title ?></div>
                            <div class="card-info-footer">

                                <div class="card-info-footer-precio">
                                    <?php if ($card_ribbon || !$base_old_price) : ?>
                                    <p class="cuotas"><?= get_max_installments(); ?> <?= get_installments_string(); ?>
                                    </p>
                                    <p class="price">Sin interés</p>
                                    <?php else : ?>
                                    <p class="cuotas"><?= get_max_installments(); ?> <?= get_installments_string() ?> de
                                    </p>
                                    <p class="price"><?= get_currency_symbol(); ?><?= $card_precio ?></p>
                                    <?php endif; ?>

                                </div>
                                <a href="<?= $card_link ?>" class="card-info-footer-boton btn btn-mid">Descubrir</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;
                                } ?>


                </div>
            </article>
        </section>
        <?php foreach ($aval->mensajes_destacados as $mensaje_destacado) :
                if (!(strtotime('now') > strtotime($mensaje_destacado['fecha_desde']) && strtotime('-24 hours') < strtotime($mensaje_destacado['fecha_hasta']) + 1)) {
                    continue;
                } ?>
        <section id="promo" class="promo mx-auto">
            <article class="promo-cont contenedor mx-auto">
                <div class="promo-cont-list">
                    <ul>
                        <li class="promo-cont-item sombra"> <?= $mensaje_destacado['titulo'] ?></li>
                    </ul>
                </div>
            </article>
        </section>
        <?php endforeach; ?>

        <section id="cta-asesor" class="cta-asesor">
        <div id="anchor-form"></div>
            <article class="cta-asesor-cont contenedor mx-auto">
                <div class="cta-asesor-cont-info">
                    <div class="cta-asesor-cont-info-img"
                        style="background: center/cover url(<?= get_template_directory_uri() ?>/assets/media/asesor.png);">
                    </div>
                    <div>
                        <h4>Más de 50.000 profesionales <span class="salto-de-linea"> de toda Latinoamérica han</span>
                            elegido nuestro cursos.</h4>
                        <h5>¡Emprende tu viaje al conocimiento y únete a nuestra comunidad científica!</h5>
                    </div>
                </div>
            </article>
        </section>
    </section>

</div>
<?php endforeach; ?>

<section id="form-asesor" class="form-asesor formulario-3 contact__form__data"
    data-downloadable="<?= get_field('topics_file', $father_post_id); ?>"
    data-post-title="<?= get_the_title($father_post_id) ?>" data-pais="<?= ICL_LANGUAGE_CODE ?>">
    <article class="form-asesor-cont formulario-3-cont contenedor mx-auto">
        <?php
        $contact_form_id = 210577;
        echo  do_shortcode('[contact-form-7 html_class="formulario" id="' . $contact_form_id . '"]');
        ?>
    </article>
</section>

<section id="cta-ayuda" class="cta-ayuda">
    <article class="cta-ayuda-cont contenedor mx-auto">
        <div class="info">

            <img src="<?= get_template_directory_uri() ?>/assets/media/icon/phone-call 1.svg" alt="icono de telefono"
                loading="lazy" decoding="async">
            <div>
                <span><?= get_field('titulo', 'options') ?></span>
                <p><?= get_field('telefonocontacto', 'options') ?></p>
            </div>
        </div>
        <a href="<?= get_field('link', 'options')['url'] ?>" class="btn btn-mid btn-wpp boton cta-wpp"><i
                class="mdi mdi-whatsapp mr-2"></i><?= get_field('placeholder', 'options') ?></a>

    </article>
    <?php
    $aval_contador = 0;
    foreach ($lista_avales as $aval) :
    ?>
    <div id="aval-<?= $aval->ID ?>" class="avales-list">
        <article class="terminos-cont contenedor mx-auto">
            <h5>Términos y condiciones</h5>
            <!-- Terminos y condiciones -->
            <?php
                $terminos_conidiciones = get_field('bloque_de_terminos', 117889);
                $cont_terminos = 0;
                foreach ($terminos_conidiciones as $bloque) :
                    $showTerm = 0;
                    foreach ($bloque['avales'] as $aval) {
                        if ($ID == $aval->ID) {
                            $showTerm = 1;
                        }
                    }
                    if (!(strtotime('now') >= strtotime($bloque['fecha_desde']) && strtotime('now') <= strtotime($bloque['fecha_hasta'])) || $showTerm == 0) {
                        continue;
                    }

                    $cont_terminos++; ?>
            <div id="term-<?= $cont_terminos ?>" class="accordion">
                <a class="accordion-trigger <?= $cont_terminos == 1 ? 'active' : '' ?>">
                    <h6>
                        <?= $bloque['titulo'] ?>
                    </h6>
                    <i class="mdi mdi-menu-down"></i>
                </a>
                <div class="accordion-panel">
                    <?= $bloque['descripcion'] ?>
                </div>
            </div>
            <?php endforeach; ?>

        </article>
    </div>
    <?php endforeach; ?>
</section>



<!----Slider Avalaes---->


<?php get_footer(null, ['type_footer' => 'full']); ?>