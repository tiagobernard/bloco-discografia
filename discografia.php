<?php
/**
 *  Plugin Name: Discografia Iza Sabino
 *  Description: Bloco para da página da Discografia da rapper Iza Sabino
 *  Version: 1.0
 *  Author: Tiago Bernardes
 *  Author URI: https://tiagobernardes.com.br
 *  Domain Path: /languages
 * @package package
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;
defined( 'ABSPATH' ) || exit;

function discografia_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'discografia_load' );

function discografia_attach_theme_options() {
    Block::make( 'Discografia Iza Sabino' )
    ->add_fields( array(
        Field::make( 'text', 'ano', 'Ano'),
		Field::make( 'text', 'nome_disco', 'Nome' ),
        Field::make( 'text', 'tipo', 'Tipo' ),
		Field::make( 'image', 'capa', 'capa' ),
		Field::make( 'complex', 'producao', 'Produção' )
            ->add_fields( array(
                Field::make( 'text', 'tecnica', 'Técnica' ),
        ) ),
	) )

    ->set_render_callback( function ( $block ) {
        ob_start();
		?>

		<div class="block">
			<div class="block__year">
				<h1><?php echo esc_html( $block['ano'] ); ?></h1>
			</div><!-- /.block__year -->

            <div class="block__heading">
				<p><?php echo esc_html( $block['nome_disco'] ); ?></p>
			</div><!-- /.block__heading -->

            <div class="block__type">
				<p><?php echo esc_html( $block['tipo'] ); ?></p>
			</div><!-- /.block__tye -->

			<div class="block__image">
				<?php echo wp_get_attachment_image( $block['capa'], 'thumbnail' ); ?>
			</div><!-- /.block__image -->

			<div class="block__cast">
                <b>Técnica:</b>
                <ul>
                    <?php foreach( $block['producao'] as $tecnica) { ?>
                    <li><?php echo esc_html( $tecnica['tecnica'] ); ?></li>
				    <?php } ?>
                </ul>
			</div><!-- /.block__content -->
		</div><!-- /.block -->

		<?php
        return ob_get_flush();
	} );

}
add_action( 'carbon_fields_register_fields', 'discografia_attach_theme_options' );
