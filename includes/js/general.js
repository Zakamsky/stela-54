/*-----------------------------------------------------------------------------------*/
/* GENERAL SCRIPTS */
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function($){

	// Fix dropdowns in touch devices
	if ( jQuery( 'html' ).hasClass( 'touch' ) ) {
		//$( '.nav li:has(ul)' ).doubleTapToGo();
	}

	// Table alt row styling
	jQuery( '.entry table tr:odd' ).addClass( 'alt-table-row' );

	// FitVids - Responsive Videos
	jQuery( ".post, .widget, .panel" ).fitVids();

	// Add class to parent menu items with JS until WP does this natively
	jQuery("ul.sub-menu").parents('li').addClass('parent');


	// Responsive Navigation (switch top drop down for select)
	// jQuery('ul#top-nav').mobileMenu({
	// 	switchWidth: 767,                   //width (in px to switch at)
	// 	topOptionText: 'Выберите страницу',     //first option text
	// 	indentString: '&nbsp;&nbsp;&nbsp;'  //string for indenting nested items
	// });



  	// Show/hide the main navigation
  	jQuery('.nav-toggle').click(function() {
	  jQuery('#navigation').slideToggle('fast', function() {
	  	return false;
	    // Animation complete.
	  });
	});

	// Stop the navigation link moving to the anchor (Still need the anchor for semantic markup)
	jQuery('.nav-toggle a').click(function(e) {
        e.preventDefault();
    });

    // Add parent class to nav parents
	jQuery("ul.sub-menu, ul.children").parents().addClass('parent');


	/// ===== custom styles for mobile menu

	// submenu to menu:


	const colFull = document.querySelector('nav.col-full')
	const topNav = document.getElementById('top-nav')
	const navigation = document.getElementById('navigation')

	const footer = document.querySelector('.site-footer')
	const socialLinks = document.querySelector('.site-footer__social-links')

	const cartLink = document.querySelector('#wpmenucartli')
	const logo = document.querySelector('#logo')
	const mobHeader = document.querySelector('#header>hgroup')
	const mainNav = document.querySelector('#main-nav')
	console.log('### cartLink: ',cartLink);
	console.log('### mobHeader: ',mobHeader);
	console.log('### logo: ',logo);
	console.log('### wpmenucartli: ',wpmenucartli);


	const mobileMenuConstructor = function() {
		if (document.documentElement.clientWidth <= 767){
			navigation.appendChild(topNav)
			navigation.appendChild(socialLinks)
			navigation.style.display = 'none'
			mobHeader.prepend(logo, cartLink)
		} else {
			colFull.prepend(topNav)
			footer.appendChild(socialLinks)
			mainNav.appendChild(cartLink)
		}
	}

	mobileMenuConstructor()

	window.addEventListener('resize', function () {
		mobileMenuConstructor()
	} )

	//search button

	const searchToggle = document.querySelector('.search-toggle')
	const searchBar = document.querySelector('#top li.search')

	searchToggle.addEventListener('click', function () {
		searchBar.classList.toggle('--shown')
	})


});



