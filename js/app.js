// Contact form init.
(function ($) {
	// Get the form.
	var form = $('#ajax-contact');

	// Get the messages div.
	var formMessages = $('#form-messages');

	// Set up an event listener for the contact form.
	$(form).submit(function(event) {
		// Stop the browser from submitting the form.
		event.preventDefault();

		// Serialize the form data.
		var formData = $(form).serialize();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})
		.done(function(response) {
			// Make sure that the formMessages div has the 'success' class.
			$(formMessages).removeClass('error');
			$(formMessages).addClass('success');

			// Set the message text.
			$(formMessages).text(response);

			// Clear the form.
			$('#name').val('');
			$('#email').val('');
			$('#message').val('');
		})
		.fail(function(data) {
			// Make sure that the form Messages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');

			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});
}(jQuery));

// Content tabs init.
(function ($) {
	$('#content-tabs a[href="#tab1"]').tab('show');
	$('#content-tabs a[href="#tab2"]').tab('show');
	$('#content-tabs a[href="#tab3"]').tab('show');
	$('#content-tabs a[href="#tab4"]').tab('show');
	$('#content-tabs a[href="#tab5"]').tab('show');

	$('#content-tabs a:first').tab('show');	// First tab icon setup
}(jQuery));


// Sidebar tabs init.
(function ($) {
	$('#sidebar-tabs a[href="#tab1"]').tab('show');
	$('#sidebar-tabs a[href="#tab2"]').tab('show');

	$('#sidebar-tabs a:first').tab('show');	// First tab icon setup
}(jQuery));

// Mobile menu init.
(function ($) {
	$("ul#nav").tinyNav({		  
	  header: 'Navigation', // String: Specify text for "header" and show header instead of the active item		  
	});
}(jQuery));

// Navbar init.
jQuery('#nav .sub-menu').each(function() {
	jQuery(this).prev('a').addClass('dropdown-toggle');
	jQuery(this).prev('a').attr('data-toggle', 'dropdown');
	jQuery(this).prev('a').append(' <i class="fa fa-chevron-down"></i>');
	jQuery(this).addClass('dropdown-menu');
});

// Mega menu fix.
jQuery(document).on('click', '.dropdown-menu', function(e) {
	 e.stopPropagation();
});

// Forms placeholders.
(function ($) {
	$('input[type=text], input[type=email], textarea').placeholder();
}(jQuery));
 
// Tooltips init.
jQuery(document).ready(function () {
	jQuery(".social-icons a").tooltip();
});

// Lightbox initialize.
jQuery(document).ready(function () {
	jQuery('[rel="lightbox"]').lightbox();
});

// Owl-carousel for gallery begin.
(function ($) {
 
	var sync1 = $("#sync1");
	var sync2 = $("#sync2");
	var md6sync2 = $(".col-md-6 #sync2");
	var md10sync2 = $(".col-md-10 #sync2");

	sync1.owlCarousel({
		singleItem : true,
		slideSpeed : 1000,
		navigation: true,
		navigationText : ["",""],
		pagination: true,
		afterAction : syncPosition,
		responsiveRefreshRate : 200,
	});
	 
	md10sync2.owlCarousel({
		items : 5,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3],
		itemsTablet : [768,3],
		itemsMobile : [407,2],
		pagination: false,
		responsiveRefreshRate : 100,
		afterInit : function(el){
		el.find(".owl-item").eq(0).addClass("synced");
	}
	});

	md6sync2.owlCarousel({
		items : 3,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3],
		itemsTablet : [768,3],
		itemsMobile : [407,2],
		pagination: false,
		responsiveRefreshRate : 100,
		afterInit : function(el){
		el.find(".owl-item").eq(0).addClass("synced");
	}
	});
	 
	function syncPosition(el){
		var current = this.currentItem;
		$("#sync2")
		.find(".owl-item")
		.removeClass("synced")
		.eq(current)
		.addClass("synced")
		if($("#sync2").data("owlCarousel") !== undefined){
			center(current)
		}
	}
	 
	$("#sync2").on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	});
	 
	function center(number){
	var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
	var num = number;
	var found = false;
	for(var i in sync2visible){
		if(num === sync2visible[i]){
			var found = true;
		}
	}
	 
	if(found===false){
		if(num>sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", num - sync2visible.length+2)
		}else{
			if(num - 1 === -1){
				num = 0;
			}
			sync2.trigger("owl.goTo", num);
		}
		} else if(num === sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", sync2visible[1])
		} else if(num === sync2visible[0]){
			sync2.trigger("owl.goTo", num-1)
		}
	}
 
}(jQuery));

// Owl carousel options for Related posts.
(function ($) {
	var md6owl = $(".col-md-6 #owl-related");
	var md10owl = $(".col-md-10 #owl-related");
	 
	md6owl.owlCarousel({
		items : 2,
		navigation : true, 
		navigationText : ["",""],
		pagination : false, 
		itemsDesktop : [1199,2],
		itemsDesktopSmall : [471,2]
	});

	md10owl.owlCarousel({
		items : 3,
		navigation : true, 
		navigationText : ["",""],
		pagination : false, 
		itemsDesktop : [1199,2],
		itemsDesktopSmall : [471,2]
	});
}(jQuery));

// Enable owl-carousel for Related posts.
(function ($) {
	$("#owl-related").owlCarousel();
}(jQuery));

// Add Masonry style for modern listing.
jQuery(window).load(function(){
	var $container = jQuery('#masonry');
	// initialize
	$container.masonry({
		itemSelector: '.masonry-loop'
	});
});

// Add specific functions and styling.
jQuery(document).ready(function(){
	jQuery('.author img').addClass('img-responsive');
	jQuery('.media-heading img').addClass('img-responsive img-circle');
	jQuery('#infinite-handle').addClass('col-md-12');
	jQuery('#infinite-handle span').addClass('btn btn-default load-more');
	jQuery('.post-content a').not("[class^='adv-'] a").has('img').addClass('lightbox');
	jQuery('.post-content a').not("[class^='adv-'] a").has('img').attr('rel', 'lightbox'); 
	jQuery('.post-content a').click(function () {
		var desc = jQuery(this).attr('title');
		jQuery('.post-content a').has('img').attr('title', desc, 'rel', 'lightbox' ); 
	});
	jQuery(".post-content a.lightbox").lightbox();
});

// Handle new items appended by infinite scroll.
jQuery(document).on('post-load', function() {
	setInterval( function() {
		jQuery('#infinite-handle').addClass('col-md-12');
		jQuery('#infinite-handle span').addClass('btn btn-default load-more');
	}, 300 );
});

// Triggers re-layout on infinite scroll.
jQuery(document).ready(function($){
	if($('#masonry').length > 0) {
		infinite_count = 0;
		$(document.body).on('post-load', function() {
			infinite_count = infinite_count + 1;
			var $container = $('#infinite-view-' + infinite_count);
			$container.masonry({
				itemSelector: '.masonry-loop'
			});
		});
	}
});