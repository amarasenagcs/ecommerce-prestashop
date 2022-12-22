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
$(document).ready(function() {
	$('select#id_product_review_criterion_type').change(function() {
		// PS 1.6
		$('#categoryBox').closest('div.form-group').hide();
		$('#ids_product').closest('div.form-group').hide();
		// PS 1.5
		$('#categories-treeview').closest('div.margin-form').hide();
		$('#categories-treeview').closest('div.margin-form').prev().hide();
		$('#ids_product').closest('div.margin-form').hide();
		$('#ids_product').closest('div.margin-form').prev().hide();

		if (this.value == 2)
		{
			$('#categoryBox').closest('div.form-group').show();
			// PS 1.5
			$('#categories-treeview').closest('div.margin-form').show();
			$('#categories-treeview').closest('div.margin-form').prev().show();
		}
		else if (this.value == 3)
		{
			$('#ids_product').closest('div.form-group').show();
			// PS 1.5
			$('#ids_product').closest('div.margin-form').show();
			$('#ids_product').closest('div.margin-form').prev().show();
		}
	});

	$('select#id_product_review_criterion_type').trigger("change");
	
	//DONGND:: tab change in group config
	var id_panel = $("#wbfeature-setting .wbfeature-tablist li.active a").attr("href");
	$(id_panel).addClass('active').show();
	$('.wbfeature-tablist li').click(function(){
		if(!$(this).hasClass('active'))
		{
			var default_tab = $(this).find('a').attr("href");			
			$('#WBFEATURE_DEFAULT_TAB').val(default_tab);
		}
	})
	
	// console.log('test');
	if (typeof wbfeature_module_dir != 'undefined')
	{
		$.ajax({
			type: 'POST',
			headers: {"cache-control": "no-cache"},
			url: wbfeature_module_dir + 'psajax.php',
			async: true,
			cache: false,
			data: {
				"action": "get-new-review",		
			},
			success: function (result)
			{
				if(result != '')
				{						
					var obj = $.parseJSON(result);
					if (obj.number_review > 0)
					{
						$('#subtab-AdminWbfeatureManagement').addClass('has-review');
						// $('#subtab-AdminWbfeatureReviews').append('<span id="total_notif_number_wrapper" class="notifs_badge"><span id="total_notif_value">'+obj.number_review+'</span></span>');
						$('#subtab-AdminWbfeatureReviews').append('<div class="notification-container"><span class="notification-counter">'+obj.number_review+'</span></div>');
					}
					
				}
				
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				// alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
			}
		});
	}
    
    var wb_id_disable_on = '#WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS_on, #WBFEATURE_ENABLE_NOTIFICATION_on, #WBFEATURE_ENABLE_FLYCART_EFFECT_on, #WBFEATURE_ENABLE_PRODUCTCOMPAREFEATURE_ENABLE_DROPDOWN_FLYCART_on';
    var wb_id_disable_off = '#WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS_off, #WBFEATURE_ENABLE_NOTIFICATION_off, #WBFEATURE_ENABLE_FLYCART_EFFECT_off, #WBFEATURE_ENABLE_SELECTATTRIBUTEFEATURE_ENABLE_DROPDOWN_FLYCART_off';
    
    $(wb_id_disable_on).off('click').on('click', function(e){
        return false;
    });
    $(wb_id_disable_off).trigger('click');
    
    


    $('#WBFEATURE_SHOW_POPUP_off').off('click').on('click', function(e){
        return false;
    });
    $('#WBFEATURE_SHOW_POPUP_on').trigger('click');
    
    
    
    
    $("#WBFEATURE_TYPE_DROPDOWN_DEFAULTCART").val("dropdown");
    $("#WBFEATURE_TYPE_DROPDOWN_DEFAULTCART").off('change').on('change', function(){
        $("#WBFEATURE_TYPE_DROPDOWN_DEFAULTCART").val("dropdown");
        return false;
    });
    
    
    
    $("#WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART").off('change').on('change', function(){
        $("#WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART").val("3");
        return false;
    });
    
    
    
    
});