 $(function () {
	initNewsCarousel(); // init Slick Slider for news detail view
	// Actions after open categories button is clicked
	$('#dropdownMenuButton1').on('show.bs.dropdown', function () {
		
	})
	// Actions after open offcanvas animation's ends
	$('#offcanvasWithBackdrop').on('shown.bs.offcanvas', function () {
		$('#menu li').each(function(i, li) {
			$(li).delay(25*i).animate({opacity:1}, 250);
		});
	});
	// Actions after close offcanvas animation's ends
	$('#offcanvasWithBackdrop').on('hidden.bs.offcanvas', function () {
		$('#menu li').each(function(i, li) {
			$(li).css({'opacity':'0'});
		});
	});
	$('#header-video').get(0).play();
});
$(document).ready(function(){
	if( $('#tx-indexedsearch-searchbox-sword').length > 0 )
	{
		$('#tx-indexedsearch-searchbox-sword').focus();
	}
});
$(document).scroll(function() {
	if($(document).scrollTop() > 220){
		//$('.header').addClass('position-fixed');
		$('.main-header').addClass('nav-sticky',200);
	}
	if(window.scrollY==0){
		$('.main-header').removeClass('nav-sticky',200);
		//$('.header').removeAttr("style")
	}
});
$('.rgaccord1-nest').each(function(){
    //alert($('.fill', $(this)).width());
    var rgaccord1toggle = $('.rgaccord1-toggle', $(this));
    var toogleicon = $('.toogle-icon', $(this));
    var itemWidth = rgaccord1toggle.width();
    
    var toogleiconWidth = toogleicon.width();
    
    var offset1 = rgaccord1toggle.offset().left;
    var offset2 = toogleicon.offset().left;
    var fillerWidth = (offset2 - offset1) - (itemWidth + toogleiconWidth);
    
    $('.dotted-line', $(this)).css('width', fillerWidth + 10);
});
// Slick Slider
function initNewsCarousel(){
	$('.news-slider .items').slick({
		centerMode: true,
		arrows:true,
		variableWidth: true
	});

	initSliderCaptions($('.news-slider-wrapper'));
}
function initSliderCaptions(slider){
	// show only current caption
	handleSliderCaption(slider)

	addConstrolListenerToSlider(slider);
}
function addConstrolListenerToSlider(slider){
	// call handle caption for .slick-prev & .slick-next
	$(slider).find('.slick-slider').first().find(".slick-next").first().click(function(){
		handleSliderCaption('.news-slider-wrapper');
	});
	$(slider).find('.slick-slider').first().find(".slick-prev").first().click(function(){
		handleSliderCaption('.news-slider-wrapper');
	});
}
function handleSliderCaption(slider){
	var idx = getIndexOfActiveSlide(slider);
	// hide all captions
	$(slider).find('.news-slider-captions').find('.caption').each(function(){
		$(this).css("display", "none");
		//$(this).show(1000);
	});
	// show caption of current slide
	$('.caption[data-slider-item-index='+idx+']').each(function(){
		$(this).css("display", "block");
		$(this).css("opacity", "0.0");
		$(this).fadeTo(700, 1.0 );
	});
}
function getIndexOfActiveSlide(slider){
	return $(slider).find('.slick-slider').first().find('.slick-center').first().data('slider-item-index');
}
