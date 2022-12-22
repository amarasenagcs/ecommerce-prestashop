/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */
 //go to top
$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function () {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });
});

 /* loader */
$(document).ready(function(){
    var o = $('#page-preloader');
    if (o.length > 0) {
        $(window).on('load', function() {
            $('#page-preloader').removeClass('visible');
        });
    }
});

$(window).load(function() {
        $('#slider').nivoSlider();
    });
/* sidemenu */
 function openNav() {
    $('body').addClass("active");
    document.getElementById("mySidenav").style.width = "300px";
    $('#mobile_top_menu_wrapper').addClass("dblock");
    $('#mobile_top_menu_wrapper').removeClass("dnone");

}
function closeNav() {
    $('body').removeClass("active");
    document.getElementById("mySidenav").style.width = "0";
    $('#mobile_top_menu_wrapper').addClass("dnone");
    $('#mobile_top_menu_wrapper').removeClass("dblock");
}
/* sidemenu over */

$(document).keyup(function(e) {
     if (e.keyCode == 27) { // escape key maps to keycode `27`
       $('body').removeClass("active");
    document.getElementById("mySidenav").style.width = "0";
    $('#mobile_top_menu_wrapper').addCss("display","none");
       }
});
 //mega menu more
$(document).ready(function(){
if (($(document).width() >= 768) && ($(document).width() <= 1199)){
     var count_block = $('.menu-vertical .level-1').length;
     var number_blocks = 5;
     if(count_block < number_blocks){
          return false; 
     } else {
          
          $('.menu-vertical .level-1').each(function(i,n){
                if(i == number_blocks) {
                     $('.menu-content').append('<li class="view_more"><a class="dropdown-item"><i class="fa fa-plus"></i><span>More</span></a></li>');
                }
                if(i> number_blocks) {
                     $(this).addClass('wr_hide_menu');
                }
          })
          $('.wr_hide_menu').hide();
          $('.view_more').click(function() {
                $(this).toggleClass('active');
                $('.wr_hide_menu').slideToggle();
          });
     }
}
});
$(document).ready(function(){
if ($(document).width() >= 1200){
     var count_block = $('.menu-vertical .level-1').length;
     var number_blocks = 7;
     if(count_block < number_blocks){
          return false; 
     } else {
          
          $('.menu-vertical .level-1').each(function(i,n){
                if(i == number_blocks) {
                     $('.menu-content').append('<li class="view_more"><a class="dropdown-item"><i class="fa fa-plus"></i><span>More</span></a></li>');
                }
                if(i> number_blocks) {
                     $(this).addClass('wr_hide_menu');
                }
          })
          $('.wr_hide_menu').hide();
          $('.view_more').click(function() {
                $(this).toggleClass('active');
                $('.wr_hide_menu').slideToggle();
          });
     }
}
});
/* review */

$(document).ready(function(){
  // Add smooth scrolling to all links
  $("#ratep").on('click', function(event) {

   
    if (this.hash !== "") {
     
      event.preventDefault();

      var hash = this.hash;
       $('#tab1').removeClass('active');
    $('#tab2').removeClass('active');
    $('#tab3').removeClass('active');
    $('#description').removeClass('active in');
    $('#attachments').removeClass('active in');
    $('#product-details').removeClass('active in');
    $("#rv").addClass("active");
    $("#rate").addClass("active in")
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 1500, function(){
   
        window.location.hash = hash;
      });
    } 
  });
});

/*tab-product-slider js*/
  $(document).ready(function() {
    var owl = $("#owl-fea,#owl-best,#owl-related,#owl-new,#owl-same,#owl-view,#spe_product");
    imagesLoaded(owl, function() {
      owl.owlCarousel({
          loop: false,
          responsive: {
            0: { items: 1},
            480:{ items: 2, slideBy: 1},
            768:{ items: 2, slideBy: 1},
            1200:{ items: 3, slideBy: 1}          
          },
          dots: false,
           nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right" </i>'],
          margin:20
          });
      });
    });
/*tab-product-slider js end*/

$(document).ready(function() {
var owl = $("#testi");
imagesLoaded(owl, function() {
  owl.owlCarousel({
        loop:false,
      responsive: {
        0: { items: 1}
      },
      dots:false,
       nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      margin:0
      });
  });
});
$(document).ready(function() {
var owl = $("#owl-spe");
imagesLoaded(owl, function() {
  owl.owlCarousel({
        loop:false,
      responsive: {
       0: { items: 1},
            480:{ items: 2, slideBy: 1},
            768:{ items: 1, slideBy: 1}
      },
      dots:false,
       nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      margin:0
      });
  });
});
$('.blog').slick({
    loop: false,
    dots: false,
    prevNext: false,
    arrows: true,
    autoplay: false,
    slidesPerRow: 1,
    rows: 4,
    responsive: [
    {
      breakpoint: 575,
      settings: {
        slidesPerRow: 1,
        rows: 1,
      }
    }, 
    {
      breakpoint: 768,
      settings: {
        slidesPerRow: 2,
        rows: 3,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesPerRow: 1,
        rows: 2,
      }
    },
      {
      breakpoint: 1200,
      settings: {
        slidesPerRow: 1,
        rows: 3,
      }
    }
  ]
});
/* logo slider */
$(document).ready(function() {
var owl = $("#owl-logo");
imagesLoaded(owl, function() {
  owl.owlCarousel({
      loop: true,
       autoplay:true,
      autoplayTimeout: 7000,
      responsive: {
        0: { items: 2},
        480:{ items: 3, slideBy: 1},
        600:{ items: 3, slideBy: 1},
        768:{ items: 4, slideBy: 1},
        992:{ items: 6, slideBy: 1},
        1200:{ items: 7, slideBy: 1}        
      },
      dots: false,
       nav: true,
       navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      margin:15
      });
  });
});
//filter
function wbFilters(){

  if ($(window).width() <= 767) {
    $('#left-column').appendTo('#content-wrapper');
    $('#category #left-column #search_filters_wrapper').appendTo('#cat-left-column');
    $('#_desktop_cart').appendTo('#mbl-cart');
  
  } else {
    $('#left-column').appendTo('#column-left .wb-filters');
    
  }
}
$(document).ready(function(){ wbFilters(); });
$(window).resize(function(){ wbFilters(); });
/* append  end */


// *****************STRAT ZOOM_PRODUCT**************
$(document).ready(function(){

    function productZoom(){
        if ($(document).width() >= 992){
            $('.product-cover img').elevateZoom({
              zoomType: "window",
              cursor: "crosshair",
              galleryActiveClass: "active",
              zoomWindowFadeIn: 200,
              zoomWindowFadeOut: 200
            });
        
        $('body').on('mouseenter','.product-cover .js-qv-product-cover', function(){
        $('.zoomContainer').remove();
        $(this).removeData('elevateZoom');
        $(this).attr('src', $(this).attr('src'));
        $(this).data('zoom-image', $(this).data('zoom-image'));
        $(this).elevateZoom({zoomType:'window'});
    });
       $('body').on('click',('.js-qv-product-images .js-thumb'),function(e){
          e.preventDefault();
         var zoom_val = $(this).attr('src');
        $(".zoomLens img").attr('src', $(this).attr('data-image-large-src'));
        $('.zoomWindowContainer div').css("background-image","url("+ $(this).attr('data-image-large-src') +")");
       });
    }
    }
    $(document).ready(function(){ productZoom();});
    $(window).resize(function(){ productZoom();});

});

$(document).ready(function() {
var owl = $("#xs-zoom");
imagesLoaded(owl, function() {
  owl.owlCarousel({
      loop: false,
      responsive: {
        0: { items: 1}
        
      },
      dots: true,
       nav: false,
    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      margin:15
      });
  });
});


/* list grid view */
$(document).ready(function(){
    listGrid();
});
(function($){var ls=window.localStorage;var supported;if(typeof ls=='undefined'||typeof window.JSON=='undefined'){supported=false;}else{supported=true;}
$.totalStorage=function(key,value,options){return $.totalStorage.impl.init(key,value);}
$.totalStorage.setItem=function(key,value){return $.totalStorage.impl.setItem(key,value);}
$.totalStorage.getItem=function(key){return $.totalStorage.impl.getItem(key);}
$.totalStorage.getAll=function(){return $.totalStorage.impl.getAll();}
$.totalStorage.deleteItem=function(key){return $.totalStorage.impl.deleteItem(key);}
$.totalStorage.impl={init:function(key,value){if(typeof value!='undefined'){return this.setItem(key,value);}else{return this.getItem(key);}},setItem:function(key,value){if(!supported){try{$.cookie(key,value);return value;}catch(e){console.log('Local Storage not supported by this browser. Install the cookie plugin on your site to take advantage of the same functionality. You can get it at https://github.com/carhartl/jquery-cookie');}}
var saver=JSON.stringify(value);ls.setItem(key,saver);return this.parseResult(saver);},getItem:function(key){if(!supported){try{return this.parseResult($.cookie(key));}catch(e){return null;}}
return this.parseResult(ls.getItem(key));},deleteItem:function(key){if(!supported){try{$.cookie(key,null);return true;}catch(e){return false;}}
ls.removeItem(key);return true;},getAll:function(){var items=new Array();if(!supported){try{var pairs=document.cookie.split(";");for(var i=0;i<pairs.length;i++){var pair=pairs[i].split('=');var key=pair[0];items.push({key:key,value:this.parseResult($.cookie(key))});}}catch(e){return null;}}else{for(var i in ls){if(i.length){items.push({key:i,value:this.parseResult(ls.getItem(i))});}}}
return items;},parseResult:function(res){var ret;try{ret=JSON.parse(res);if(ret=='true'){ret=true;}
if(ret=='false'){ret=false;}
if(parseFloat(ret)==ret&&typeof ret!="object"){ret=parseFloat(ret);}}catch(e){}
return ret;}}})(jQuery);



function listGrid()
{
  var view = $.totalStorage('display');

  if (!view && (typeof displayList != 'undefined') && displayList)
    view = 'list';

  if (view && view != 'grid')
    display(view);
  else
    $('.display').find('#wbgrid').addClass('selected');

  $(document).on('click', '#wbgrid', function(e){
    e.preventDefault();
    display('grid');
    $(this).parents("#products-list").find(".wb-product-grid .item-product").removeClass("fadeInRight");
    $(this).parents("#products-list").find(".wb-product-grid .item-product").addClass(" animated zoomIn"); 
  
  });

  $(document).on('click', '#wblist', function(e){
    e.preventDefault();
    display('list');
    $(this).parents("#products-list").find(".wb-product-list .item-product").addClass(" animated fadeInRight");
    $(this).parents("#products-list").find(".wb-product-list .item-product").removeClass(" zoomIn"); 

  });

}

function display(view)
{
  if (view == 'grid')
  {
    $('#js-product-list .product-thumbs').removeClass('wb-product-list').addClass('wb-product-grid row');
    $('.product-thumbs .item-product').removeClass('col-xs-12').addClass('col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4');
    $('.product-thumbs .item-product .wb-image-block').removeClass('col-lg-4 col-xl-3 col-md-5 col-sm-5 col-xs-12');
    $('.product-thumbs .item-product .wb-product-desc').removeClass('col-lg-8 col-xl-9 col-md-7 col-sm-7 col-xs-12');
    $('.display').find('#wbgrid').addClass('selected');
    $('.display').find('#wblist').removeAttr('class');
    $.totalStorage('display', 'grid');
  }
  else
  { 
    $('#js-product-list .product-thumbs').removeClass('wb-product-grid').addClass('wb-product-list row');
    $('.product-thumbs .item-product').removeClass('col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4').addClass('col-xs-12');
    $('.product-thumbs .item-product .wb-image-block').addClass('col-lg-4 col-xl-3 col-md-5 col-sm-5 col-xs-12');
    $('.product-thumbs .item-product .wb-product-desc').addClass('col-lg-8 col-xl-9 col-md-7 col-sm-7 col-xs-12');
    $('.display').find('#wblist').addClass('selected');
    $('.display').find('#wbgrid').removeAttr('class');
    $.totalStorage('display', 'list');
  }
}

//category page img
$(document).ready(function() {
    var owl = $("#subcat");
    imagesLoaded(owl, function() {
      owl.owlCarousel({
          loop: false,
          responsive: {
            0: { items: 1},
            320:{ items: 2, slideBy: 1},
            360:{ items: 3, slideBy: 1},
            600:{ items: 4, slideBy: 1},
            768:{ items: 4, slideBy: 1},
            992:{ items: 6, slideBy: 1},
            1200:{ items: 6, slideBy: 1},
          1410:{ items: 8, slideBy: 1}
          },
          dots: false,
          autoplay:false,
           nav: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"> </i>'],
        margin:10
          });
      });
    });

// disabled
$('.wbblog_submit_btn').on("click",function(e) {
  e.preventDefault();
  if(!$(this).hasClass("disabled")){
    var data = new Object();
    $('[id^="wbblog_"]').each(function()
    {
      id = $(this).prop("id").replace("wbblog_", "");
      data[id] = $(this).val();
    });
    function logErrprMessage(element, index, array) {
      $('.wbblogs_message').append('<span class="wbblogs_error">'+element+'</span>');
    }
    function wbremove() {
      $('.wbblogs_error').remove();
      $('.wbblogs_success').remove();
    }
    function logSuccessMessage(element, index, array) {
      $('.wbblogs_message').append('<span class="wbblogs_success">'+element+'</span>');
    }
    $.ajax({
      url: xprt_base_dir + 'modules/wbblog/ajax.php',
      data: data,
      type:'post',
      dataType: 'json',
      beforeSend: function(){
        wbremove();
        $(".wbblog_submit_btn").val("Please wait..");
        $(".wbblog_submit_btn").addClass("disabled");
      },
      complete: function(){
        $(".wbblog_submit_btn").val("Submit Button");
        $(".wbblog_submit_btn").removeClass("disabled");  
      },
      success: function(data){
        wbremove();
        if(typeof data.success != 'undefined'){
          data.success.forEach(logSuccessMessage);
        }
        if(typeof data.error != 'undefined'){
          data.error.forEach(logErrprMessage);
        }
      },
      error: function(data){
        wbremove();
        $('.wbblogs_message').append('<span class="error">Something Wrong ! Please Try Again. </span>');
      },
    }); 
  }
});


/* language */  
 if ($(window).width() <= 767) {
$('.user-info').click(function(event){
  if ($(".currency-selector")){
  $(".language-selector > ul").css('display', 'none');
  }
  if ($(".language-selector")){
  $(".currency-selector > ul").css('display', 'none');
  }
  $(this).toggleClass('active');
  event.stopPropagation();
  $(".user-down").slideToggle("fast");
  $(".language-selector").removeClass("open");
  $(".currency-selector").removeClass("open");
  return false;
  });
  $(".user-down").on("click", function (event) {
  event.stopPropagation();
  });
   $('.wishl').appendTo('.user-down');
  $('#_mobile_currency_selector').appendTo('.user-down');
  $('#_mobile_language_selector').appendTo('.user-down');
  $('#_desktop_user_info').appendTo('#mobile_user');
  $('#_desktop_cart').appendTo('#mbl-cart');
  $('.wbSearch').appendTo('#_mobile_search');  
  
  $(".currency-selector").click(function(){
  $(this).toggleClass('open');                    
  $( ".currency-selector > ul" ).slideToggle( "1500" ); 
  $(".language-selector > ul").slideUp("medium");
  $(".language-selector").removeClass('open');
  
  });
  
  $(".language-selector").click(function(){
  $(this).toggleClass('open');                          
  $( ".language-selector > ul" ).slideToggle( "1500" );    
  $(".currency-selector > ul").slideUp("medium");
  $(".currency-selector").removeClass('open');
  });
  };
