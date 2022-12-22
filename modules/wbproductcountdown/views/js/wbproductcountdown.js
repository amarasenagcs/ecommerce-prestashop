/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * @author    Presta.Site
 * @copyright 2016 Presta.Site
 * @license   LICENSE.txt
 */
$(function () {
    initCountdown();

    // Blocklayered etc compatibility
    if (wbpc_wbv < 1.7 && $('#layered_block_left').length) {
        $(document).ajaxComplete(function () {
            initCountdown('.wbpc-inactive');
        });
    } else if (typeof prestashop == 'object' && typeof prestashop.on == 'function') {
        prestashop.on('updateProductList', function () {
            initCountdown('.wbpc-inactive');
        });

        prestashop.on('updatedProduct', function (event) {
            initCountdown('.wbpc-inactive');
        });
    }
});

// Parse countdown string to an object
function wbpc_strfobj(str) {
    var pieces = str.split(':');
    var obj = {};
    wbpc_labels.forEach(function(label, i) {
        obj[label] = pieces[i]
    });
    return obj;
}
// Return the time components that diffs
function wbpc_diff(obj1, obj2) {
    var diff = [];
    wbpc_labels.forEach(function(key) {
        if (obj1[key] !== obj2[key]) {
            diff.push(key);
        }
    });
    return diff;
}

function initCountdown(selector) {
    selector = (selector ? selector : '.wbproductcountdown');
    $(selector).each(function(){
        $(this).removeClass('wbpc-inactive');
        var to = parseInt($(this).data('to'));
        var now = + new Date();
        if (!to || to < now) {
            $(this).hide();
            return true;
        }

        var labels = wbpc_labels,
            template = _.template(wbpc_countdown_tpl),
            $wbpc = $(this).find('.wbpc-main');
        if (wbpc_show_weeks) {
            var currDate = '00:00:00:00:00';
            var nextDate = '00:00:00:00:00';
        } else {
            var currDate = '00:00:00:00';
            var nextDate = '00:00:00:00';
        }

        // Build the layout
        var initData = wbpc_strfobj(currDate);
        labels.forEach(function(label, i) {
            $wbpc.append(template({
                curr: initData[label],
                next: initData[label],
                label: label,
                label_lang: wbpc_labels_lang[label]
            }));
        });
        // Starts the countdown
        $wbpc.countdown(to, function(event) {
            var now = + new Date();

            if (to < now) {
                $wbpc.parents('.wbproductcountdown').hide(400);
            }

            var data;
            if (wbpc_show_weeks)
                var newDate = event.strftime('%w:%d:%H:%M:%S');
            else
                var newDate = event.strftime('%D:%H:%M:%S');

            if (newDate !== nextDate) {
                currDate = nextDate;
                nextDate = newDate;
                // Setup the data
                data = {
                    'curr': wbpc_strfobj(currDate),
                    'next': wbpc_strfobj(nextDate)
                };
                // Apply the new values to each node that changed
                wbpc_diff(data.curr, data.next).forEach(function(label) {
                    var selector = '.%s'.replace(/%s/, label),
                        $node = $wbpc.find(selector);
                    // Update the node
                    $node.removeClass('flip hidden');
                    $node.find('.curr').text(data.curr[label]);
                    $node.find('.next').text(data.next[label]);
                    // Wait for a repaint to then flip
                    _.delay(function($node) {
                        $node.addClass('flip');
                    }, 50, $node);
                });
            }
        });
    });
}

var wbpc_countdown_tpl = '' +
        '<div class="time <%= label %>">' +
            '<span class="count curr top"><%= curr %></span>' +
            '<span class="count next top"><%= next %></span>' +
            '<span class="count next bottom"><%= next %></span>' +
            '<span class="count curr bottom"><%= curr %></span>' +
            '<span class="label"><%= label_lang.length < 6 ? label_lang : label_lang.substr(0, 3)  %></span>' +
    '</div>';