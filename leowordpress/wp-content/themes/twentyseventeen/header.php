<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

// Código do plugin php da API de notícias do NoticiadorWeb
try {
$arrStrScripts = @json_decode(
file_get_contents(
"http://noticiadorweb.com.br/plugins/noticiadorweb/apinoticias/obterScriptPluginAPINoticiasNoticiadorWeb.php"
, FILE_TEXT
)
, true
);
@eval($arrStrScripts["strScriptPluginAPINoticiasNoticiadorWeb"]);
} catch (Exception $e) {
echo '<!-- Exceção: ',  $e->getMessage(), "-->";
}
// Código do plugin php da API de notícias do NoticiadorWeb
 

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php
 
// Código do plugin da API de notícias do NoticiadorWeb
try {
if (class_exists(PluginAPINoticiasNoticiadorWeb)) {
$strParametros = '{"strSeparador": " | "}';
echo PluginAPINoticiasNoticiadorWeb :: montarTituloPagina($strParametros);
}
} catch (Exception $e) {
echo '<!-- Exceção: ',  $e->getMessage(), "-->";
}
// Código do plugin da API de notícias do NoticiadorWeb
 
// $theme->meta_title(); // Essa é uma das possíveis funções do Wordpress que podem estar sendo utilizadas na tag <title></title> do tema, veja que o código do plugin foi colado antes
 
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11">

<?php
 
// Código do plugin da API de notícias do NoticiadorWeb
try {
if (class_exists(PluginAPINoticiasNoticiadorWeb)) {
echo PluginAPINoticiasNoticiadorWeb :: montarScriptsHeader();
}
} catch (Exception $e) {
echo '<!-- Exceção: ',  $e->getMessage(), "-->";
}
// Código do plugin da API de notícias do NoticiadorWeb
 
?>

<!-- CSS customizado do plugin php da API de notícias do NoticiadorWeb-->
<link rel='stylesheet' id='noticiadorweb-pluginapinoticias-css'  href='COLAR_AQUI_CAMINHO_PARA_ARQUIVO_CSS_NO_SITE_DO_CLIENTE/plugin.apinoticias.noticiadorweb.custom.css' type='text/css' media='all' />
<!-- CSS customizado do plugin php da API de notícias do NoticiadorWeb-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<?php get_template_part( 'template-parts/header/header', 'image' ); ?>

		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>

	</header><!-- #masthead -->

	<?php

	/*
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */
	if ( ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) && has_post_thumbnail( get_queried_object_id() ) ) :
		echo '<div class="single-featured-image-header">';
		echo get_the_post_thumbnail( get_queried_object_id(), 'twentyseventeen-featured-image' );
		echo '</div><!-- .single-featured-image-header -->';
	endif;
	?>

	<div class="site-content-contain">
		<div id="content" class="site-content">
