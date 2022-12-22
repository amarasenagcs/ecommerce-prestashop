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
    createWbCompareModalPopup();
    WbCompareButtonAction();
    prestashop.on('updateProductList', function() {
        WbCompareButtonAction();
    });
    //DONGND:: recall button action if need when change attribute at product page
    prestashop.on('updatedProduct', function() {  
        WbCompareButtonAction();
    });
    prestashop.on('clickQuickView', function() {        
        check_active_compare = setInterval(function(){
            if($('.quickview.modal').length)
            {           
                $('.quickview.modal').on('shown.bs.modal', function (e) {
                    WbCompareButtonAction();
                })
                clearInterval(check_active_compare);
            }
            
        }, 300);
        
    });
    activeEventModalCompare();
});

function createWbCompareModalPopup()
{
    var wbCompareModalPopup = '';
    wbCompareModalPopup += '<div class="modal wb-modal wb-modal-compare fade" tabindex="-1" role="dialog" aria-hidden="true">';
        wbCompareModalPopup += '<div class="modal-dialog" role="document">';
            wbCompareModalPopup += '<div class="modal-content">';
                wbCompareModalPopup += '<div class="modal-header">';
                    wbCompareModalPopup += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        wbCompareModalPopup += '<span aria-hidden="true">&times;</span>';
                    wbCompareModalPopup += '</button>';
                    wbCompareModalPopup += '<h5 class="modal-title text-xs-center">';
                    wbCompareModalPopup += '</h5>';
                wbCompareModalPopup += '</div>';
            wbCompareModalPopup += '</div>';
        wbCompareModalPopup += '</div>';
    wbCompareModalPopup += '</div>';
    $('body').append(wbCompareModalPopup);
}
function WbCompareButtonAction()
{
    $('.wb-compare-button').click(function(){
        if (!$('.wb-compare-button.active').length)
        {
            var total_product_compare = compared_products.length;
            var id_product = $(this).data('id-product');
            
            var content_product_compare_mess_remove = productcompare_remove+'. <a href="'+productcompare_url+'"><strong>'+productcompare_viewlistcompare+'.</strong></a>';
            var content_product_compare_mess_add = productcompare_add+'. <a href="'+productcompare_url+'"><strong>'+productcompare_viewlistcompare+'.</strong></a>';
            var content_product_compare_mess_max = productcompare_max_item+'. <a href="'+productcompare_url+'"><strong>'+productcompare_viewlistcompare+'.</strong></a>';
            
            $(this).addClass('active');
            $(this).find('.wb-compare-bt-loading').css({'display':'block'});
            $(this).find('.wb-compare-bt-content').hide();
            var object_e = $(this);
            if ($(this).hasClass('added') || $(this).hasClass('delete'))
            {
                //DONGND:: remove product form list product compare
                //DONGND:: add product to list product compare
                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: productcompare_url,
                    async: true,
                    cache: false,
                    data: {
                        "ajax": 1,
                        "action": "remove",
                        "id_product": id_product
                    },
                    success: function (result)
                    {
                        // console.log(result);
                        //wbtheme add: update number product on icon compare
                        if ($('.ap-btn-compare .ap-total-compare').length)
                        {
                            var old_num_compare = parseInt($('.ap-btn-compare .ap-total-compare').data('compare-total'));
                            var new_num_compare = old_num_compare-1;
                            $('.ap-btn-compare .ap-total-compare').data('compare-total',new_num_compare);
                            $('.ap-btn-compare .ap-total-compare').text(new_num_compare);
                        }
                                                
                        compared_products.splice($.inArray(parseInt(id_product), compared_products), 1);
                        if (object_e.hasClass('delete'))
                        {
                            //DONGND:: remove from page product compare
                            if ($('.wb-productscompare-item').length == 1)
                            {                               
                                window.location.replace(productcompare_url);
                            }
                            else
                            {
                                $('td.product-'+id_product).fadeOut(function(){
                                    $(this).remove();
                                    
                                });
                            }
                        }
                        else
                        {
                            //DONGND:: remove from page product list
                            $('.wb-modal-compare .modal-title').html(content_product_compare_mess_remove);
                            $('.wb-modal-compare').modal('show');
                            $('.wb-compare-button[data-id-product='+id_product+']').removeClass('added');
                            $('.wb-compare-button[data-id-product='+id_product+']').attr('title',buttoncompare_title_add);
                            object_e.find('.wb-compare-bt-loading').hide();
                            object_e.find('.wb-compare-bt-content').show();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                    }
                });
            }
            else
            {
                if (total_product_compare < comparator_max_item)
                {
                    //DONGND:: add product to list product compare
                    $.ajax({
                        type: 'POST',
                        headers: {"cache-control": "no-cache"},
                        url: productcompare_url,
                        async: true,
                        cache: false,
                        data: {
                            "ajax": 1,
                            "action": "add",
                            "id_product": id_product
                        },
                        success: function (result)
                        {
                            // console.log(result);
                            $('.wb-modal-compare .modal-title').html(content_product_compare_mess_add);
                            $('.wb-modal-compare').modal('show');
                            //wbtheme add: update number product on icon compare
                            if ($('.ap-btn-compare .ap-total-compare').length)
                            {                               
                                var old_num_compare = parseInt($('.ap-btn-compare .ap-total-compare').data('compare-total'));
                                var new_num_compare = old_num_compare+1;
                                $('.ap-btn-compare .ap-total-compare').data('compare-total',new_num_compare);
                                $('.ap-btn-compare .ap-total-compare').text(new_num_compare);
                            }
                            
                            compared_products.push(id_product);
                            $('.wb-compare-button[data-id-product='+id_product+']').addClass('added');
                            $('.wb-compare-button[data-id-product='+id_product+']').attr('title',buttoncompare_title_remove);
                            object_e.find('.wb-compare-bt-loading').hide();
                            object_e.find('.wb-compare-bt-content').show();
                                        
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                        }
                    });
                    
                }
                else
                {
                    //DONGND:: list product compare limited
                    $('.wb-modal-compare .modal-title').html(content_product_compare_mess_max);
                    $('.wb-modal-compare').modal('show');
                    object_e.find('.wb-compare-bt-loading').hide();
                    object_e.find('.wb-compare-bt-content').show();
                }
            }
        }
        return false;
    })
}

function activeEventModalCompare()
{
    $('.wb-modal-compare').on('hide.bs.modal', function (e) {
        // console.log($('.wb-modal-review-bt').length);
        if ($('.wb-compare-button.active').length)
        {
            // console.log('aaa');
            $('.wb-compare-button.active').removeClass('active');
        }
    })
    $('.wb-modal-compare').on('hidden.bs.modal', function (e) {
        $('body').css('padding-right', '');
    })
    $('.wb-modal-compare').on('shown.bs.modal', function (e) {
        if ($('.quickview.modal').length)
        {           
            $('.quickview.modal').modal('hide');        
        }
    });
}
