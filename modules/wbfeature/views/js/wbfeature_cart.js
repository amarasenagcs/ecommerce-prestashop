/**
 * 2016-2019 Webibazaar
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 *  @Module Name: WebiBazaar Feature (AddToCart, Wishlist, Compare, Product Review)
 *  @author    Webibazaar <info@webibazaar.com>
 *  @copyright 2016-2019 Webibazaar
 *  @license   https://www.webibazaar.com - prestashop template provider
 */
$(document).ready(function() {
    if (typeof show_popup != 'undefined' && !show_popup) {
        $(".blockcart.cart-preview").addClass('wb-blockcart').removeClass('blockcart')
    }
    createModalAndDropdown(0, 0);
    wbSelectAttr();
    wbBtCart();
    prestashop.on('updateProductList', function() {
        wbSelectAttr();
        wbBtCart()
    });

    prestashop.on('updateCart', function(event) {
        if (typeof show_popup != 'undefined' && !show_popup) {
            if ($('.wb-blockcart.cart-preview .cssload-piano').length) {
                $('.wb-blockcart.cart-preview .cssload-piano').show()
            }
            var refresh_url = $('.wb-blockcart').data('refresh-url');
            $.ajax({
                type: 'POST',
                headers: {
                    "cache-control": "no-cache"
                },
                url: refresh_url,
                async: !0,
                cache: !1,
                success: function(resp) {
                    $('.wb-blockcart').replaceWith($(resp.preview).find('.blockcart'));
                    $(".blockcart.cart-preview").addClass('wb-blockcart').removeClass('blockcart');

                    if (event.reason.linkAction == 'add-to-cart' && event.resp.success) {
                        prestashop.emit('updateProduct', {
                            reason: ''
                        })
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                }
            })
        }
        if (event.reason.linkAction == 'add-to-cart' && event.resp.success) {
            
            if ($('.wb-notification').length && typeof enable_notification != 'undefined' && enable_notification) {
                var id_product = event.resp.id_product;
                var product_name = !1;
                $.each(event.resp.cart.products, function(key, value) {
                    if (id_product == value.id_product) {
                        product_name = value.name;
                        return !1
                    }
                })
                showWbNotification('success', 'add', product_name)
            }
        }
        if (typeof show_popup != 'undefined' && show_popup) {
            check_active_modal_cart = setInterval(function() {
                if ($('.wb-bt-cart.active').length && $('#blockcart-modal').length && $('#blockcart-modal').hasClass('modal fade in')) {
                    $('.wb-bt-cart.active').find('.wb-bt-cart-content').fadeIn('fast');
                    $('.wb-bt-cart.active').find('.wb-loading').hide();
                    $('.wb-bt-cart.active').removeClass('active reset');
                    clearInterval(check_active_modal_cart)
                }
            }, 200)
        }
        if (typeof show_popup != 'undefined' && !show_popup) {
            if ($('.wb-bt-cart.active').length) {
                $('.wb-bt-cart.active').find('.wb-bt-cart-content').fadeIn('fast');
                $('.wb-bt-cart.active').find('.wb-loading').hide();
                $('.wb-bt-cart.active').removeClass('active reset')
            }
        }
        if ($('.wb-dropdown-cart-item.deleting').length) {
            $('.wb-dropdown-cart-item.deleting .wb-dropdown-overlay').hide();
            $('.wb-dropdown-cart-item.deleting .wb-dropdown-cssload-speeding-wheel').hide();
            $('.wb-dropdown-cart-item.deleting').fadeOut(function() {
                $('.wb-dropdown-cart-item.deleting').remove();
                updateClassCartItem()
            })
            showWbNotification('success', 'delete', !1)
        }
        if ($('.wb-dropdown-cart-item.updating').length) {
            $('.wb-dropdown-cart-item.updating .wb-dropdown-overlay').hide();
            $('.wb-dropdown-cart-item.updating .wb-dropdown-cssload-speeding-wheel').hide();
            $('.wb-dropdown-cart-item.updating').removeClass('updating');
            showWbNotification('success', 'update', !1)
        }
        $('.wb-dropdown-cart.dropdown').removeClass('disable-close');
        $('.wb-dropdown-cart.dropup').removeClass('disable-close');
        createModalAndDropdown(1, 0)
    });
   
    $(document).click(function(e) {
        e.stopPropagation();
        var container = $(".wb-dropdown-cart.dropdown.show");
        if (container.length && container.has(e.target).length === 0) {
            if (!container.hasClass('disable-close')) {
                container.removeClass('show')
            }
        }
        var container1 = $(".wb-dropdown-cart.dropup.show");
        if (container1.length && container1.has(e.target).length === 0) {
            if (!container1.hasClass('disable-close')) {
                container1.removeClass('show')
            }
        }
    })
});

function wbBtCart() {
    $('.wb-bt-cart').each(function() {
        if (!$(this).hasClass('wb-enable')) {
            $(this).addClass('wb-enable');
            $(this).click(function(event) {
                if ($(this).hasClass('active') || $(this).hasClass('reset') || $('.wb-bt-cart.active').length || $(this).hasClass('disabled')) {
                    return !1
                }
                $(this).find('.wb-bt-cart-content').hide();
                $(this).find('.wb-loading').css({
                    'display': 'block'
                });
                $(this).addClass('active');
                var object_button_container = $(this).parents('.product-miniature');
                if (object_button_container.find('.wb_cart_quantity').length) {
                    object_button_container.find('.qty_product').val(object_button_container.find('.wb_cart_quantity').val())
                }
                var qty_product = object_button_container.find('.qty_product').val();
                var min_qty = object_button_container.find('.minimal_quantity').val();
                var quantity_product = object_button_container.find('.quantity_product').val();
                if (Math.floor(qty_product) == qty_product && $.isNumeric(qty_product) && qty_product > 0) {} else {
                    $(this).addClass('reset');
                    $('.wb-modal-cart .modal-header').addClass('warning-mess');
                    $('.wb-modal-cart .wb-warning').show();
                    $('.wb-modal-cart').modal('show');
                    return !1
                }
                if (parseInt(qty_product) < parseInt(min_qty)) {
                    $(this).addClass('reset');
                    $('.wb-modal-cart .modal-header').addClass('info-mess');
                    $('.wb-modal-cart .wb-info .alert-min-qty').text(min_qty);
                    $('.wb-modal-cart .wb-info').show();
                    $('.wb-modal-cart').modal('show');
                    return !1
                }
                var id_product = object_button_container.find('.id_product').val();
                var id_product_attribute = object_button_container.find('.id_product_attribute').val();
                var id_customization = object_button_container.find('.id_customization').val();
                var $element = $(this);
                $(this).removeData('check-outstock');
                checkProductOutStock(id_product, id_product_attribute, id_customization, qty_product, $element, !0);
                check_data_outstock = setInterval(function() {
                    if (typeof $element.data('check-outstock') != 'undefined') {
                        clearInterval(check_data_outstock);
                        if (!$element.data('check-outstock')) {
                            $element.addClass('reset');
                            $('.wb-modal-cart .modal-header').addClass('block-mess');
                            $('.wb-modal-cart .wb-block').show();
                            $('.wb-modal-cart').modal('show');
                            event.preventDefault();
                            event.stopPropagation()
                        } else {
                            var $form = $element.closest('form');
                            var query = $form.serialize() + '&add=1&action=update';
                            var actionURL = $form.attr('action');
                            $.ajax({
                                type: 'POST',
                                headers: {
                                    "cache-control": "no-cache"
                                },
                                url: actionURL,
                                async: !0,
                                cache: !1,
                                data: query,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.success) {
                                        if ($('.wb-notification').length && typeof enable_notification != 'undefined' && enable_notification) {
                                            var id_product = result.id_product;
                                            var product_name = !1;
                                            $.each(result.cart.products, function(key, value) {
                                                if (id_product == value.id_product) {
                                                    product_name = value.name;
                                                    return !1
                                                }
                                            })
                                            showWbNotification('success', 'add', product_name)
                                        }                        
                                        if ($('.wb-blockcart.cart-preview .cssload-piano').length) {
                                            $('.wb-blockcart.cart-preview .cssload-piano').show()
                                        }
                                        if (typeof show_popup != 'undefined' && !show_popup) {
                                            if ($('.wb-bt-cart.active').length) {
                                                $('.wb-bt-cart.active').find('.wb-bt-cart-content').fadeIn('fast');
                                                $('.wb-bt-cart.active').find('.wb-loading').hide();
                                                $('.wb-bt-cart.active').removeClass('active reset')
                                            }
                                            var refresh_url = $('.wb-blockcart').data('refresh-url');
                                            $.ajax({
                                                type: 'POST',
                                                headers: {
                                                    "cache-control": "no-cache"
                                                },
                                                url: refresh_url,
                                                async: !0,
                                                cache: !1,
                                                success: function(resp) {
                                                    $('.wb-blockcart').replaceWith($(resp.preview).find('.blockcart'));
                                                    $(".blockcart.cart-preview").addClass('wb-blockcart').removeClass('blockcart');

                                                    createModalAndDropdown(1, 0)
                                                },
                                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                    console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                                                }
                                            })
                                        }
                                        if (typeof show_popup != 'undefined' && show_popup) {
                                            var refreshURL = $('.blockcart').data('refresh-url');
                                            var requestData = {};
                                            requestData = {
                                                id_product_attribute: result.id_product_attribute,
                                                id_product: result.id_product,
                                                action: 'add-to-cart'
                                            };
                                            $.ajax({
                                                type: 'POST',
                                                headers: {
                                                    "cache-control": "no-cache"
                                                },
                                                url: refreshURL,
                                                async: !0,
                                                cache: !1,
                                                data: requestData,
                                                dataType: 'json',
                                                success: function(resp) {
                                                    if ($('.wb-bt-cart.active').length) {
                                                        $('.wb-bt-cart.active').find('.wb-bt-cart-content').fadeIn('fast');
                                                        $('.wb-bt-cart.active').find('.wb-loading').hide();
                                                        $('.wb-bt-cart.active').removeClass('active reset')
                                                    }
                                                    $('.blockcart').replaceWith($(resp.preview).find('.blockcart'));
                                                    if (resp.modal) {
                                                        showModalPopupCart(resp.modal)
                                                    }
                                                    createModalAndDropdown(1, 0)
                                                },
                                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                    console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                                                }
                                            })
                                        }
                                    } else {
                                        showWbNotification('error', 'add', !1)
                                    }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    showWbNotification('error', 'add', !1)
                                }
                            })
                        }
                    }
                }, 10);
                return !1
            })
        }
    });
    $('.wb_cart_quantity').each(function() {
        if ($(this).parents('.product-miniature').find('.qty_product').val()) {
            $(this).val($(this).parents('.product-miniature').find('.qty_product').val());                                                    
        } else {
            $(this).hide()
        }
    })
}

function wbSelectAttr() {
    $('.wb-select-attr').click(function(e) {
        e.preventDefault();
        var id_product = $(this).data('id-product');
        var attr_txt = $(this).text();
        var id_attr = $(this).data('id-attr');
        var qty_attr = $(this).data('qty-attr');
        var min_qty_attr = $(this).data('min-qty-attr');
        var parent_e = $(this).parents('.product-miniature');
        if (!$(this).hasClass('selected')) {
            $(this).siblings().removeClass('selected');
            $(this).addClass('selected');
            parent_e.find('.dropdownListAttrButton_' + id_product).text(attr_txt);
            if ($(this).hasClass('disable')) {
                if (!parent_e.find('.wb-bt-cart_' + id_product).hasClass('disabled')) {
                    parent_e.find('.wb-bt-cart_' + id_product).addClass('disabled')
                }
            } else {
                if (parent_e.find('.wb-bt-cart_' + id_product).hasClass('disabled')) {
                    parent_e.find('.wb-bt-cart_' + id_product).removeClass('disabled')
                }
            };
            var $product_article_e = $(this).parents('.product-miniature[data-id-product=' + id_product + ']');
            $product_article_e.find('.wb-bt-cart .wb-bt-cart-content').hide();
            $product_article_e.find('.wb-bt-cart .wb-loading').css({
                'display': 'block'
            });
            $product_article_e.find('.wb-bt-cart').addClass('active');
            $.ajax({
                type: 'POST',
                headers: {
                    "cache-control": "no-cache"
                },
                url: prestashop.urls.base_url + 'modules/wbfeature/psajax.php?rand=' + new Date().getTime(),
                async: !0,
                cache: !1,
                data: {
                    "action": "get-attribute-data",
                    "id_product": id_product,
                    "id_product_attribute": id_attr,
                    "token": wb_token
                },
                success: function(result) {
                    if (result != '') {
                        var obj = $.parseJSON(result);
                        $product_article_e.find('.product-thumbnail img').attr('src', obj.product_cover.bySize.home_default.url).attr('alt', obj.product_cover.legend);
                        $product_article_e.find('.product-thumbnail').attr('href', obj.product_url);
                        $product_article_e.find('.product-price-and-shipping').empty().append(obj.price_attribute)
                    } else {
                        alert(add_cart_error)
                    }
                    $('.wb-bt-cart.active').find('.wb-bt-cart-content').fadeIn('fast');
                    $('.wb-bt-cart.active').find('.wb-loading').hide();
                    $('.wb-bt-cart.active').removeClass('active reset')
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                }
            })
        }
        parent_e.find('.quantity_product_' + id_product).val(qty_attr);
        parent_e.find('.id_product_attribute_' + id_product).val(id_attr);
        parent_e.find('.minimal_quantity_' + id_product).val(min_qty_attr);
        parent_e.find('.qty_product_' + id_product).val(min_qty_attr).data('min', min_qty_attr);
        parent_e.find('.wb_cart_quantity').val(min_qty_attr);
        parent_e.find('.dropdownListAttrButton_' + id_product).trigger('click')
    })
}

function activeEventModal() {
    $('.wb-modal-cart').on('hide.bs.modal', function(e) {
        $('.wb-modal-cart .modal-header').removeClass('block-mess info-mess warning-mess');
        $('.wb-modal-cart .modal-title').hide();
        var min_qty = $('.wb-bt-cart.reset').parents('.button-container').find('.minimal_quantity').val();
        $('.wb-bt-cart.reset').parents('.button-container').find('.qty_product').val(min_qty);
        $('.wb-bt-cart.reset').parents('.product-miniature').find('.wb_cart_quantity').val(min_qty);
        $('.wb-bt-cart.active').find('.wb-bt-cart-content').fadeIn('fast');
        $('.wb-bt-cart.active').find('.wb-loading').hide();
        $('.wb-bt-cart.active').removeClass('active reset')
    })
}

function updatePostionLabel($parent) {
    var FLAG_MARGIN = 10;
    var $percent = $parent.find('.discount-percentage');
    var $onsale = $parent.find('.on-sale');
    var $new = $parent.find('.new');
    if ($percent.length) {
        $new.css('top', $percent.height() * 2 + FLAG_MARGIN);
        $percent.css('top', -$parent.find('.thumbnail-container').height() + $parent.find('.product-description').height() + FLAG_MARGIN)
    }
    if ($onsale.length) {
        $percent.css('top', parseFloat($percent.css('top')) + $onsale.height() + FLAG_MARGIN);
        $new.css('top', ($percent.height() * 2 + $onsale.height()) + FLAG_MARGIN * 2)
    }
}

function showDropDownCart($element, $type) {
    var object_element = '';
    if ($type == 'defaultcart') {
        object_element = $element.siblings('.wb-dropdown-cart')
    }
    if (!object_element.hasClass('active')) {
        //console.log("active");
        object_element.addClass('active')
    } else {
        //console.log("hide");
        object_element.removeClass('active')
    }
}

function activeDropdownEvent() {
    $('.wb-dropdown-list-item').each(function() {
        var check_number_cartitem = 3;
        if (typeof number_cartitem_display != 'undefined') {
            check_number_cartitem = number_cartitem_display
        }
    })
    $('.wb-remove-from-cart, .view-wb-dropdown-additional').hover(function() {
        if ($(this).hasClass('wb-remove-from-cart')) {
            $(this).parents('.wb-dropdown-cart-item').addClass('high-light')
        }
    }, function() {
        if ($(this).hasClass('wb-remove-from-cart')) {
            $(this).parents('.wb-dropdown-cart-item').removeClass('high-light')
        }
    })
    $('.view-wb-dropdown-additional').click(function() {
        var parent_obj = $(this).parents('.wb-dropdown-cart-item');
        var wrapper_parent_obj = $(this).parents('.wb-dropdown-list-item');
        if (!$(this).hasClass('show')) {
            if (wrapper_parent_obj.find('.wb-dropdown-cart-item.show-additional')) {
                wrapper_parent_obj.find('.wb-dropdown-cart-item.show-additional').removeClass('show-additional');
                wrapper_parent_obj.find('.view-wb-dropdown-additional.show').removeClass('show');
                wrapper_parent_obj.find('.fake-element').fadeOut('200', function() {
                    $(this).remove()
                });
                wrapper_parent_obj.mCustomScrollbar("update");
                setTimeout(function() {
                    wrapper_parent_obj.parents('.wb-dropdown-list-item-warpper').mCustomScrollbar("update")
                }, 500)
            }
            $(this).addClass('show');
            if (wrapper_parent_obj.hasClass('active-scrollbar') && parent_obj.hasClass('last')) {
                var height_clone_obj = parent_obj.find('.wb-dropdown-additional').height();
                wrapper_parent_obj.find('.mCSB_container').append('<p class="fake-element" style="height:' + height_clone_obj + 'px"></p>');
                wrapper_parent_obj.mCustomScrollbar("update");
                wrapper_parent_obj.mCustomScrollbar("scrollTo", "bottom", {
                    callbacks: parent_obj.addClass('show-additional')
                })
            } else if (wrapper_parent_obj.parents('.wb-dropdown-list-item-warpper').hasClass('active-scrollbar') && parent_obj.hasClass('last') && parent_obj.hasClass('first')) {
                wrapper_parent_obj.append('<li class="wb-dropdown-cart-item clearfix has-view-additional fake-element" style="width:' + width_cart_item + 'px; height:' + height_cart_item + 'px"></p>');
                wrapper_parent_obj.parents('.wb-dropdown-list-item-warpper').mCustomScrollbar("update");
                wrapper_parent_obj.parents('.wb-dropdown-list-item-warpper').mCustomScrollbar("scrollTo", "last", {
                    callbacks: parent_obj.addClass('show-additional')
                })
            } else {
                parent_obj.addClass('show-additional')
            }
        } else {
            parent_obj.removeClass('show-additional');
            if (wrapper_parent_obj.hasClass('active-scrollbar') && parent_obj.hasClass('last')) {
                wrapper_parent_obj.find('.fake-element').fadeOut('200', function() {
                    $(this).remove()
                });
                wrapper_parent_obj.mCustomScrollbar("update")
            } else if (wrapper_parent_obj.parents('.wb-dropdown-list-item-warpper').hasClass('active-scrollbar') && parent_obj.hasClass('last') && parent_obj.hasClass('first')) {
                wrapper_parent_obj.find('.fake-element').fadeOut('200', function() {
                    $(this).remove()
                });
                parent_obj.removeClass('show-additional');
                $(this).removeClass('show');
                setTimeout(function() {
                    wrapper_parent_obj.parents('.wb-dropdown-list-item-warpper').mCustomScrollbar("update")
                }, 500)
            }
            parent_obj.removeClass('show-additional');
            $(this).removeClass('show')
        }
        return !1
    })
    $('.wb-remove-from-cart').click(function() {
        var id_product = $(this).data('id-product');
        var id_product_attribute = $(this).data('id-product-attribute');
        var id_customization = $(this).data('id-customization');
        var parent_obj = $(this).parents('.wb-dropdown-cart-item');
        parent_obj.addClass('deleting');
        if (parent_obj.hasClass('show-additional')) {
            parent_obj.find('.view-wb-dropdown-additional').trigger('click')
        }
        parent_obj.find('.wb-dropdown-overlay').show();
        parent_obj.find('.wb-dropdown-cssload-speeding-wheel').show();
        if ($('.remove-from-cart').length) {
            $('.wb-dropdown-cart.dropdown').addClass('disable-close');
            $('.wb-dropdown-cart.dropup').addClass('disable-close');
            $('.remove-from-cart[data-id-product="' + id_product + '"][data-id-product-attribute="' + id_product_attribute + '"][data-id-customization="' + id_customization + '"]').trigger('click')
        } else {
            var link_url = $(this).data('link-url');
            var refresh_url = $('.blockcart.cart-preview').data('refresh-url');
            $.ajax({
                type: 'POST',
                headers: {
                    "cache-control": "no-cache"
                },
                url: link_url,
                async: !0,
                cache: !1,
                data: {
                    "ajax": 1,
                    "action": "update",
                },
                success: function(result) {
                    var obj = $.parseJSON(result);
                    parent_obj.find('.wb-dropdown-overlay').hide();
                    parent_obj.find('.wb-dropdown-cssload-speeding-wheel').hide();
                    if (obj.success) {
                        parent_obj.fadeOut(function() {
                            parent_obj.remove();
                            $('.wb-remove-from-cart[data-id-product="' + id_product + '"][data-id-product-attribute="' + id_product_attribute + '"][data-id-customization="' + id_customization + '"]').parents('.wb-dropdown-cart-item').remove();
                            updateClassCartItem()
                        });
                        showWbNotification('success', 'delete', !1);
                        //console.log(refresh_url);
                        $.ajax({
                            type: 'POST',
                            headers: {
                                "cache-control": "no-cache"
                            },
                            url: refresh_url,
                            async: !0,
                            cache: !1,
                            success: function(resp) {
                                $('.cart-preview').replaceWith($(resp.preview).find('.blockcart'));
                                $(".blockcart.cart-preview").addClass('wb-blockcart');
                                if (typeof show_popup != 'undefined' && !show_popup) {
                                    $(".blockcart.cart-preview").removeClass('blockcart')
                                }
                                createModalAndDropdown(1, 1);
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                            }
                        })
                    } else {
                        showWbNotification('error', 'delete', !1)
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                }
            })
        }
        return !1
    })
    $('.wb-input-product-quantity').focusout(function() {
        updateQuantityProductDropDown($(this))
    })
    $('.wb-input-product-quantity').keyup(function(event) {
        if (event.keyCode == 13) {
            updateQuantityProductDropDown($(this))
        }
    })
    var timer;
    var flag = !1;
    $('.wb-bt-product-quantity-down, .wb-bt-product-quantity-up').on('touchstart click', function() {
        if (flag == !0) {
            flag = !1;
            clearTimeout(timer)
        }
        flag = !0;
        var action = 'up';
        var input_target = $(this).parents('.wb-dropdown-cart-item').find('.wb-input-product-quantity');
        var input_quantity = parseInt(input_target.val());
        var quantity_update;
        if ($(this).hasClass('wb-bt-product-quantity-down')) {
            action = 'down'
        }
        if (action == 'up') {
            quantity_update = input_quantity + 1
        }
        if (action == 'down') {
            quantity_update = input_quantity - 1
        }
        input_target.val(quantity_update);
        timer = setTimeout(function() {
            flag = !1;
            updateQuantityProductDropDown(input_target)
        }, 800);
        return !1
    })
}

function updateQuantityProductDropDown($element) {
    var $this = $element;
    var product_quantity = $this.data('product-quantity');
    var min_quantity = $this.data('min-quantity');
    var max_quantity = $this.data('quantity-available');
    var input_quantity = $this.val();
    if (Math.floor(input_quantity) == input_quantity && $.isNumeric(input_quantity) && input_quantity > 0) {} else {
        showWbNotification('normal', 'check', !1);
        $this.val(product_quantity);
        return
    }
    if (parseInt(input_quantity) < parseInt(min_quantity)) {
        showWbNotification('warning', 'min', min_quantity);
        $this.val(product_quantity);
        return !1
    }
    var qty = parseInt(input_quantity) - parseInt(product_quantity);
    if (qty == 0) {
        return
    }
    var id_product = $this.data('id-product');
    var id_product_attribute = $this.data('id-product-attribute');
    var id_customization = $this.data('id-customization');
    $this.removeData('check-outstock');
    var check_product_outstock = !0;
    var parent_obj = $this.parents('.wb-dropdown-cart-item');
    parent_obj.addClass('updating');
    parent_obj.find('.wb-dropdown-overlay').show();
    parent_obj.find('.wb-dropdown-cssload-speeding-wheel').show();
    checkProductOutStock(id_product, id_product_attribute, id_customization, input_quantity, $this, !1);
    check_data_outstock = setInterval(function() {
        if (typeof $element.data('check-outstock') != 'undefined') {
            clearInterval(check_data_outstock);
            if (!$this.data('check-outstock')) {
                showWbNotification('warning', 'max', !1);
                $this.val(product_quantity);
                check_product_outstock = !1;
                parent_obj.find('.wb-dropdown-overlay').hide();
                parent_obj.find('.wb-dropdown-cssload-speeding-wheel').hide();
                parent_obj.removeClass('updating')
            }
            if (!check_product_outstock) {
                return !1
            }
            if ($('.js-cart-line-product-quantity').length) {
                var e = $.Event("keyup");
                e.keyCode = 13;
                $('.remove-from-cart[data-id-product="' + id_product + '"][data-id-product-attribute="' + id_product_attribute + '"][data-id-customization="' + id_customization + '"]').parents('.cart-item').find('.js-cart-line-product-quantity').val(input_quantity).trigger(e)
            } else {
                var link_url = $this.data('update-url');
                var refresh_url = $('.blockcart.cart-preview').data('refresh-url');
                var op = '';
                if (qty > 0) {
                    op = 'up'
                } else {
                    op = 'down'
                }
                $.ajax({
                    type: 'POST',
                    headers: {
                        "cache-control": "no-cache"
                    },
                    url: link_url,
                    async: !0,
                    cache: !1,
                    data: {
                        "ajax": 1,
                        "action": "update",
                        "qty": Math.abs(qty),
                        "op": op,
                    },
                    success: function(result) {
                        var obj = $.parseJSON(result);
                        parent_obj.find('.wb-dropdown-overlay').hide();
                        parent_obj.find('.wb-dropdown-cssload-speeding-wheel').hide();
                        parent_obj.removeClass('updating');
                        if (obj.success) {
                            $('.wb-input-product-quantity[data-id-product="' + id_product + '"][data-id-product-attribute="' + id_product_attribute + '"][data-id-customization="' + id_customization + '"]').val(input_quantity).data('product-quantity', input_quantity);
                            showWbNotification('success', 'update', !1);
                            $.ajax({
                                type: 'POST',
                                headers: {
                                    "cache-control": "no-cache"
                                },
                                url: refresh_url,
                                async: !0,
                                cache: !1,
                                success: function(resp) {
                                    $('.blockcart').replaceWith($(resp.preview).find('.blockcart'));
                                    $(".blockcart.cart-preview").addClass('wb-blockcart');
                                    if (typeof show_popup != 'undefined' && !show_popup) {
                                        $(".blockcart.cart-preview").removeClass('blockcart')
                                    }
                                    createModalAndDropdown(1, 1)
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                                }
                            })
                        } else {
                            showWbNotification('error', 'update', !1)
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
                    }
                })
            }
        }
    }, 10)
}
var OnlyOneCartClickEventStatus = true; //Webibazaar Update (05-02-2019)
function createModalAndDropdown($only_dropdown, $only_total) {
    if (typeof enable_dropdown_defaultcart != 'undefined') {

        if (enable_dropdown_defaultcart) {
            if ($('.blockcart.cart-preview').length) {
                $('.blockcart.cart-preview').addClass('wb-blockcart show-wb-loading').append('<div class="cssload-piano"><div class="cssload-rect1"></div><div class="cssload-rect2"></div><div class="cssload-rect3"></div></div>');
            } else {
                $('.wb-blockcart.cart-preview').addClass('show-wb-loading').append('<div class="cssload-piano"><div class="cssload-rect1"></div><div class="cssload-rect2"></div><div class="cssload-rect3"></div></div>');
            }
            $('.wb-blockcart.cart-preview .cssload-piano').show();
            $('.wb-blockcart.cart-preview.show-wb-loading').data('type', type_dropdown_defaultcart);
            if (typeof type_dropdown_defaultcart != 'undefined') {          
                //console.log("Hello--");               
                if (type_dropdown_defaultcart == 'dropdown' || type_dropdown_defaultcart == 'dropup') {
                    if(OnlyOneCartClickEventStatus){
                        //console.log("Enter true");
                        $(document).on('click','.blockcart.cart-preview',function(e) {
                              //e.preventDefault();
                            //console.log("click cart");
                            showDropDownCart($(this), 'defaultcart');
                            return !1                         
                        })
                        OnlyOneCartClickEventStatus = false;
                    }
                }
            }
        } else {
            $('.blockcart.cart-preview').addClass('wb-blockcart');
        }
    }
    $.ajax({
        type: 'POST',
        headers: {
            "cache-control": "no-cache"
        },
        url: prestashop.urls.base_url + 'modules/wbfeature/psajax.php?rand=' + new Date().getTime(),
        async: !0,
        cache: !1,
        data: {
            "action": "render-modal",
            "only_dropdown": $only_dropdown,
            "only_total": $only_total
        },
        success: function(result) {
            if (result != '') {
                $('.wb-blockcart.cart-preview .cssload-piano').hide();
                
                if (result.dropdown != '') {
                    
                    if (!$('.wb-dropdown-cart').length) {
                        if (typeof type_dropdown_defaultcart != 'undefined' && (type_dropdown_defaultcart == 'dropdown' || type_dropdown_defaultcart == 'dropup')) {
                            $('.blockcart.cart-preview').after('<div class="wb-dropdown-cart defaultcart ' + type_dropdown_defaultcart + '"></div>')
                            //console.log("Up Call Updare My");
                        }
                    } else {
                        //console.log("Updare My");
                        $('.wb-dropdown-cart').addClass('update')
                    }
                    if ($('.wb-dropdown-cart-content').length) {
                        if ($only_total == 1) {
                            $('.wb-dropdown-cart-content .wb-dropdown-total').replaceWith(result.dropdown);
                            var check_number_cartitem = 3;
                            if (typeof number_cartitem_display != 'undefined') {
                                check_number_cartitem = number_cartitem_display
                            }
                        } else {
                            $('.wb-dropdown-cart-content').replaceWith(result.dropdown);
                            activeDropdownEvent()
                        }
                    } else {

                        $('.wb-dropdown-cart').append(result.dropdown);
                        activeDropdownEvent()
                    }
                } else {
                    if ($('.wb-dropdown-cart').length) {
                        $('.wb-dropdown-cart').remove()
                    }
                }

                if (result.modal != '') {
                    $('body').append(result.modal);
                    activeEventModal()
                }
                if (result.notification != '') {
                    $('body').append(result.notification)
                }
            } else {
                alert(add_cart_error)
            }           
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
        }
    })
}

function activeEventNotification() {
    $(".wb-notification .notification").click(function() {
        $(this).removeClass('show').addClass("closed").parent().addClass('disable')
    })
}

function showWbNotification($status, $action, $special_parameter) {
    if (!$('.wb-notification').hasClass('active')) {
        $('.wb-notification').addClass('active')
    }
    var clone_obj = '';
    clone_obj = $('.wb-temp-' + $status + '>div').clone();
    clone_obj.find('.noti-' + $action).addClass('active');
    if ($special_parameter && $special_parameter != '') {
        clone_obj.find('.noti-' + $action).find('.noti-special').text($special_parameter)
    }
    $('.wb-notification').append(clone_obj);
    setTimeout(function() {
        clone_obj.find('.notification').addClass('show')
    }, 100);
    activeEventNotification();
    setTimeout(function() {
        clone_obj.find('.notification').removeClass('show').addClass("closed").parent().addClass('disable')
    }, 5000)
}

function checkProductOutStock($id_product, $id_product_attribute, $id_customization, $quantity, $element, $check_product_in_cart) {
    $.ajax({
        type: 'POST',
        headers: {
            "cache-control": "no-cache"
        },
        url: prestashop.urls.base_url + 'modules/wbfeature/psajax.php?rand=' + new Date().getTime(),
        async: !0,
        cache: !1,
        data: {
            "action": "check-product-outstock",
            "id_product": $id_product,
            "id_product_attribute": $id_product_attribute,
            "id_customization": $id_customization,
            "quantity": $quantity,
            "check_product_in_cart": $check_product_in_cart
        },
        success: function(result) {
            if (result != '') {
                var obj = $.parseJSON(result);
                $element.data('check-outstock', obj.success)
            } else {
                alert(add_cart_error)
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("TECHNICAL ERROR: \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus)
        }
    })
}

function updateClassCartItem() {
    $('.wb-dropdown-list-item').each(function() {
        $(this).find('.wb-dropdown-cart-item').first().addClass('first');
        $(this).find('.wb-dropdown-cart-item').last().addClass('last');

    })
}

function showModalPopupCart(modal) {
    if ($('#blockcart-modal').length) {
        $('#blockcart-modal').remove()
    }
    $('body').append(modal);
    $('#blockcart-modal').modal('show')
};