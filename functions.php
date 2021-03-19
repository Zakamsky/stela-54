<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php

/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// Define the theme-specific key to be sent to PressTrends.
define( 'WOO_PRESSTRENDS_THEMEKEY', 'zdmv5lp26tfbp7jcwiw51ix9sj389e712' );

// WooFramework init
require_once ( get_template_directory() . '/functions/admin-init.php' );

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

$includes = array(
				'includes/theme-options.php', 			// Options panel settings and custom settings
				'includes/theme-functions.php', 		// Custom theme functions
				'includes/theme-actions.php', 			// Theme actions & user defined hooks
				'includes/theme-comments.php', 			// Custom comments/pingback loop
				'includes/theme-js.php', 				// Load JavaScript via wp_enqueue_script
				'includes/sidebar-init.php', 			// Initialize widgetized areas
				'includes/theme-widgets.php',			// Theme widgets
				'includes/theme-install.php',			// Theme installation
				'includes/theme-woocommerce.php',		// WooCommerce options
				'includes/theme-plugin-integrations.php'	// Plugin integrations
				);

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );

foreach ( $includes as $i ) {
	locate_template( $i, true );
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/






add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {

 unset($tabs['reviews']);

 return $tabs;
}




add_action( 'init', 'wpm_product_cat_register_meta' );
/**
 * Register details product_cat meta.
 *
 * Register the details metabox for WooCommerce product categories.
 *
 */
function wpm_product_cat_register_meta() {

	register_meta( 'term', 'details', 'wpm_sanitize_details' );

}

/**
 * Sanitize the details custom meta field.
 *
 * @param  string $details The existing details field.
 * @return string          The sanitized details field
 */
function wpm_sanitize_details( $details ) {

	return wp_kses_post( $details );

}


add_action( 'product_cat_add_form_fields', 'wpm_product_cat_add_details_meta' );
/**
 * Add a details metabox to the Add New Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * creating new product categories in WooCommerce.
 *
 */
function wpm_product_cat_add_details_meta() {
	wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_details_nonce' );
	?>
	<div class="form-field">
		<label for="wpm-product-cat-details"><?php esc_html_e( 'SEO Title', 'wpm' ); ?></label>
		<input name="wpm-product-cat-details" id="wpm-product-cat-details" type="text" value="" size="40">
	</div>
	<?php
}



add_action( 'product_cat_edit_form_fields', 'wpm_product_cat_edit_details_meta' );
/**
 * Add a details metabox to the Edit Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * editing an existing product category in WooCommerce.
 *
 * @param  object $term The existing term object.
 */
function wpm_product_cat_edit_details_meta( $term ) {
	$product_cat_details = get_term_meta( $term->term_id, 'details', true );
	if ( ! $product_cat_details ) {
		$product_cat_details = '';
	}
	$settings = array( 'textarea_name' => 'wpm-product-cat-details' );
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="wpm-product-cat-details"><?php esc_html_e( 'SEO Title', 'wpm' ); ?></label></th>
		<td>
			<?php wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_details_nonce' ); ?>
			<input name="wpm-product-cat-details" id="wpm-product-cat-details" type="text" value="<?= wpm_sanitize_details( $product_cat_details ) ?>" size="40">
			<?php //wp_editor( wpm_sanitize_details( $product_cat_details ), 'product_cat_details', $settings ); ?>
		</td>
	</tr>
	<?php
}




add_action( 'create_product_cat', 'wpm_product_cat_details_meta_save' );
add_action( 'edit_product_cat', 'wpm_product_cat_details_meta_save' );
/**
 * Save Product Category details meta.
 *
 * Save the product_cat details meta POSTed from the
 * edit product_cat page or the add product_cat page.
 *
 * @param  int $term_id The term ID of the term to update.
 */
function wpm_product_cat_details_meta_save( $term_id ) {
	if ( ! isset( $_POST['wpm_product_cat_details_nonce'] ) || ! wp_verify_nonce( $_POST['wpm_product_cat_details_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	$old_details = get_term_meta( $term_id, 'details', true );
	$new_details = isset( $_POST['wpm-product-cat-details'] ) ? $_POST['wpm-product-cat-details'] : '';
	if ( $old_details && '' === $new_details ) {
		delete_term_meta( $term_id, 'details' );
	} else if ( $old_details !== $new_details ) {
		update_term_meta(
			$term_id,
			'details',
			wpm_sanitize_details( $new_details )
		);
	}
}


//add_action( 'woocommerce_after_shop_loop', 'wpm_product_cat_display_details_meta' );
/**
 * Display details meta on Product Category archives.
 *
 */
function wpm_product_cat_display_details_meta() {
	if ( ! is_tax( 'product_cat' ) ) {
		return;
	}
	$t_id = get_queried_object()->term_id;
	$details = get_term_meta( $t_id, 'details', true );
	if ( '' !== $details ) {
		?>
		<div class="product-cat-details">
			<?php echo apply_filters( 'the_content', wp_kses_post( $details ) ); ?>
		</div>
		<?php
	}
}































add_action( 'product_cat_add_form_fields', 'wpm_product_cat_add_h1_meta' );
/**
 * Add a details metabox to the Add New Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * creating new product categories in WooCommerce.
 *
 */
function wpm_product_cat_add_h1_meta() {
	wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_h1_nonce' );
	?>
	<div class="form-field">
		<label for="wpm-product-cat-h1"><?php esc_html_e( 'H1 Title', 'wpm' ); ?></label>
		<input name="wpm-product-cat-h1" id="wpm-product-cat-h1" type="text" value="" size="40">
	</div>
	<?php
}



add_action( 'product_cat_edit_form_fields', 'wpm_product_cat_edit_h1_meta' );
/**
 * Add a details metabox to the Edit Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * editing an existing product category in WooCommerce.
 *
 * @param  object $term The existing term object.
 */
function wpm_product_cat_edit_h1_meta( $term ) {
	$product_cat_h1 = get_term_meta( $term->term_id, 'h1', true );
	if ( ! $product_cat_h1 ) {
		$product_cat_h1 = '';
	}
	$settings = array( 'textarea_name' => 'wpm-product-cat-h1' );
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="wpm-product-cat-h1"><?php esc_html_e( 'H1 Title', 'wpm' ); ?></label></th>
		<td>
			<?php wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_h1_nonce' ); ?>
			<input name="wpm-product-cat-h1" id="wpm-product-cat-h1" type="text" value="<?= wpm_sanitize_details( $product_cat_h1 ) ?>" size="40">
			<?php //wp_editor( wpm_sanitize_details( $product_cat_details ), 'product_cat_details', $settings ); ?>
		</td>
	</tr>
	<?php
}




add_action( 'create_product_cat', 'wpm_product_cat_h1_meta_save' );
add_action( 'edit_product_cat', 'wpm_product_cat_h1_meta_save' );
/**
 * Save Product Category details meta.
 *
 * Save the product_cat details meta POSTed from the
 * edit product_cat page or the add product_cat page.
 *
 * @param  int $term_id The term ID of the term to update.
 */
function wpm_product_cat_h1_meta_save( $term_id ) {
	if ( ! isset( $_POST['wpm_product_cat_h1_nonce'] ) || ! wp_verify_nonce( $_POST['wpm_product_cat_h1_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	$old_h1 = get_term_meta( $term_id, 'h1', true );
	$new_h1 = isset( $_POST['wpm-product-cat-h1'] ) ? $_POST['wpm-product-cat-h1'] : '';
	if ( $old_h1 && '' === $new_h1 ) {
		delete_term_meta( $term_id, 'h1' );
	} else if ( $old_h1 !== $new_h1 ) {
		update_term_meta(
			$term_id,
			'h1',
			wpm_sanitize_details( $new_h1 )
		);
	}
}


//add_action( 'woocommerce_after_shop_loop', 'wpm_product_cat_display_h2_meta' );
/**
 * Display details meta on Product Category archives.
 *
 */
function wpm_product_cat_display_h1_meta() {
	if ( ! is_tax( 'product_cat' ) ) {
		return;
	}
	$t_id = get_queried_object()->term_id;
	$details = get_term_meta( $t_id, 'h1', true );
	if ( '' !== $details ) {
		?>
		<div class="product-cat-details">
			<?php echo apply_filters( 'the_content', wp_kses_post( $details ) ); ?>
		</div>
		<?php
	}
}





















add_action( 'product_cat_add_form_fields', 'wpm_product_cat_add_h2_meta' );
/**
 * Add a details metabox to the Add New Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * creating new product categories in WooCommerce.
 *
 */
function wpm_product_cat_add_h2_meta() {
	wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_h2_nonce' );
	?>
	<div class="form-field">
		<label for="wpm-product-cat-h2"><?php esc_html_e( 'H2 Title', 'wpm' ); ?></label>
		<input name="wpm-product-cat-h2" id="wpm-product-cat-h2" type="text" value="" size="40">
	</div>
	<?php
}



add_action( 'product_cat_edit_form_fields', 'wpm_product_cat_edit_h2_meta' );
/**
 * Add a details metabox to the Edit Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * editing an existing product category in WooCommerce.
 *
 * @param  object $term The existing term object.
 */
function wpm_product_cat_edit_h2_meta( $term ) {
	$product_cat_h2 = get_term_meta( $term->term_id, 'h2', true );
	if ( ! $product_cat_h2 ) {
		$product_cat_h2 = '';
	}
	$settings = array( 'textarea_name' => 'wpm-product-cat-h2' );
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="wpm-product-cat-h2"><?php esc_html_e( 'H2 Title', 'wpm' ); ?></label></th>
		<td>
			<?php wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_h2_nonce' ); ?>
			<input name="wpm-product-cat-h2" id="wpm-product-cat-h2" type="text" value="<?= wpm_sanitize_details( $product_cat_h2 ) ?>" size="40">
			<?php //wp_editor( wpm_sanitize_details( $product_cat_details ), 'product_cat_details', $settings ); ?>
		</td>
	</tr>
	<?php
}




add_action( 'create_product_cat', 'wpm_product_cat_h2_meta_save' );
add_action( 'edit_product_cat', 'wpm_product_cat_h2_meta_save' );
/**
 * Save Product Category details meta.
 *
 * Save the product_cat details meta POSTed from the
 * edit product_cat page or the add product_cat page.
 *
 * @param  int $term_id The term ID of the term to update.
 */
function wpm_product_cat_h2_meta_save( $term_id ) {
	if ( ! isset( $_POST['wpm_product_cat_h2_nonce'] ) || ! wp_verify_nonce( $_POST['wpm_product_cat_h2_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	$old_h2 = get_term_meta( $term_id, 'h2', true );
	$new_h2 = isset( $_POST['wpm-product-cat-h2'] ) ? $_POST['wpm-product-cat-h2'] : '';
	if ( $old_h2 && '' === $new_h2 ) {
		delete_term_meta( $term_id, 'h2' );
	} else if ( $old_h2 !== $new_h2 ) {
		update_term_meta(
			$term_id,
			'h2',
			wpm_sanitize_details( $new_h2 )
		);
	}
}


//add_action( 'woocommerce_after_shop_loop', 'wpm_product_cat_display_h2_meta' );
/**
 * Display details meta on Product Category archives.
 *
 */
function wpm_product_cat_display_h2_meta() {
	if ( ! is_tax( 'product_cat' ) ) {
		return;
	}
	$t_id = get_queried_object()->term_id;
	$details = get_term_meta( $t_id, 'h2', true );
	if ( '' !== $details ) {
		?>
		<div class="product-cat-details">
			<?php echo apply_filters( 'the_content', wp_kses_post( $details ) ); ?>
		</div>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>
