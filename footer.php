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
						<a href="https://vk.com/club123664087"><img src="https://stela-54.ru/wp-content/uploads/2021/02/brand_vk_icon_158634.png"></a> 
						<a href="https://www.facebook.com/%D0%93%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D0%BD%D0%B0%D1%8F-%D0%BC%D0%B0%D1%81%D1%82%D0%B5%D1%80%D1%81%D0%BA%D0%B0%D1%8F-%D0%A1%D1%82%D0%B5%D0%BB%D0%B0-1714422825476518/?ref=bookmarks"><img src="http://stela-54.ru/wp-content/uploads/2021/02/Facebook_icon-icons.com_559141.png"></a>
						<a href="https://www.instagram.com/stelansk54"><img src="http://stela-54.ru/wp-content/uploads/2021/02/Instagram_icon-icons.com_55882.png"></a>
					    <a href="https://plus.google.com/+Stela54Runsk/about"><img src="http://stela-54.ru/wp-content/uploads/2021/02/social_media_google_plus_logo_icon_141106.png"></a>
					 
				</div>
				</div>
				<p><img src="https://stela-54.ru/wp-content/uploads/2016/06/stella-255.png"></p>
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