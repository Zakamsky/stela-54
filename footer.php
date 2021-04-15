<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Footer Template
 *
 * Here we setup all logic and XHTML that is required for the footer section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */
	global $woo_options;
	
	echo '<div class="footer-wrap">';

	$total = 4;
	if ( isset( $woo_options['woo_footer_sidebars'] ) && ( $woo_options['woo_footer_sidebars'] != '' ) ) {
		$total = $woo_options['woo_footer_sidebars'];
	}

	if ( ( woo_active_sidebar( 'footer-1' ) ||
		   woo_active_sidebar( 'footer-2' ) ||
		   woo_active_sidebar( 'footer-3' ) ||
		   woo_active_sidebar( 'footer-4' ) ) && $total > 0 ) {

?>
	<?php woo_footer_before(); ?>
	
		<section id="footer-widgets" class="col-full col-<?php echo $total; ?> fix">
	
			<?php $i = 0; while ( $i < $total ) { $i++; ?>
				<?php if ( woo_active_sidebar( 'footer-' . $i ) ) { ?>
	
			<div class="block footer-widget-<?php echo $i; ?>">
				<?php woo_sidebar( 'footer-' . $i ); ?>
			</div>
	
				<?php } ?>
			<?php } // End WHILE Loop ?>
	
		</section><!-- /#footer-widgets  -->
	<?php } // End IF Statement ?>
		<footer id="footer" class="col-full">
				<div class="site-footer">
					<div class="site-footer__call">
						<h4>Закажите обратный звонок!</h4>
						<a id="myButton" data-fancybox data-src="#contact_form_pop" href="#contact_form_pop" class="fancybox-inline button callback-btn">Заказать звонок</a>
						<div style="display:none" class="fancybox-hidden">
							<div id="contact_form_pop">
								<?php echo do_shortcode('[contact-form-7 id="1218"]'); ?>
							</div>
						</div>
					</div>
					<div class="site-footer__social-links">
						</br>
						<h4>Мы в соц. сетях:</h4>
                        <div class="social">
                            <a href="https://vk.com/club123664087" class="social__link" rel="nofollow noopener">
                                <img src="<?= get_template_directory_uri() ?>/images/icons/vk.svg" width="40">
                            </a>
                            <a href="https://ok.ru/profile/579666086476" class="social__link" rel="nofollow noopener">
                                <img src="<?= get_template_directory_uri() ?>/images/icons/ok.svg" width="40">
                            </a>
                            <a href="https://www.instagram.com/stelansk54" class="social__link" rel="nofollow noopener">
                                <img src="<?= get_template_directory_uri() ?>/images/icons/instagram.svg" width="40">
                            </a>
                        </div>
				</div>
				</div>
				<div class="site-footer__logo">
                    <a class="logo" id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( get_bloginfo( 'description' ) ); ?>">
                        <span class="logo__title">Стела</span>
                        <span class="logo__description">Гранитная мастерская</span>
                    </a>
<!--                    <img src="https://stela-54.ru/wp-content/uploads/2016/06/stella-255.png">-->
                </div>
				<p>
					<b>Адреса:</b> <br/> г. Новосибирск, ул. Мочищенское шоссе, 5/17,</br>
					г. Новосибирск, ул. Новоуральская, 121,</br>
					г. Новосибирск, ул. Новоуральская, 124, корп.1</br>
					<b>Тел.:</b> <a href="tel:+79137508333">+7 (913) 750-83-33</a></br>
					<b>E-mail:</b> <a href="mailto:stela-54@yandex.ru">stela-54@yandex.ru</a>
				</p>

				<div id="copyright" class="col-left"></div>
    <?php if( isset( $woo_options['woo_footer_left'] ) && $woo_options['woo_footer_left'] == 'true' ) {
      
              echo stripslashes( $woo_options['woo_footer_left_text'] );
      
          } else { ?>
            <p><?php bloginfo(); ?> | &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'Все права защищены.', 'woothemes' ); ?></p> <?php } ?>
  
    </div>
    <div id="credit" class="col-right">
          <?php if( isset( $woo_options['woo_footer_right'] ) && $woo_options['woo_footer_right'] == 'true' ) {
  
            echo stripslashes( $woo_options['woo_footer_right_text'] );
  
      } else { ?>
      
      <?php } ?>
      </div>
            
    </footer>
	
	</div><!-- / footer-wrap -->

</div><!-- /#wrapper -->
<?php wp_footer(); ?>
<?php woo_foot(); ?>
</body>
</html>