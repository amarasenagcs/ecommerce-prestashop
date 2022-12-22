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
	createWbWishlistModalPopup();
	WbWishlistButtonAction();
	prestashop.on('updateProductList', function() {
		WbWishlistButtonAction();
	});
	//DONGND:: recall button action if need when change attribute at product page
	prestashop.on('updatedProduct', function() {  
		WbWishlistButtonAction();
	});
	prestashop.on('clickQuickView', function() {		
		check_active_wishlist = setInterval(function(){
			if($('.quickview.modal').length)
			{			
				$('.quickview.modal').on('shown.bs.modal', function (e) {
					WbWishlistButtonAction();
				})
				clearInterval(check_active_wishlist);
			}
			
		}, 300);
		
	});
	
	// $('.quickview.modal').on('shown.bs.modal', function (e) {
			// console.log('aaa');
	// })
	activeEventModalWishlist();
	WbListWishlistAction();
	$('.wb-save-wishlist-bt').click(function(){
		if (!$(this).hasClass('active'))
		{
			$(this).addClass('active');
			$('.new-wishlist .has-danger .form-control-feedback').html('');
			$('.new-wishlist .has-success .form-control-feedback').html('');
			var name_wishlist = $.trim($('#wishlist_name').val());
			if (!name_wishlist)
			{
				$('#wishlist_name').parent().addClass('has-error');
				$(this).removeClass('active');
			}
			else
			{
				var object_e = $(this);
				$('#wishlist_name').parent().removeClass('has-error');
				$('.wb-save-wishlist-bt-text').hide();
				$('.wb-save-wishlist-loading').css({'display':'block'});
				$.ajax({
					type: 'POST',
					headers: {"cache-control": "no-cache"},
					url: wishlist_url,
					async: true,
					cache: false,
					data: {
						"ajax": 1,
						"action": "add-wishlist",
						"name_wishlist": name_wishlist,					
					},
					success: function (result)
					{
						var object_result = $.parseJSON(result);
						if (object_result.errors.length)
						{
							// console.log(object_result.errors);
							$('.new-wishlist .has-success .form-control-feedback').html('');
							$('.new-wishlist .has-danger .form-control-feedback').html(object_result.errors).fadeIn();
						}
						else
						{
							$('.new-wishlist .has-danger .form-control-feedback').html('');
							$('.new-wishlist .has-success .form-control-feedback').html(object_result.result.message).fadeIn();
							setTimeout(function() {
								$('.new-wishlist .has-success .form-control-feedback').fadeOut();
							}, 3000);
							$('#wishlist_name').val('');
							
							$('.list-wishlist table tbody').append(object_result.result.wishlist);
							$('html, body').animate({
								scrollTop: $('.list-wishlist table tr.new').offset().top
							}, 500, function (){
								$('.list-wishlist table tr.new').removeClass('new');
							});
							WbListWishlistAction();
							//DONGND:: reload list product if a wishlist current view
							$('.list-wishlist tr.show .view-wishlist-product').trigger('click');
						}
						$('.wb-save-wishlist-bt-text').show();
						$('.wb-save-wishlist-loading').hide();
						object_e.removeClass('active');
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
					}
				});
				
			}
		}
		return false;
	})
});

function createWbWishlistModalPopup()
{
	var wbWishlistModalPopup = '';
	wbWishlistModalPopup += '<div class="modal wb-modal wb-modal-wishlist fade" tabindex="-1" role="dialog" aria-hidden="true">';
		wbWishlistModalPopup += '<div class="modal-dialog" role="document">';
			wbWishlistModalPopup += '<div class="modal-content">';
				wbWishlistModalPopup += '<div class="modal-header">';
					wbWishlistModalPopup += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
						wbWishlistModalPopup += '<span aria-hidden="true">&times;</span>';
					wbWishlistModalPopup += '</button>';
					wbWishlistModalPopup += '<h5 class="modal-title text-xs-center">';
					wbWishlistModalPopup += '</h5>';
				wbWishlistModalPopup += '</div>';
				wbWishlistModalPopup += '<div class="modal-footer">';			
					wbWishlistModalPopup += '<button type="button" class="btn btn-secondary" data-dismiss="modal">'+wishlist_cancel_txt+'</button>';
					wbWishlistModalPopup += '<button type="button" class="wb-modal-wishlist-bt btn btn-primary">';						
						wbWishlistModalPopup += '<span class="wb-modal-wishlist-loading cssload-speeding-wheel"></span>';
						wbWishlistModalPopup += '<span class="wb-modal-wishlist-bt-text">';
							wbWishlistModalPopup += wishlist_ok_txt;
						wbWishlistModalPopup += '</span>';
					wbWishlistModalPopup += '</button>';				
				wbWishlistModalPopup += '</div>';
			wbWishlistModalPopup += '</div>';
		wbWishlistModalPopup += '</div>';
	wbWishlistModalPopup += '</div>';
	$('body').append(wbWishlistModalPopup);
}

function WbWishlistButtonAction()
{
	if (!$('.wb-wishlist-button').hasClass('show-list'))
	{
		$('.wb-wishlist-button').click(function(){
			if (!$('.wb-wishlist-button.active').length)
			{			
				var id_product = $(this).data('id-product');
				var id_wishlist = $(this).data('id-wishlist');
				var id_product_attribute = $(this).data('id-product-attribute');
				var content_wishlist_mess_remove = wishlist_remove+'. <a href="'+wishlist_url+'"><strong>'+wishlist_viewwishlist+'.</strong></a>';
				var content_wishlist_mess_add = wishlist_add+'. <a href="'+wishlist_url+'"><strong>'+wishlist_viewwishlist+'.</strong></a>';			
				
				$(this).addClass('active');
				
				if (!isLogged)
				{
					//DONGND:: display quicklogin if enable
					if ($('.wb-quicklogin').length)
					{
						$('.wb-quicklogin').first().trigger('click');
						resetButtonAction();
					}
					else
					{
						$('.wb-modal-wishlist .modal-title').html(wishlist_loggin_required);
						$('.wb-modal-wishlist').modal('show');
					}
					return false;
				}
				
				var object_e = $(this);
				object_e.find('.wb-wishlist-bt-loading').css({'display':'block'});
				object_e.find('.wb-wishlist-bt-content').hide();
				if ($(this).hasClass('added') || $(this).hasClass('delete'))
				{
					//DONGND:: remove product form wishlist				
					$.ajax({
						type: 'POST',
						headers: {"cache-control": "no-cache"},
						url: wishlist_url,
						async: true,
						cache: false,
						data: {
							"ajax": 1,
							"action": "remove",
							"id_product": id_product,
							"id_wishlist": id_wishlist,
							"id_product_attribute": id_product_attribute,
							"quantity": 1,
						},
						success: function (result)
						{
							var object_result = $.parseJSON(result);
							if (object_result.errors.length)
							{
								$('.wb-modal-wishlist .modal-title').html(object_result.errors);
								$('.wb-modal-wishlist').modal('show');
							}
							else
							{
								//wbtheme add: update number product on icon wishlist after remove from wishlist								
								if ($('.ap-btn-wishlist .ap-total-wishlist').length)
								{								
									var old_num_wishlist = parseInt($('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total'));
									var new_num_wishlist = old_num_wishlist-1;
									$('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total',new_num_wishlist);
									$('.ap-btn-wishlist .ap-total-wishlist').text(new_num_wishlist);
								}
								
								// compared_products.splice($.inArray(parseInt(id_product), compared_products), 1);
								if (object_e.hasClass('delete'))
								{
									//DONGND:: remove from page wishlist
									$('td.product-'+id_product).fadeOut(function(){
										$(this).remove();
									});
								}
								else
								{
									//DONGND:: remove from page product list
									$('.wb-modal-wishlist .modal-title').html(content_wishlist_mess_remove);
									$('.wb-modal-wishlist').modal('show');
									$('.wb-wishlist-button[data-id-product='+id_product+']').removeClass('added');
									$('.wb-wishlist-button[data-id-product='+id_product+']').attr('title',buttonwishlist_title_add);
									object_e.find('.wb-wishlist-bt-loading').hide();
									object_e.find('.wb-wishlist-bt-content').show();
								}
							}
						},
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
						}
					});
				}
				else
				{

					//DONGND:: add product to list product wishlist
					$.ajax({
						type: 'POST',
						headers: {"cache-control": "no-cache"},
						url: wishlist_url,
						async: true,
						cache: false,
						data: {
							"ajax": 1,
							"action": "add",
							"id_product": id_product,
							"id_wishlist": id_wishlist,
							"id_product_attribute": id_product_attribute,
							"quantity": 1,
						},
						success: function (result)
						{
							// console.log(result);
							var object_result = $.parseJSON(result);
							if (object_result.errors.length)
							{
								$('.wb-modal-wishlist .modal-title').html(object_result.errors);
								$('.wb-modal-wishlist').modal('show');
							}
							else
							{
								$('.wb-modal-wishlist .modal-title').html(content_wishlist_mess_add);
								$('.wb-modal-wishlist').modal('show');
								//wbtheme add: update number product on icon wishlist after add from wishlist								
								if ($('.ap-btn-wishlist .ap-total-wishlist').length)
								{								
									var old_num_wishlist = parseInt($('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total'));
									var new_num_wishlist = old_num_wishlist+1;
									$('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total',new_num_wishlist);
									$('.ap-btn-wishlist .ap-total-wishlist').text(new_num_wishlist);
								}
								
								// console.log(object_result.result.id_wishlist);
								//DONGND:: update id wishlist if the first add of user
								if (id_wishlist == '')
								{
									$('.wb-wishlist-button').data('id-wishlist', object_result.result.id_wishlist);
									// wishlist_products[object_result.result.id_wishlist].push(id_product);
								}
								// else
								// {
									// wishlist_products[id_wishlist].push(id_product);
								// }
								
								$('.wb-wishlist-button[data-id-product='+id_product+']').addClass('added');
								$('.wb-wishlist-button[data-id-product='+id_product+']').attr('title',buttonwishlist_title_remove);
								object_e.find('.wb-wishlist-bt-loading').hide();
								object_e.find('.wb-wishlist-bt-content').show();
							}
																		
						},
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
						}
					});										
				}
			}
			return false;
		})
	}
	else
	{
		// $('.wb-wishlist-button').each(function(){
			
			// $(this).click(function(e){
				
				// e.preventDefault();
			// });
			// var htmlContent =  $(this).next().html();
			// $(this).popover({
				// placement : 'bottom', //placement of the popover. also can use top, bottom, left or right
				// title : '', //this is the top title bar of the popover. add some basic css
				// html: true, //needed to show html of course
				// content : htmlContent,  //this is the content of the html box. add the image here or anything you want really.
				// template: '<div class="popover popover-list-wishlist" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
			// });
			
		// });
		
		// $('.popover').popover('hide');
		
		// $('.wb-wishlist-button').click(function(){
			// if ($(this).hasClass('active'))
			// {
				// $(this).next().fadeOut();
				// $(this).removeClass('active');
			// }
			// else
			// {
				// $('.wb-wishlist-button.active').next().fadeOut();
				// $('.wb-wishlist-button.active').removeClass('active');
				// $(this).addClass('active');
				// $(this).next().fadeIn();
			// }
			
			// return false;
		// });
		
		// $('.popover').on('show.bs.popover' , function () {
			//DONGND:: add/remove wishlist with list wishlist
			$('.wishlist-item').click(function(){
				if (!$('.wishlist-item.active-add').length)
				{			
					var id_product = $(this).data('id-product');
					var id_wishlist = $(this).data('id-wishlist');
					var id_product_attribute = $(this).data('id-product-attribute');
					var content_wishlist_mess_remove = wishlist_remove+'. <a href="'+wishlist_url+'"><strong>'+wishlist_viewwishlist+'.</strong></a>';
					var content_wishlist_mess_add = wishlist_add+'. <a href="'+wishlist_url+'"><strong>'+wishlist_viewwishlist+'.</strong></a>';			
					
					$(this).addClass('active-add');
					
					if (!isLogged)
					{
						//DONGND:: display quicklogin if enable
						if ($('.wb-quicklogin').length)
						{
							$('.wb-quicklogin').first().trigger('click');
							resetButtonAction();
						}
						else
						{
							$('.wb-modal-wishlist .modal-title').html(wishlist_loggin_required);
							$('.wb-modal-wishlist').modal('show');
						}
						return false;
					}
					
					var object_e = $(this);
					var parents_e = object_e.parents('.wb-wishlist-button-dropdown');
					parents_e.find('.wb-wishlist-button').addClass('active');
					parents_e.find('.wb-wishlist-bt-loading').css({'display':'block'});
					parents_e.find('.wb-wishlist-bt-content').hide();
					if ($(this).hasClass('added') || $(this).hasClass('delete'))
					{
						//DONGND:: remove product form wishlist				
						$.ajax({
							type: 'POST',
							headers: {"cache-control": "no-cache"},
							url: wishlist_url,
							async: true,
							cache: false,
							data: {
								"ajax": 1,
								"action": "remove",
								"id_product": id_product,
								"id_wishlist": id_wishlist,
								"id_product_attribute": id_product_attribute,
								"quantity": 1,
							},
							success: function (result)
							{
								var object_result = $.parseJSON(result);
								if (object_result.errors.length)
								{
									$('.wb-modal-wishlist .modal-title').html(object_result.errors);
									$('.wb-modal-wishlist').modal('show');
								}
								else
								{
									//wbtheme add: update number product on icon wishlist after remove from wishlist								
									if ($('.ap-btn-wishlist .ap-total-wishlist').length)
									{								
										var old_num_wishlist = parseInt($('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total'));
										var new_num_wishlist = old_num_wishlist-1;
										$('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total',new_num_wishlist);
										$('.ap-btn-wishlist .ap-total-wishlist').text(new_num_wishlist);
									}
									
									// compared_products.splice($.inArray(parseInt(id_product), compared_products), 1);
									if (object_e.hasClass('delete'))
									{
										//DONGND:: remove from page wishlist
										$('td.product-'+id_product).fadeOut(function(){
											$(this).remove();
										});
									}
									else
									{
										//DONGND:: remove from page product list
										$('.wb-modal-wishlist .modal-title').html(content_wishlist_mess_remove);
										$('.wb-modal-wishlist').modal('show');
										
										$('.wishlist-item[data-id-wishlist='+id_wishlist+'][data-id-product='+id_product+']').removeClass('added');
										$('.wishlist-item[data-id-wishlist='+id_wishlist+'][data-id-product='+id_product+']').attr('title',buttonwishlist_title_add);
										if (!$('.wishlist-item[data-id-product='+id_product+']').hasClass('added'))
										{
											$('.wb-wishlist-button[data-id-product='+id_product+']').removeClass('added');
										}
										
										parents_e.find('.wb-wishlist-bt-loading').hide();
										parents_e.find('.wb-wishlist-bt-content').show();
										parents_e.find('.wb-wishlist-button').removeClass('active');
									}
								}
							},
							error: function (XMLHttpRequest, textStatus, errorThrown) {
								alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
							}
						});
					}
					else
					{

						//DONGND:: add product to list product wishlist
						$.ajax({
							type: 'POST',
							headers: {"cache-control": "no-cache"},
							url: wishlist_url,
							async: true,
							cache: false,
							data: {
								"ajax": 1,
								"action": "add",
								"id_product": id_product,
								"id_wishlist": id_wishlist,
								"id_product_attribute": id_product_attribute,
								"quantity": 1,
							},
							success: function (result)
							{
								// console.log(result);
								var object_result = $.parseJSON(result);
								if (object_result.errors.length)
								{
									$('.wb-modal-wishlist .modal-title').html(object_result.errors);
									$('.wb-modal-wishlist').modal('show');
								}
								else
								{
									$('.wb-modal-wishlist .modal-title').html(content_wishlist_mess_add);
									$('.wb-modal-wishlist').modal('show');
									//wbtheme add: update number product on icon wishlist after add from wishlist								
									if ($('.ap-btn-wishlist .ap-total-wishlist').length)
									{								
										var old_num_wishlist = parseInt($('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total'));
										var new_num_wishlist = old_num_wishlist+1;
										$('.ap-btn-wishlist .ap-total-wishlist').data('wishlist-total',new_num_wishlist);
										$('.ap-btn-wishlist .ap-total-wishlist').text(new_num_wishlist);
									}
									
									// console.log(object_result.result.id_wishlist);
						
									$('.wishlist-item[data-id-wishlist='+id_wishlist+'][data-id-product='+id_product+']').addClass('added');
									$('.wishlist-item[data-id-wishlist='+id_wishlist+'][data-id-product='+id_product+']').attr('title',buttonwishlist_title_remove);
									if (!$('.wb-wishlist-button[data-id-product='+id_product+']').hasClass('added'))
									{
										$('.wb-wishlist-button[data-id-product='+id_product+']').addClass('added');
									}
									
									parents_e.find('.wb-wishlist-bt-loading').hide();
									parents_e.find('.wb-wishlist-bt-content').show();
									parents_e.find('.wb-wishlist-button').removeClass('active');
								}
																			
							},
							error: function (XMLHttpRequest, textStatus, errorThrown) {
								alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
							}
						});										
					}
				}
				return false;
			});
		// });
		
	}
	
}

function WbListWishlistAction()
{
	//DONGND:: click delete wishlist
	$('.delete-wishlist').click(function(){
		if (!$(this).hasClass('active'))
		{
			$(this).addClass('active');
			$(this).parents('tr').addClass('active');
			if ($('.list-wishlist tr.active .default-wishlist').is(":checked"))
			{
				$('.wb-modal-wishlist .modal-title').html(wishlist_del_default_txt);
				$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
			}
			else
			{
				$('.wb-modal-wishlist .modal-title').html(wishlist_confirm_del_txt);
				$('.wb-modal-wishlist').addClass('enable-action').modal('show');
			}
		}
		
		return false;
	});
	
	//DONGND:: confirm delete wishlist
	$('.wb-modal-wishlist-bt').click(function(){
		if (!$(this).hasClass('active'))
		{
			// console.log('test');
			$(this).addClass('active');
			var object_e = $(this);
			var id_wishlist = $('.delete-wishlist.active').data('id-wishlist');
			$('.wb-modal-wishlist-bt-text').hide();
			$('.wb-modal-wishlist-loading').css({'display':'block'});
			
			$.ajax({
				type: 'POST',
				headers: {"cache-control": "no-cache"},
				url: wishlist_url,
				async: true,
				cache: false,
				data: {
					"ajax": 1,
					"action": "delete-wishlist",
					"id_wishlist": id_wishlist,					
				},
				success: function (result)
				{
					var object_result = $.parseJSON(result);
					if (object_result.errors.length)
					{
						
						$('.wb-modal-wishlist .modal-title').html(object_result.errors);
						$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
					}
					else
					{				
						var object_delete = $('.list-wishlist tr.active');
						$('.wb-modal-wishlist').modal('hide');
						object_delete.fadeOut(function(){
							if ($(this).hasClass('show'))
							{
								$('.wb-wishlist-product').fadeOut().html('');
							}
							else
							{
								//DONGND:: reload list product if a wishlist current view
								$('.list-wishlist tr.show .view-wishlist-product').trigger('click');
							}
							$(this).remove();
						})
						
					}
					$('.wb-modal-wishlist-loading').hide();
					$('.wb-modal-wishlist-bt-text').show();
					object_e.removeClass('active');
								
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
				}
			});
		}
	})
	
	//DONGND:: change default wishlist
	$('.default-wishlist').click(function(){
		if ($(this).is(":checked"))
		{
			// console.log('test');
			if (!$('.default-wishlist.active').length)
			{
				$(this).addClass('active');
				var object_e = $(this);
				var id_wishlist = $('.default-wishlist.active').data('id-wishlist');
				$.ajax({
					type: 'POST',
					headers: {"cache-control": "no-cache"},
					url: wishlist_url,
					async: true,
					cache: false,
					data: {
						"ajax": 1,
						"action": "default-wishlist",
						"id_wishlist": id_wishlist,					
					},
					success: function (result)
					{
						var object_result = $.parseJSON(result);
						if (object_result.errors.length)
						{
							
							$('.wb-modal-wishlist .modal-title').html(object_result.errors);
							$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
						}
						else
						{				
							$('.default-wishlist:checked').removeAttr('checked');
							object_e.prop('checked', true);
						}
						
						object_e.removeClass('active');
									
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
					}
				});
			}
		}
		// else
		// {
			// console.log('test1');
			
		// }
		return false;
	})
	
	//DONGND:: show list product of wishlist
	$('.view-wishlist-product').click(function(){
		if (!$('.view-wishlist-product.active').length)
		{
			$(this).addClass('active');
			$(this).next('.wb-view-wishlist-product-loading').show();
			$('.list-wishlist tr.show').removeClass('show');
			$(this).parents('tr').addClass('show');
			var object_e = $(this);
			var id_wishlist = $(this).data('id-wishlist');
			// $('.send-wishlist').fadeOut();
			// $('.wb-wishlist-product').fadeOut(function(){
				//$('.wb-wishlist-product').html('');			
				$.ajax({
					type: 'POST',
					headers: {"cache-control": "no-cache"},
					url: wishlist_url,
					async: true,
					cache: false,
					data: {
						"ajax": 1,
						"action": "show-wishlist-product",
						"id_wishlist": id_wishlist,					
					},
					success: function (result)
					{
						var object_result = $.parseJSON(result);
						if (object_result.errors.length)
						{
							
							$('.wb-modal-wishlist .modal-title').html(object_result.errors);
							$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
						}
						else
						{				
							$('.wb-wishlist-product').hide();
							$('.wb-wishlist-product').html(object_result.result.html).fadeIn();
							if (object_result.result.show_send_wishlist)
							{
								$('.send-wishlist').fadeIn();
								// wbWishlistButtonAction();						
								if (!$('.wb-modal-send-wishlist').length)
								{
									createWbSendWishlistModalPopup();					
									WbListWishlistProductModalAction();
								}
								else
								{
									$('.wb-modal-reset-send-wishlist-bt').trigger('click');
								}
								WbListWishlistProductAction();
								
							}
							else
							{
								$('.send-wishlist').hide();
							}
							refeshWishlist(id_wishlist);
							
						}
						
						object_e.removeClass('active');
						object_e.next('.wb-view-wishlist-product-loading').hide();
									
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
					}
				});
			// })
		}
		return false;
	})
}
function WbListWishlistProductModalAction()
{
	//DONGND:: send wishlist
	$('.wb-send-wishlist-button').click(function(){
		var name_wishlist = $('.list-wishlist tr.show .view-wishlist-product').data('name-wishlist');
		$('.wb-modal-send-wishlist .modal-title').html(wishlist_send_wishlist_txt+' "'+name_wishlist+'"');
		$('.wb-modal-send-wishlist').modal('show');
		
		return false;
	})
	
	$('.wb-modal-send-wishlist').submit(function(){
		// if ($(this).find('.form-group.wb-has-error').length)
		if ($('.wb-fake-send-wishlist-button').hasClass('validate-ok'))
		{
			return false;
		}
	});
	
	//DONGND:: submit send wishlist
	$('.wb-modal-send-wishlist-bt').click(function(){
		if (!$(this).hasClass('active'))
		{
			var check_submit_wishlist = true;
			var list_email = [];
			$(this).addClass('active');
			var object_e = $(this);
			$('.wb-modal-reset-send-wishlist-bt').fadeOut();
			
			$('.wishlist_email').each(function(key, val){
				if ($(this).val() !== '' && !$(this).parents('.form-group').hasClass('has-success') && !$(this).parents('.form-group').hasClass('has-warning'))
				{
					if (!validateEmail($(this).val()))
					{
						$(this).parents('.form-group').addClass('wb-has-error');
						check_submit_wishlist = false;
					}
					else
					{
						$(this).parents('.form-group').removeClass('wb-has-error');
						list_email.push(key);
					}
				}
				
			})
			// console.log(check_submit_wishlist);
			if (check_submit_wishlist)
			{
				// if (list_email.length == 0)
				// console.log(list_email.length);
				// console.log(list_email);
				if (list_email.length == 0)
				{
					$('.wishlist_email').each(function(key, val){
						if ($(this).val() == '')
						{
							$(this).parents('.form-group').addClass('wb-has-error');
							$(this).attr("required", "");
							return false;
						}
					})
					object_e.removeClass('active');
					$('.wb-modal-reset-send-wishlist-bt').fadeIn();
				}
				else
				{
					$('.wb-fake-send-wishlist-button').addClass('validate-ok');
					var id_wishlist = $('.list-wishlist tr.show .view-wishlist-product').data('id-wishlist');
					// console.log(list_email);
				
					$('.wb-modal-send-wishlist-bt-text').hide();
					$('.wb-modal-send-wishlist-loading').css({'display':'block'});
					
					$.each(list_email,function(key, val){
						var index_wishlist_email = val + 1;
						var email = $('#wishlist_email_'+index_wishlist_email).val();
						var object_parent_e = $('#wishlist_email_'+index_wishlist_email).parents('.form-group');
						object_parent_e.find('.wishlist_email_status_loading').show();
						
						$.ajax({
							type: 'POST',
							headers: {"cache-control": "no-cache"},
							url: wishlist_url,
							async: true,
							cache: false,
							data: {
								"ajax": 1,
								"action": "send-wishlist",
								"id_wishlist": id_wishlist,
								"email": email
							},
							success: function (result)
							{
								object_parent_e.find('.wishlist_email_status_loading').hide();
								var object_result = $.parseJSON(result);
								if (object_result.errors.length)
								{
									object_parent_e.addClass('has-warning').find('.send_wishlist_error').fadeIn();
								}
								else
								{				
									object_parent_e.addClass('has-success').find('.send_wishlist_success').fadeIn();
								}
																								
							},
							error: function (XMLHttpRequest, textStatus, errorThrown) {
								alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
							}
						});
						
					});
					$(document).ajaxStop(function() {
						// console.log('test');
						$('.wb-modal-send-wishlist-loading').hide();
						$('.wb-modal-send-wishlist-bt-text').show();
						$('.wb-fake-send-wishlist-button').removeClass('validate-ok');
						object_e.removeClass('active');
						$('.wb-modal-reset-send-wishlist-bt').fadeIn();
					});				
					
				}
				if ($('.form-send-wishlist .form-group.wb-has-error').length)
				{
					$('.wb-fake-send-wishlist-button').trigger('click');
				}
			}
			else
			{
				object_e.removeClass('active');
				$('.wb-modal-reset-send-wishlist-bt').fadeIn();
					$('.wb-fake-send-wishlist-button').trigger('click');
			}
			
		}
	})
	
	//DONGND:: reset from send wishlist
	$('.wb-modal-reset-send-wishlist-bt').click(function(){
		$('.wishlist_email').val('').removeAttr('required');
		$('.send_wishlist_form_content .form-group').removeClass('wb-has-error has-success has-warning');
		$('.wishlist_email_status_loading').fadeOut();
		$('.send_wishlist_msg').fadeOut();
	})
}

function WbListWishlistProductAction()
{
	//DONGND:: delete product of wishlist
	$('.wb-wishlist-button-delete').click(function(){
		if (!$(this).hasClass('active'))
		{
			$(this).addClass('active');
			var object_e = $(this);
			var object_parent_e = object_e.parents('.wb-wishlist-product');
			var id_wishlist_product = $(this).data('id-wishlist-product');
			var id_wishlist = $(this).data('id-wishlist');
			$.ajax({
				type: 'POST',
				headers: {"cache-control": "no-cache"},
				url: wishlist_url,
				async: true,
				cache: false,
				data: {
					"ajax": 1,
					"action": "delete-wishlist-product",
					"id_wishlist": id_wishlist,	
					"id_wishlist_product": id_wishlist_product,				
				},
				success: function (result)
				{
					var object_result = $.parseJSON(result);
					if (object_result.errors.length)
					{
						
						$('.wb-modal-wishlist .modal-title').html(object_result.errors);
						$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
					}
					else
					{				
						object_e.parents('.wb-wishlistproduct-item').fadeOut(function(){
							$(this).remove();
							// console.log(object_parent_e);
							// console.log(object_parent_e.find('.wb-wishlistproduct-item'));
							// console.log(object_parent_e.find('.wb-wishlistproduct-item').length);
							if (!object_parent_e.find('.wb-wishlistproduct-item').length)
							{							
								$('.send-wishlist').hide();
								$('.list-wishlist tr.show .view-wishlist-product').trigger('click');
							}
						})
						refeshWishlist(id_wishlist);
					}
					
					object_e.removeClass('active');
					
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
				}
			});
		}
		return false;
	})
	
	//DONGND::
	$('.wb-wishlist-product-save-button').click(function(){
		if (!$(this).hasClass('active'))
		{
			$(this).addClass('active');
			var object_e = $(this);
			var id_wishlist_product = $(this).data('id-wishlist-product');
			var id_wishlist = $(this).data('id-wishlist');
			// $('.wb-wishlistproduct-item-'+id_wishlist_product).addClass('update');
			var quantity = $('.wishlist-product-quantity-'+id_wishlist_product).val();		
			var priority = $('.wishlist-product-priority-'+id_wishlist_product).val();		
			
			if(Math.floor(quantity) == quantity && $.isNumeric(quantity) && quantity > 0)
			{
				$('.wishlist-product-quantity-'+id_wishlist_product).parents('.form-group').removeClass('has-error');
				$.ajax({
					type: 'POST',
					headers: {"cache-control": "no-cache"},
					url: wishlist_url,
					async: true,
					cache: false,
					data: {
						"ajax": 1,
						"action": "update-wishlist-product",
						"id_wishlist": id_wishlist,	
						"id_wishlist_product": id_wishlist_product,
						"quantity": quantity,	
						"priority": priority,		
					},
					success: function (result)
					{
						var object_result = $.parseJSON(result);
						if (object_result.errors.length)
						{
							
							$('.wb-modal-wishlist .modal-title').html(object_result.errors);
							$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
						}
						else
						{
							$('.wb-wishlistproduct-item-'+id_wishlist_product).hide();
							$('.wb-wishlistproduct-item-'+id_wishlist_product).fadeIn();
							refeshWishlist(id_wishlist);
						}
						
						object_e.removeClass('active');
						
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
					}
				});
			}
			else
			{
				$('.wishlist-product-quantity-'+id_wishlist_product).parents('.form-group').addClass('has-error');			
				$('.wb-modal-wishlist .modal-title').html(wishlist_quantity_required);
				$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
				object_e.removeClass('active');
			}
		}
		return false;
	})
	
	$('.move-wishlist-item').click(function(){
		if (!$(this).hasClass('active'))
		{
			$(this).addClass('active');
			var object_e = $(this);
			var object_parent_e = object_e.parents('.wb-wishlist-product');
			var id_wishlist_product = $(this).data('id-wishlist-product');
			var id_product = $(this).data('id-product');
			var id_product_attribute = $(this).data('id-product-attribute');
			var id_old_wishlist = $('.list-wishlist tr.show .view-wishlist-product').data('id-wishlist');
			var id_new_wishlist = $(this).data('id-wishlist');
			var priority = $('.wishlist-product-priority-'+id_wishlist_product).val();
			var quantity = $('.wishlist-product-quantity-'+id_wishlist_product).val();
			$.ajax({
				type: 'POST',
				headers: {"cache-control": "no-cache"},
				url: wishlist_url,
				async: true,
				cache: false,
				data: {
					"ajax": 1,
					"action": "move-wishlist-product",
					"id_new_wishlist": id_new_wishlist,	
					"id_wishlist_product": id_wishlist_product,
					"id_old_wishlist": id_old_wishlist,	
					"id_product" : id_product,
					"id_product_attribute": id_product_attribute,
					"quantity": quantity,
					"priority": priority,
				},
				success: function (result)
				{
					var object_result = $.parseJSON(result);
					if (object_result.errors.length)
					{
						
						$('.wb-modal-wishlist .modal-title').html(object_result.errors);
						$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
					}
					else
					{
						object_e.parents('.wb-wishlistproduct-item').fadeOut(function(){
							$(this).remove();
							if (!object_parent_e.find('.wb-wishlistproduct-item').length)
							{							
								$('.send-wishlist').hide();
								$('.list-wishlist tr.show .view-wishlist-product').trigger('click');
							}
						});
						refeshWishlist(id_new_wishlist);
						refeshWishlist(id_old_wishlist);
					}
					
					object_e.removeClass('active');
					
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
				}
			});		
		}
		return false;
	})
}

function activeEventModalWishlist()
{
	$('.wb-modal-wishlist').on('hide.bs.modal', function (e) {
		resetButtonAction();
	})
	
	$('.wb-modal-wishlist').on('hidden.bs.modal', function (e) {
		$('body').css('padding-right', '');
	})
	$('.wb-modal-wishlist').on('show.bs.modal', function (e) {
		if ($('.quickview.modal').length)
		{			
			$('.quickview.modal').modal('hide');		
		}
		
	});
}

//DONGND:: reset button add wishlist after click
function resetButtonAction(){
	// console.log($('.wb-modal-review-bt').length);
	if ($('.wb-wishlist-button.active').length)
	{
		// console.log('aaa');
		$('.wb-wishlist-button.active').removeClass('active');
	}
	
	if ($('.wishlist-item.active-add').length)
	{
		// console.log('aaa');
		$('.wishlist-item.active-add').removeClass('active-add');
	}
	// $('.wb-list-wishlist').fadeOut();
	$('.default-wishlist.active').removeClass('active');
	$('.delete-wishlist.active').removeClass('active');
	
	$('.list-wishlist tr.active').removeClass('active');
	
	// $('.wb-modal-wishlist').removeClass('enable-action');
}

function createWbSendWishlistModalPopup()
{
	var wbSendWishlistModalPopup = '';
	wbSendWishlistModalPopup += '<div class="modal wb-modal wb-modal-send-wishlist fade" tabindex="-1" role="dialog" aria-hidden="true">';
		wbSendWishlistModalPopup += '<div class="modal-dialog" role="document">';
			wbSendWishlistModalPopup += '<div class="modal-content">';
				wbSendWishlistModalPopup += '<div class="modal-header">';
					wbSendWishlistModalPopup += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
						wbSendWishlistModalPopup += '<span aria-hidden="true">&times;</span>';
					wbSendWishlistModalPopup += '</button>';
					wbSendWishlistModalPopup += '<h5 class="modal-title text-xs-center">';
					wbSendWishlistModalPopup += '</h5>';
				wbSendWishlistModalPopup += '</div>';
				wbSendWishlistModalPopup += '<div class="modal-body">';
					wbSendWishlistModalPopup += '<div class="send_wishlist_form_content">';
						wbSendWishlistModalPopup += '<form class="form-send-wishlist" action="#" method="post">'
							for (var $i=1; $i<= 10; $i++)
							{								
								wbSendWishlistModalPopup += '<div class="form-group row">';
								  wbSendWishlistModalPopup += '<label class="col-form-label col-sm-2 text-sm-left" for="wishlist_email_'+$i+'">'+wishlist_email_txt+' '+$i+'</label>';
									wbSendWishlistModalPopup += '<div class="wishlist_email_status col-sm-1">';
										wbSendWishlistModalPopup += '<div class="wishlist_email_status_loading cssload-speeding-wheel">';
										wbSendWishlistModalPopup += '</div>';
										wbSendWishlistModalPopup += '<i class="send_wishlist_msg send_wishlist_success material-icons">&#xE876;</i>';
										wbSendWishlistModalPopup += '<i class="send_wishlist_msg send_wishlist_error material-icons">&#xE033;</i>';									
									wbSendWishlistModalPopup += '</div>';
									wbSendWishlistModalPopup += '<div class="col-sm-9">';		
								  wbSendWishlistModalPopup += '<input class="form-control wishlist_email" id="wishlist_email_'+$i+'" name="wishlist_email_'+$i+'" type="email">';
									wbSendWishlistModalPopup += '</div>';
								wbSendWishlistModalPopup += '</div>';
							}
							wbSendWishlistModalPopup += '<button class="btn btn-primary form-control-submit wb-fake-send-wishlist-button pull-xs-right" type="submit"></button>';					  				
						wbSendWishlistModalPopup += '</form>';
					wbSendWishlistModalPopup += '</div>';
				wbSendWishlistModalPopup += '</div>';
				wbSendWishlistModalPopup += '<div class="modal-footer">';	
					wbSendWishlistModalPopup += '<button type="button" class="btn btn-primary wb-modal-reset-send-wishlist-bt">'+wishlist_reset_txt+'</button>';	
					wbSendWishlistModalPopup += '<button type="button" class="btn btn-secondary" data-dismiss="modal">'+wishlist_cancel_txt+'</button>';
					wbSendWishlistModalPopup += '<button type="button" class="wb-modal-send-wishlist-bt btn btn-primary">';						
						wbSendWishlistModalPopup += '<span class="wb-modal-send-wishlist-loading cssload-speeding-wheel"></span>';
						wbSendWishlistModalPopup += '<span class="wb-modal-send-wishlist-bt-text">';
							wbSendWishlistModalPopup += wishlist_send_txt;
						wbSendWishlistModalPopup += '</span>';
					wbSendWishlistModalPopup += '</button>';				
				wbSendWishlistModalPopup += '</div>';
			wbSendWishlistModalPopup += '</div>';
		wbSendWishlistModalPopup += '</div>';
	wbSendWishlistModalPopup += '</div>';
	$('body').append(wbSendWishlistModalPopup);
}

function validateEmail(email) {
  // var regex = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
  // return regex.test(email);
	var reg = /^[a-z\p{L}0-9!#$%&'*+\/=?^`{}|~_-]+[.a-z\p{L}0-9!#$%&'*+\/=?^`{}|~_-]*@[a-z\p{L}0-9]+[._a-z\p{L}0-9-]*\.[a-z\p{L}0-9]+$/i;
	return reg.test(email);
}

//DONGND:: update quantity of wishlist
function refeshWishlist(id_wishlist)
{
	$('.wb-view-wishlist-product-loading-'+id_wishlist).show();
	$.ajax({
		type: 'POST',
		headers: {"cache-control": "no-cache"},
		url: wishlist_url,
		async: true,
		cache: false,
		data: {
			"ajax": 1,
			"action": "get-wishlist-info",
			"id_wishlist": id_wishlist,					
		},
		success: function (result)
		{
			var object_result = $.parseJSON(result);
			if (object_result.errors.length)
			{
				
				$('.wb-modal-wishlist .modal-title').html(object_result.errors);
				$('.wb-modal-wishlist').removeClass('enable-action').modal('show');
			}
			else
			{				
				$('.wishlist-numberproduct-'+id_wishlist).html(object_result.result.number_product);
			}
			$('.wb-view-wishlist-product-loading-'+id_wishlist).hide();
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
		}
	});
}