jQuery( document ).ready( function( $ ) {

	var $menu = $('#menu'),
	  $menulink = $('.menu-link'),
	  $menuTrigger = $('.has-submenu > a');

	$menulink.click(function(e) {
		e.preventDefault();
		$menulink.toggleClass('active');
		$menu.toggleClass('active');
	});

	$menuTrigger.click(function(e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active').next('ul').toggleClass('active');
	});
  $('#nav-icon1').click(function(){
  $(this).toggleClass('open');
	// $('.menu_links_wrap').css("display","block");

  });
	$( ".open" ).click(function() {
});

	// Configure/customize these variables.
var showChar = 100;  // How many characters are shown by default
var ellipsestext = "...";
var moretext = "Show more >";
var lesstext = "Show less";


$('.more').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

				var c = content.substr(0, showChar);
				var h = content.substr(showChar, content.length - showChar);

				var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

				$(this).html(html);
		}

});

$(".morelink").click(function(){
		if($(this).hasClass("less")) {
				$(this).removeClass("less");
				$(this).html(moretext);
		} else {
				$(this).addClass("less");
				$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
});


$('.slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: false,
  autoplaySpeed: 2000,
	arrows:false
});

});
