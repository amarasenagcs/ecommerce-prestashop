/**
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
*  @author    Codespot SA <support@presthemes.com>
*  @copyright 2017-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*  
*/
$(document).ready(function(){
	if ($('.open-review-form').length)
	{
		var id_product = $('.open-review-form').data('id-product');		
		var is_logged = $('.open-review-form').data('is-logged');
		$.ajax({
			type: 'POST',
			headers: {"cache-control": "no-cache"},
			url: prestashop.urls.base_url + 'modules/wbfeature/psajax_review.php',
			async: true,
			cache: false,
			data: {
				"action": "render-modal-review",
				"id_product": id_product,				
				"is_logged": is_logged,
			},
			success: function (result)
			{
				if(result != '')
				{						
					$('body').append(result);
					activeEventModalReview();
					activeStar();
					$('.open-review-form').fadeIn('fast');
				}
							
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				// alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
			}
		});
		
		$('.open-review-form').click(function(){
			if ($('#criterions_list').length)
			{	
				$('.wb-modal-review').modal('show');
			}
			else
			{
				if ($('.wb-modal-review .modal-body .disable-form-review').length)
				{
					$('.wb-modal-review').modal('show');
				}
				else
				{
					$('.wb-modal-review-bt').remove();
					$('.wb-modal-review .modal-header').remove();
					$('.wb-modal-review .modal-body').empty();
					$('.wb-modal-review .modal-body').append('<div class="form-group disable-form-review has-danger text-center"><label class="form-control-label">'+disable_review_form_txt+'</label></div>');
					$('.wb-modal-review').modal('show');
				}
				
			}
			return false;
		});
	}
	
	$('.read-review').click(function(){
		// if ($('.wb-product-show-review-title').length && $('#wb-product-show-review-content').length)
		if ($('.wb-product-show-review-title').length)
		{
			if ($('.wb-product-show-review-title').hasClass('wbfeature-accordion'))
			{
				if ($('.wb-product-show-review-title').hasClass('collapsed'))
				{
					$('.wb-product-show-review-title').trigger('click');
				}
				var timer = setInterval(function() {
				   if ($('#collapsewbfeatureproductreview').hasClass('collapse in')) {
					   //run some other function 
						$('html, body').animate({
							scrollTop: $('.wb-product-show-review-title').offset().top
						}, 500);					   
					   clearInterval(timer);
				   }
				}, 200);
			}
			else
			{
				$('.wb-product-show-review-title').trigger('click');
				$('html, body').animate({
					scrollTop: $('.wb-product-show-review-title').offset().top
				}, 500);
			}
		}
		return false;
	});
	
	$('.usefulness_btn').click(function(){
		if (!$(this).hasClass('disabled'))
		{
			$(this).addClass('active');
			$(this).parents('.review_button').find('.usefulness_btn').addClass('disabled');
			var id_product_review = $(this).data('id-product-review');
			var is_usefull = $(this).data('is-usefull');
			var e_parent_button = $(this).parent();
			$.ajax({
				type: 'POST',
				headers: {"cache-control": "no-cache"},
				url: prestashop.urls.base_url + 'modules/wbfeature/psajax_review.php',
				async: true,
				cache: false,
				data: {
					"action": "add-review-usefull",
					"id_product_review": id_product_review,				
					"is_usefull": is_usefull,
				},
				success: function (result)
				{
					e_parent_button.fadeOut(function(){
						e_parent_button.remove();
					});
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
					// window.location.replace($('.open-review-form').data('product-link'));
				}
			});
		}
	});
	
	$('.report_btn').click(function(){
		if (!$(this).hasClass('disabled'))
		{
			$(this).addClass('disabled');
			var e_button = $(this);
			var id_product_review = $(this).data('id-product-review');
			$.ajax({
				type: 'POST',
				headers: {"cache-control": "no-cache"},
				url: prestashop.urls.base_url + 'modules/wbfeature/psajax_review.php',
				async: true,
				cache: false,
				data: {
					"action": "add-review-report",
					"id_product_review": id_product_review,								
				},
				success: function (result)
				{				
					e_button.fadeOut(function(){
						e_button.remove();
					});
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
					// window.location.replace($('.open-review-form').data('product-link'));
				}
			});
		}
		return false;
	});
	
	// activeEventModalReview();
	activeStar();
});

function activeStar()
{
	$('input.star').rating();
	$('.auto-submit-star').rating();
}

function activeEventModalReview()
{
	$('.form-new-review').submit(function(){
		if ($('.new_review_form_content .form-group.wb-has-error').length || $('.wb-fake-button').hasClass('validate-ok'))
		{
			return false;
		}
	});
	$('.wb-modal-review').on('show.bs.modal', function (e) {
		$('.wb-modal-review-bt').click(function(){
			if (!$(this).hasClass('active'))
			{
				$(this).addClass('active');
				$('.wb-modal-review-bt-text').hide();
				$('.wb-modal-review-loading').css({'display':'block'});
				
				$('.new_review_form_content input, .new_review_form_content textarea').each(function(){
					
					if ($(this).val() == '')
					{
						$(this).parent('.form-group').addClass('wb-has-error');
						$(this).attr("required", "");
					}
					else
					{
						$(this).parent('.form-group').removeClass('wb-has-error');
						$(this).removeAttr('required');
					}
				})
				
				if ($('.new_review_form_content .form-group.wb-has-error').length)
				{
					$(this).removeClass('active');
					$('.wb-modal-review-bt-text').show();
					$('.wb-modal-review-loading').hide();
				}
				else
				{
					// console.log('pass');
					// $('.wb-modal-review-bt').remove();
					// console.log($( ".new_review_form_content input, .new_review_form_content textarea" ).serialize());
					$('.wb-fake-button').addClass('validate-ok');
					$.ajax({
						type: 'POST',
						headers: {"cache-control": "no-cache"},
						url: prestashop.urls.base_url + 'modules/wbfeature/psajax_review.php?action=add-new-review',
						async: true,
						cache: false,
						data: $( ".new_review_form_content input, .new_review_form_content textarea" ).serialize(),
						success: function (result)
						{
							var object_result = $.parseJSON(result);
							// console.log(object_result);
							$('.wb-modal-review-bt').fadeOut('slow', function(){
								$(this).remove();
								
							});
							
							$('.wb-modal-review .modal-body>.row').fadeOut('slow', function(){
								$(this).remove();
								if (object_result.result)
								{
									$('.wb-modal-review .modal-body').append('<div class="form-group has-success"><label class="form-control-label">'+object_result.sucess_mess+'</label></div>');
								}
								else
								{
									// $('.wb-modal-review .modal-body').append('<div class="form-group has-danger text-center"></div>');
									$.each(object_result.errors, function(key, val){
										$('.wb-modal-review .modal-body').append('<div class="form-group has-danger text-center"><label class="form-control-label">'+val+'</label></div>');
									});
								}
							});
							
							
						},
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
							window.location.replace($('.open-review-form').data('product-link'));
						}
					});
				}
				$('.wb-fake-button').trigger('click');
			}
			
		})
	})
	
	$('.wb-modal-review').on('hide.bs.modal', function (e) {
		// console.log($('.wb-modal-review-bt').length);
		if (!$('.wb-modal-review-bt').length && !$('.wb-modal-review .modal-body .disable-form-review').length)
		{
			// console.log('aaa');
			// window.location.replace($('.open-review-form').data('product-link'));
			location.reload();
			
		}
	})
	
}

