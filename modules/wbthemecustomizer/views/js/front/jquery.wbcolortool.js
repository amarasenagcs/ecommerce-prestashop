/*
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2018 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$(document).ready(function() {

    function add_backgroundcolor(bgcolor) {
    $('<style type="text/css">#search_filters .facet li:hover .custom-checkbox input[type="checkbox"] + span, #search_filters .facet li .active .custom-checkbox input[type="checkbox"] + span,.quickview .arrows .arrow-up:hover, .quickview .arrows .arrow-down:hover, .products-sort-order .select-title,.custom-radio input[type=radio]:checked+span,body::-webkit-scrollbar-thumb{ background-color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.owl-theme .owl-dots .owl-dot.active span, #testi.owl-theme .owl-dots .owl-dot:hover span,.products-sort-order .select-title,.container_wb_megamenu .title-menu,.wb-wishlist-product .add-cart button,#product_comparison .btn-product.add-to-cart,.bootstrap-touchspin .group-span-filestyle .btn-touchspin, .group-span-filestyle .bootstrap-touchspin .btn-touchspin, .group-span-filestyle .btn-default,button.usefulness_btn:hover,.pagination .page-list li a,.block-social li,.block_newsletter form input[type="submit"]:hover,.post_meta,.owl-theme .owl-nav [class*="owl-"]:hover,.button-group .quick:hover, .button-group .wish:hover, .button-group .wb-compare-button:hover, .cartb:hover, .button-group .quick:focus, .button-group .wish:focus, .button-group .wb-compare-button:focus, .cartb:focus,#search_block_top .btn.button-search:hover, #search_block_top .btn.button-search:focus,.btn-primary, .btn-secondary, .btn-tertiary, .btn-info,.blockcart .cart-c{ background:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css"> .wb-modal-wishlist .modal-title a strong, .wb-modal-compare .modal-title a strong,.star.star_on::after,.star::after,.content_test span,.statm .statm-left li a:hover,.dropdown-item.well strong,.page-my-account #content .links a:hover,.page-my-account #content .links a:hover i,.product-line-grid-body>.product-line-info>.label.pro-name,.facet-title,.wb-menu-vertical ul li.level-1:hover > a, .view_more a:hover,.wb-compare-wishlist-button .wish:hover span, .wb-compare-wishlist-button .wish:focus span, .wb-compare-wishlist-button .wb-compare-button:hover span, .wb-compare-wishlist-button .wb-compare-button:focus span,#blockcart-modal .product-name,.propage h1,.footer-container li a:hover, .fthr .block:hover, .fthr .data a:hover, #footer .lnk_wishlist:hover, .foot-link a:hover,.product-title a:hover, .product-title:hover,.regular-price,.sale,.pro-tab.tabs .nav-tabs .nav-link.active,.cate-img:hover .cate-n,a:hover, a:focus,#wbsearch_data .items-list li .content_price .price,.user-info:hover, .blockcart:hover, .user-info:hover .shop-c, .blockcart:hover .shop-c, .user-down li a:hover, .user-down li a:hover span, .blockcart:hover svg,#_desktop_currency_selector button:hover, #_desktop_language_selector button:hover, .wimg:hover,.btn-unstyle:focus .expand-more{ color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css"> .thumbnail-container .sale::before,.user-down,.wb-menu-vertical .menu-dropdown,.header-nav .dropdown-menu,.wb-dropdown-cart-content{ border-top-color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css"> .thumbnail-container .sale::before{ border-bottom-color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.form-control:focus,.owl-theme .owl-dots .owl-dot.active span, #testi.owl-theme .owl-dots .owl-dot:hover span,.testi1, .testi2, .testi3,.wbpc-main .time:hover .count,#search_filters .facet li:hover .custom-checkbox input[type="checkbox"] + span, #search_filters .facet li .active .custom-checkbox input[type="checkbox"] + span,.blog_mask .icon,.nivo-controlNav a.active { border-color:#' + bgcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.wb-compare-wishlist-button .wish:hover svg, .wb-compare-wishlist-button .wish:focus svg, .wb-compare-wishlist-button .wb-compare-button:hover svg, .wb-compare-wishlist-button .wb-compare-button:focus svg,.wb-compare-button.added svg, .wb-wishlist-button.added svg,.user-info:hover, .blockcart:hover, .user-info:hover .shop-c, .blockcart:hover .shop-c, .user-down li a:hover, .user-down li a:hover span, .blockcart:hover svg { fill:#' + bgcolor + '}</style>').appendTo('head');
	    
	  
    }
    function add_hovercolor(hcolor) {
	/*$('<style type="text/css">#search_filters .facet li:hover .custom-checkbox input[type="checkbox"] + span, #search_filters .facet li .active .custom-checkbox input[type="checkbox"] + span,.blog_mask .icon:hover,.nivo-controlNav a.active { background-color:#' + hcolor + '}</style>').appendTo('head');
	$('<style type="text/css">{ background:#' + hcolor + '}</style>').appendTo('head');
	$('<style type="text/css">.page-my-account #content .links a:hover,.page-my-account #content .links a:hover i,.wb-compare-wishlist-button .wish:hover span, .wb-compare-wishlist-button .wish:focus span, .wb-compare-wishlist-button .wb-compare-button:hover span, .wb-compare-wishlist-button .wb-compare-button:focus span,#wbsearch_data .items-list li .content_price .price,.user-down li a:hover,#_desktop_currency_selector button:hover, #_desktop_currency_selector button:focus, #_desktop_language_selector button:hover, #_desktop_language_selector button:focus,a:hover, a:focus,.wb-menu-vertical ul li.level-1:hover > a, .view_more a:hover{ color:#' + hcolor + '}</style>').appendTo('head');
	$('<style type="text/css"> .wb-compare-wishlist-button .wish:hover svg, .wb-compare-wishlist-button .wish:focus svg, .wb-compare-wishlist-button .wb-compare-button:hover svg, .wb-compare-wishlist-button .wb-compare-button:focus svg,.wb-compare-button.added svg, .wb-wishlist-button.added svg,.user-down li a:hover{ fill:#' + hcolor + '}</style>').appendTo('head');

	$('<style type="text/css">#search_filters .facet li:hover .custom-checkbox input[type="checkbox"] + span, #search_filters .facet li .active .custom-checkbox input[type="checkbox"] + span,.blog_mask .icon:hover, .nivo-controlNav a.active,.blog_mask .icon{ border-color:#' + hcolor + '}</style>').appendTo('head');
        $('<style type="text/css"> { border-right-color:#' + hcolor + '}</style>').appendTo('head');
        $('<style type="text/css">{ border-bottom-color:#' + hcolor + '}</style>').appendTo('head');
        $('<style type="text/css"> .wb-dropdown-cart-content,.dropdown-menu,.wb-menu-vertical .menu-dropdown{ border-top-color:#' + hcolor + '}</style>').appendTo('head');*/
    }
    
    $('.control').click(function() {

	if ($(this).hasClass('inactive')) {
	    $(this).removeClass('inactive');
	    $(this).addClass('active');
	    if (LANG_RTL == '1') {
		$('.wb-demo-wrap').animate({left: '0'}, 500);
	    } else {
		$('.wb-demo-wrap').animate({right: '0'}, 500);
	    }
	    $('.wb-demo-wrap').css({'box-shadow': '0 0 10px #adadad', 'background': '#fff'});
	    $('.wb-demo-option').animate({'opacity': '1'}, 500);
	    $('.wb-demo-title').animate({'opacity': '1'}, 500);
	} else {
	    $(this).removeClass('active');
	    $(this).addClass('inactive');
	    if (LANG_RTL == '1') {
		$('.wb-demo-wrap').animate({left: '-200px'}, 500);
	    } else {
		$('.wb-demo-wrap').animate({right: '-200px'}, 500);
	    }
	    $('.wb-demo-wrap').css({'box-shadow': 'none', 'background': 'transparent'});
	    $('.wb-demo-option').animate({'opacity': '0'}, 500);
	    $('.wb-demo-title').animate({'opacity': '0'}, 500);
	}
    });
    $('#backgroundColor, #hoverColor').each(function() {
	var $el = $(this);
	/* set time */var date = new Date();
	date.setTime(date.getTime() + (1440 * 60 * 1000));
	$el.ColorPicker({color: '#555555', onChange: function(hsb, hex, rgb) {
		$el.find('div').css('backgroundColor', '#' + hex);
		switch ($el.attr("id")) {
		    case 'backgroundColor' :
			add_backgroundcolor(hex);
			$.cookie('background_color_cookie', hex, {expires: date});
			break;
		    case 'hoverColor' :
			add_hovercolor(hex);
			$.cookie('hover_color_cookie', hex, {expires: date});
			break;
		    }
	    }});
    });
    /* set time */var date = new Date();
    date.setTime(date.getTime() + (1440 * 60 * 1000));
    if ($.cookie('background_color_cookie') && $.cookie('hover_color_cookie')) {
	add_backgroundcolor($.cookie('background_color_cookie'));
	add_hovercolor($.cookie('hover_color_cookie'));
	var backgr = "#" + $.cookie('background_color_cookie');
	var activegr = "#" + $.cookie('hover_color_cookie');
	$('#backgroundColor div').css({'background-color': backgr});
	$('#hoverColor div').css({'background-color': activegr});
    }
    /*Theme mode layout*/
    if (!$.cookie('mode_css') && WB_mainLayout == "boxed"){
	$('input[name=mode_css][value=box]').attr("checked", true);
    } else if (!$.cookie('mode_css') && WB_mainLayout == "fullwidth") {
	$('input[name=mode_css][value=wide]').attr("checked", true);
    } else if ($.cookie('mode_css') == "boxed") {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('boxed');
	$.cookie('mode_css', 'boxed');
	$.cookie('mode_css_input', 'box');
	$('input[name=mode_css][value=box]').attr("checked", true);
    } else if ($.cookie('mode_css') == "fullwidth") {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('fullwidth');
	$.cookie('mode_css', 'fullwidth');
	$.cookie('mode_css_input', 'wide');
	$('input[name=mode_css][value=wide]').attr("checked", true);
    }
    $('input[name=mode_css][value=box]').click(function() {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('boxed');
	$.cookie('mode_css', 'boxed');
        fullwidth_click();
    });
    $('input[name=mode_css][value=wide]').click(function() {
	$('body').removeClass('fullwidth');
	$('body').removeClass('boxed');
	$('body').addClass('fullwidth');
	$.cookie('mode_css', 'fullwidth');
        fullwidth_click();
    });
    $('.cl-td-layout a').click(function() {
	var id_color = this.id;
	$.cookie('background_color_cookie', id_color.substring(0, 6));
	$.cookie('hover_color_cookie', id_color.substring(7, 13));
	add_backgroundcolor($.cookie('background_color_cookie'));
	add_hovercolor($.cookie('hover_color_cookie'));
	var backgr = "#" + $.cookie('background_color_cookie');
	var activegr = "#" + $.cookie('hover_color_cookie');
	$('#backgroundColor div').css({'background-color': backgr});
	$('#hoverColor div').css({'background-color': activegr});
    });
    /*reset button*/$('.cl-reset').click(function() {
	/* Color */$.cookie('background_color_cookie', '');
	$.cookie('hover_color_cookie', '');
	/* Mode layout */$.cookie('mode_css', '');
	location.reload();
    });
    function fullwidth_click(){
        $('.wbFullWidth').each(function() {
                var t = $(this);
                var fullwidth = $('main').width(),
                    margin_full = fullwidth/2;
        if (LANG_RTL != 1) {
                t.css({'left': '50%', 'position': 'relative', 'width': fullwidth, 'margin-left': -margin_full});
        } else{
                t.css({'right': '50%', 'position': 'relative', 'width': fullwidth, 'margin-right': -margin_full});
        }
    });
    }
});