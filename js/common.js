$(function() {

	// Окрашивание двух букв по правилам SEO-оптимизации
	$('.logo-litera').each(function() {
		var ths = $(this);
		ths.html(ths.html().replace('SS', '<span>SS</span>'));
	});

	// Открытие строки поиска по щелчку
	$('.search').click(function() {
		$('.search-field').stop().slideToggle();
		
		// Фокус на текст
		$('.search-field input[type=text]').focus();
	});

	// Закрытие строки поиска Esc и по нажатию по пустой области
	$(document).keyup(function(e) {
		if(e.keyCode == 27) {
			$('.search-field').slideUp();
		}
	}).click(function() {
		$('.search-field').slideUp();
	});
	$('.search-wrap').click(function(e) {
		e.stopPropagation();
	});

	// Раскрытие бургера
	$('.top-line').after('<div class="mobile-menu d-lg-none">');
	$('.top-menu').clone().appendTo('.mobile-menu');
	$('.mobile-menu-button').click(function() {
		$('.mobile-menu').stop().slideToggle();
	});

	//обработчик для col-item
	$('.col-item').hover(function() {
		ths = $(this);
		lnk = ths.closest('.col-item').find('h4 a');
		lnk.addClass('hover');
	}, function() {
		lnk.removeClass('hover');
	});

	$("body").prognroll({
		height: 3,
		color: "#ec1c1c",
		custom: false
	});

	// active-menu
	$('.main-menu li').removeClass('active');
	var path = window.location.pathname;
	$('.main-menu li a').each(function() {
		var href = $(this).attr('href');
		if(path.slice(1).substring(0, href.length) === href) {
			$(this).parent('li').addClass('active');
		}
	});
});
