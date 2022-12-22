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
    $(document).on('click', '.remove-countdown', function(e) {
        if (!confirm(wbpc_remove_confirm_txt)) {
            return false;
        }

        var id_countdown = $(this).data('id-countdown');
        var $this = $(this);

        $.ajax({
            url: wbpc_ajax_url,
            data: {ajax: true, action: 'removeCountdown', id_countdown: id_countdown},
            method: 'post',
            success: function () {
                $this.parents('tr').fadeOut(500, function(){
                    $(this).remove();
                });
            }
        });
        
        e.preventDefault();
    });

    $('#wbpc_show_pro').on('click', function (e) {
        $('#wbpc_pro_features_content').slideDown();
        $(this).remove();

        e.preventDefault();
    });
});