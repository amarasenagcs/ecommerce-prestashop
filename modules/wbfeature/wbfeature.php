<?php
/**
* 2007-2019 PrestaShop
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
*  @copyright  2007-2019 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once(_PS_MODULE_DIR_.'wbfeature/classes/ProductReviewCriterion.php');
require_once(_PS_MODULE_DIR_.'wbfeature/classes/ProductReview.php');
require_once(_PS_MODULE_DIR_.'wbfeature/classes/CompareProduct.php');
require_once(_PS_MODULE_DIR_.'wbfeature/classes/WishList.php');
//DONGND:: use library for get dropdown cart
use PrestaShop\PrestaShop\Adapter\Cart\CartPresenter;

class Wbfeature extends Module
{
    protected $config_form = false;
    private $link;
    public $link_cart;
    public $module_path;
    protected $_postErrors = array();
    
    public function __construct()
    {
        $this->name = 'wbfeature';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Webitheme';
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->need_instance = 0;
        $this->controllers = array('productscompare', 'mywishlist', 'viewwishlist');
        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;
        parent::__construct();

        $this->secure_key = Tools::encrypt($this->name);
        $this->displayName = $this->l('Wb Feature');
        $this->description = $this->l('Wb feature for prestashop 1.7: ajax cart, dropdown cart, fly cart, review, compare, wishlist at product list');
        $this->link = $this->context->link;
                
        $this->module_path = $this->local_path;
        Configuration::updateValue('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART', 'dropdown');
        Configuration::updateValue('WBFEATURE_SHOW_POPUP', '1');
        Configuration::updateValue('WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART', '3');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        // Configuration::updateValue('WBFEATURE_LIVE_MODE', false);

        // return parent::install() &&
            // $this->registerHook('header') &&
            // $this->registerHook('displayWbCartButton') &&
            // $this->registerHook('backOfficeHeader');
        if (parent::install() && $this->registerWbHook()) {
            $this->createConfiguration();
            $res = true;
            /* Creates tables */
            $res &= $this->createTables();
            Configuration::updateValue('AP_INSTALLED_WBFEATURE', '1');
           
            $id_parent = Tab::getIdFromClassName('IMPROVE');
            
            $class = 'Admin'.Tools::ucfirst($this->name).'Management';
            $tab1 = new Tab();
            $tab1->class_name = $class;
            $tab1->module = $this->name;
            $tab1->id_parent = $id_parent;
            $langs = Language::getLanguages(false);
            foreach ($langs as $l) {
                # validate module
                $tab1->name[$l['id_lang']] = $this->l('Wb Feature Management');
            }
//            $id_tab1 = $tab1->add(true, false);
            $tab1->add(true, false);
            
            # insert icon for tab
            Db::getInstance()->execute(
                'UPDATE `'._DB_PREFIX_.'tab` SET `icon` = "star" WHERE `id_tab` = "'.(int)$tab1->id.'"'
            );
            $this->installModuleTab(
                'Wb Feature Configuration',
                'module',
                'AdminWbfeatureManagement'
            );
            $this->installModuleTab(
                'Product Review Management',
                'reviews',
                'AdminWbfeatureManagement'
            );

            return (bool)$res;
        }
        return false;
    }

    public function uninstall()
    {
        // Configuration::deleteByName('WBFEATURE_LIVE_MODE');

        // return parent::uninstall();
        if (parent::uninstall() && $this->unregisterWbHook()) {
            $res = true;

            $this->uninstallModuleTab('management');
            // $this->uninstallModuleTab('dashboard');
            // $this->uninstallModuleTab('categories');
            // $this->uninstallModuleTab('blogs');
            $this->uninstallModuleTab('reviews');
            $this->uninstallModuleTab('module');
            
            $res &= $this->deleteTables();
            $this->deleteConfiguration();

            return (bool)$res;
        }
        return false;
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $output = '';
        //DONGND:: correct module
        // if (Tools::getValue('correctmodule')) {
        //     $this->correctModule();
        // }
        
        // if (Tools::getValue('success')) {
        //     switch (Tools::getValue('success')) {
        //         case 'correct':
        //             $output .= $this->displayConfirmation(
        //                 $this->l(
        //                     'Correct Module is successful'
        //                 )
        //             );
        //             break;
        //     }
        // }
        
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitWbfeatureConfig')) == true) {
            $this->postValidation();
            if (!count($this->_postErrors)) {
                $this->postProcess();
            } else {
                foreach ($this->_postErrors as $err) {
                    $output .= $this->displayError($err);
                }
            }
        }
        // $this->context->smarty->assign('module_dir', $this->_path);
        $output .= $this->renderGroupConfig();
        
        return $output;
    }
    
    public function renderGroupConfig()
    {
        // $type_dropdown = array(
        //     array(
        //         'id_type' => 'dropdown',
        //         'name_type' => $this->l('Dropdown'),
        //     ),
        //     array(
        //         'id_type' => 'dropup',
        //         'name_type' => $this->l('Dropup'),
        //     ),
        //     array(
        //         'id_type' => 'slidebar_left',
        //         'name_type' => $this->l('Slidebar Left'),
        //     ),
        //     array(
        //         'id_type' => 'slidebar_right',
        //         'name_type' => $this->l('Slidebar Right'),
        //     ),
        //     array(
        //         'id_type' => 'slidebar_top',
        //         'name_type' => $this->l('Slidebar Top'),
        //     ),
        //     array(
        //         'id_type' => 'slidebar_bottom',
        //         'name_type' => $this->l('Slidebar Bottom'),
        //     ),
            
        // );
        // $type_position = array(
        //     array(
        //         'id_type' => 'fixed',
        //         'name_type' => $this->l('Fixed'),
        //     ),
        //     array(
        //         'id_type' => 'absolute',
        //         'name_type' => $this->l('Absolute'),
        //     ),
        // );
        $type_unit = array(
            array(
                'id_type' => 'percent',
                'name_type' => $this->l('Percent'),
            ),
            array(
                'id_type' => 'pixel',
                'name_type' => $this->l('Pixel'),
            ),
        );
        $type_vertical = array(
            array(
                'id_type' => 'top',
                'name_type' => $this->l('Top'),
            ),
            array(
                'id_type' => 'bottom',
                'name_type' => $this->l('Bottom'),
            ),
        );
        $type_horizontal = array(
            array(
                'id_type' => 'left',
                'name_type' => $this->l('Left'),
            ),
            array(
                'id_type' => 'right',
                'name_type' => $this->l('Right'),
            ),
        );
        // $type_effect = array(
        //     array(
        //         'id_type' => 'none',
        //         'name_type' => $this->l('None'),
        //     ),
        //     array(
        //         'id_type' => 'fade',
        //         'name_type' => $this->l('Fade'),
        //     ),
        //     array(
        //         'id_type' => 'shake',
        //         'name_type' => $this->l('Shake'),
        //     ),
        // );
        $fields_form = array();
        $fields_form[0]['form'] = array(

                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'WBFEATURE_DEFAULT_TAB',
                        'default' => '',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Button Cart At Product List'),
                        'name' => 'WBFEATURE_ENABLE_AJAXCART',
                        'is_bool' => true,
                        // 'desc' => $this->l('Show Button Cart At Product List'),
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_AJAXCART_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_AJAXCART_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Select Attribute'),
                        'name' => 'WBFEATURE_ENABLE_SELECTATTRIBUTE',
                        'is_bool' => true,
                        // 'desc' => $this->l('Show Select Attribute'),
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_SELECTATTRIBUTE_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_SELECTATTRIBUTE_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Update Product Label After Select Attribute'),
                        'name' => 'WBFEATURE_ENABLE_UPDATELABEL',
                        'is_bool' => true,
                        'desc' => $this->l('Only for enable select attribute'),
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_UPDATELABEL_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_UPDATELABEL_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Input Quantity'),
                        'name' => 'WBFEATURE_ENABLE_INPUTQUANTITY',
                        'is_bool' => true,
                        // 'desc' => $this->l('Show Input Quantity'),
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_INPUTQUANTITY_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_INPUTQUANTITY_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    // // array(
                    // //     'type' => 'switch',
                    // //     'label' => $this->l('Enable Flycart Effect'),
                    // //     'name' => 'WBFEATURE_ENABLE_FLYCART_EFFECT',
                    // //     'is_bool' => true,
                    // //     'values' => array(
                    // //         array(
                    // //             'id' => 'WBFEATURE_ENABLE_FLYCART_EFFECT_on',
                    // //             'value' => 1,
                    // //             'label' => $this->l('Enabled')
                    // //         ),
                    // //         array(
                    // //             'id' => 'WBFEATURE_ENABLE_FLYCART_EFFECT_off',
                    // //             'value' => 0,
                    // //             'label' => $this->l('Disabled')
                    // //         )
                    // //     ),
                    // // ),
                    // // array(
                    // //     'type' => 'switch',
                    // //     'label' => $this->l('Enable Notification'),
                    // //     'name' => 'WBFEATURE_ENABLE_NOTIFICATION',
                    // //     'desc' => $this->l('Show notification when add cart successful'),
                    // //     'is_bool' => true,
                    // //     'values' => array(
                    // //         array(
                    // //             'id' => 'WBFEATURE_ENABLE_NOTIFICATION_on',
                    // //             'value' => 1,
                    // //             'label' => $this->l('Enabled')
                    // //         ),
                    // //         array(
                    // //             'id' => 'WBFEATURE_ENABLE_NOTIFICATION_off',
                    // //             'value' => 0,
                    // //             'label' => $this->l('Disabled')
                    // //         )
                    // //     ),
                    // // ),
                    // array(
                    //     'type' => 'switch',
                    //     'label' => $this->l('Show Popup After Add Cart'),
                    //     'name' => 'WBFEATURE_SHOW_POPUP',
                    //     'desc' => $this->l(
                    //         'Default is ON. You can turn OFF and turn ON "Notification" instead'
                    //     ),
                    //     'is_bool' => true,
                    //     'values' => array(
                    //         array(
                    //             'id' => 'WBFEATURE_SHOW_POPUP_on',
                    //             'value' => 1,
                    //             'label' => $this->l('Enabled')
                    //         ),
                    //         array(
                    //             'id' => 'WBFEATURE_SHOW_POPUP_off',
                    //             'value' => 0,
                    //             'label' => $this->l('Disabled')
                    //         )
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'html',
                    //     'name' => 'html_data',
                    //     'html_content' => '<hr>',
                    // ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Dropdown Cart (Default Cart)'),
                        'name' => 'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Type Dropdown Cart (Default Cart)'),
                    //     'name' => 'WBFEATURE_TYPE_DROPDOWN_DEFAULTCART',
                    //     'options' => array(
                    //         'query' => $type_dropdown,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'html',
                    //     'name' => 'html_data',
                    //     'html_content' => '<hr>',
                    // ),
                    // array(
                    //     'type' => 'switch',
                    //     'label' => $this->l('Show Dropdown Cart (Fly Cart)'),
                    //     'name' => 'WBFEATURE_ENABLE_DROPDOWN_FLYCART',
                    //     'is_bool' => true,
                    //     'values' => array(
                    //         array(
                    //             'id' => 'WBFEATURE_ENABLE_DROPDOWN_FLYCART_on',
                    //             'value' => 1,
                    //             'label' => $this->l('Enabled')
                    //         ),
                    //         array(
                    //             'id' => 'WBFEATURE_ENABLE_DROPDOWN_FLYCART_off',
                    //             'value' => 0,
                    //             'label' => $this->l('Disabled')
                    //         )
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Type Dropdown Cart (Fly Cart)'),
                    //     'name' => 'WBFEATURE_TYPE_DROPDOWN_FLYCART',
                    //     'options' => array(
                    //         'query' => $type_dropdown,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Type Effect (Fly Cart)'),
                    //     'name' => 'WBFEATURE_TYPE_EFFECT_FLYCART',
                    //     'desc' => $this->l('Only when "Flycart Effect" ON'),
                    //     'options' => array(
                    //         'query' => $type_effect,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Type Position (Fly Cart)'),
                    //     'name' => 'WBFEATURE_TYPE_POSITION_FLYCART',
                    //     'options' => array(
                    //         'query' => $type_position,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Position By Vertical (Fly Cart)'),
                    //     'hint' => $this->l(
                    //         'Select type of distance between "Fly cart" and
                    //          the top edge or the bottom edge of window (browser)'
                    //     ),
                    //     'name' => 'WBFEATURE_POSITION_VERTICAL_FLYCART',
                    //     'options' => array(
                    //         'query' => $type_vertical,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'text',
                    //     'label' => $this->l('Position By Vertical Value (Fly Cart)'),
                    //     'name' => 'WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART',
                    //     'lang' => false,
                    //     'desc' => $this->l(
                    //         'Must has value from 0 to 100 with the unit type below is percent'
                    //     )
                    // ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Position By Vertical Unit (Fly Cart)'),
                    //     'name' => 'WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART',
                    //     'options' => array(
                    //         'query' => $type_unit,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Position By Horizontal (Fly Cart)'),
                    //     'hint' => $this->l(
                    //         'Select type of distance between "Fly cart" and
                    //          the left edge or the right edge of window (browser)'
                    //     ),
                    //     'name' => 'WBFEATURE_POSITION_HORIZONTAL_FLYCART',
                    //     'options' => array(
                    //         'query' => $type_horizontal,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'text',
                    //     'label' => $this->l('Position By Horizontal Value (Fly Cart)'),
                    //     'name' => 'WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART',
                    //     'lang' => false,
                    //     'desc' => $this->l(
                    //         'Must has value from 0 to 100 with the unit type below is percent'
                    //     )
                    // ),
                    // array(
                    //     'type' => 'select',
                    //     'label' => $this->l('Position By Horizontal Unit (Fly Cart)'),
                    //     'name' => 'WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART',
                    //     'options' => array(
                    //         'query' => $type_unit,
                    //         'id' => 'id_type',
                    //         'name' => 'name_type'
                    //     ),
                    // ),
                    // array(
                    //     'type' => 'html',
                    //     'name' => 'html_data',
                    //     'html_content' => '<hr>',
                    // ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Overlay Background (All Cart)'),
                        'name' => 'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART',
                        'desc' => $this->l(
                            'Only for "Slidebar" type. Turn OFF to allow "Add to cart" for Slidebar'
                        ),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Update Quantity (All Cart)'),
                        'name' => 'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Button Up/Down (All Cart)'),
                        'name' => 'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART',
                        'desc' => $this->l('Only when turn ON update quantity'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Product Combination (All Cart)'),
                        'name' => 'WBFEATURE_SHOW_COMBINATION_ALLCART',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_SHOW_COMBINATION_ALLCART_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_SHOW_COMBINATION_ALLCART_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Product Customization (All Cart)'),
                        'name' => 'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Width Of Cart Item (All Cart)'),
                        'name' => 'WBFEATURE_WIDTH_CARTITEM_ALLCART',
                        'suffix' => $this->l('Pixel'),
                        'lang' => false,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Height Of Cart Item (All Cart)'),
                        'name' => 'WBFEATURE_HEIGHT_CARTITEM_ALLCART',
                        'suffix' => $this->l('Pixel'),
                        'lang' => false,
                    ),
                    // array(
                    //     'type' => 'text',
                    //     'label' => $this->l('Number Cart Item To Display (All Cart)'),
                    //     'name' => 'WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART',
                    //     'desc' => $this->l(
                    //         'Ony for "Dropup/Dropdown" type. When the total of cart item
                    //          is greater this config, the scrollbar will be displayed'
                    //     ),
                    //     'lang' => false,
                    // ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Width (Notification)'),
                        'name' => 'WBFEATURE_WIDTH_NOTIFICATION',
                        'suffix' => $this->l('Pixel'),
                        'lang' => false,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Position By Vertical (Notification)'),
                        'hint' => $this->l(
                            'Select type of distance between "Notification" and
                             the top edge or the bottom edge of window (browser)'
                        ),
                        'name' => 'WBFEATURE_POSITION_VERTICAL_NOTIFICATION',
                        'options' => array(
                            'query' => $type_vertical,
                            'id' => 'id_type',
                            'name' => 'name_type'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Position By Vertical Value (Notification)'),
                        'name' => 'WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION',
                        'lang' => false,
                        'desc' => $this->l(
                            'Must has value from 0 to 100 with the unit type below is percent'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Position By Vertical Unit (Notification)'),
                        'name' => 'WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION',
                        'options' => array(
                            'query' => $type_unit,
                            'id' => 'id_type',
                            'name' => 'name_type'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Position By Horizontal (Notification)'),
                        'hint' => $this->l(
                            'Select type of distance between "Fly cart" and
                             the left edge or the right edge of window (browser)'
                        ),
                        'name' => 'WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION',
                        'options' => array(
                            'query' => $type_horizontal,
                            'id' => 'id_type',
                            'name' => 'name_type'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Position By Horizontal Value (Notification)'),
                        'name' => 'WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION',
                        'lang' => false,
                        'desc' => $this->l(
                            'Must has value from 0 to 100 with the unit type below is percent'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Position By Horizontal Unit (Notification)'),
                        'name' => 'WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION',
                        'options' => array(
                            'query' => $type_unit,
                            'id' => 'id_type',
                            'name' => 'name_type'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default'
                )
        );
        //DONGND:: image setting
        $fields_form[1]['form'] = array(
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable product reviews'),
                    'name' => 'WBFEATURE_ENABLE_PRODUCT_REVIEWS',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_ENABLE_PRODUCT_REVIEWS_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_ENABLE_PRODUCT_REVIEWS_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                // array(
                //     'type' => 'switch',
                //     'label' => $this->l('Show product reviews at list product'),
                //     'name' => 'WBFEATURE_SHOW_PRODUCT_REVIEWS_LISTPRODUCT',
                //     'is_bool' => true,
                //     //'desc' => $this->l('Show Input Quantity'),
                //     'values' => array(
                //         array(
                //             'id' => 'WBFEATURE_SHOW_PRODUCT_REVIEWS_LISTPRODUCT_on',
                //             'value' => 1,
                //             'label' => $this->l('Enabled')
                //         ),
                //         array(
                //             'id' => 'WBFEATURE_SHOW_PRODUCT_REVIEWS_LISTPRODUCT_off',
                //             'value' => 0,
                //             'label' => $this->l('Disabled')
                //         )
                //     ),
                // ),
                // array(
                //     'type' => 'switch',
                //     'label' => $this->l('Show number product reviews at list product'),
                //     'name' => 'WBFEATURE_SHOW_NUMBER_PRODUCT_REVIEWS_LISTPRODUCT',
                //     'is_bool' => true,
                //     //'desc' => $this->l('Show Input Quantity'),
                //     'values' => array(
                //         array(
                //             'id' => 'WBFEATURE_SHOW_NUMBER_PRODUCT_REVIEWS_LISTPRODUCT_on',
                //             'value' => 1,
                //             'label' => $this->l('Enabled')
                //         ),
                //         array(
                //             'id' => 'WBFEATURE_SHOW_NUMBER_PRODUCT_REVIEWS_LISTPRODUCT_off',
                //             'value' => 0,
                //             'label' => $this->l('Disabled')
                //         )
                //     ),
                // ),
                // array(
                //     'type' => 'switch',
                //     'label' => $this->l('Show zero product reviews at list product'),
                //     'name' => 'WBFEATURE_SHOW_ZERO_PRODUCT_REVIEWS_LISTPRODUCT',
                //     'is_bool' => true,
                //     //'desc' => $this->l('Show Input Quantity'),
                //     'values' => array(
                //         array(
                //             'id' => 'WBFEATURE_SHOW_ZERO_PRODUCT_REVIEWS_LISTPRODUCT_on',
                //             'value' => 1,
                //             'label' => $this->l('Enabled')
                //         ),
                //         array(
                //             'id' => 'WBFEATURE_SHOW_ZERO_PRODUCT_REVIEWS_LISTPRODUCT_off',
                //             'value' => 0,
                //             'label' => $this->l('Disabled')
                //         )
                //     ),
                // ),
                // array(
                //     'type' => 'switch',
                //     'label' => $this->l('All reviews must be validated by an employee'),
                //     'name' => 'WBFEATURE_PRODUCT_REVIEWS_MODERATE',
                //     'is_bool' => true,
                //     //'desc' => $this->l('Show Input Quantity'),
                //     'values' => array(
                //         array(
                //             'id' => 'WBFEATURE_PRODUCT_REVIEWS_MODERATE_on',
                //             'value' => 1,
                //             'label' => $this->l('Enabled')
                //         ),
                //         array(
                //             'id' => 'WBFEATURE_PRODUCT_REVIEWS_MODERATE_off',
                //             'value' => 0,
                //             'label' => $this->l('Disabled')
                //         )
                //     ),
                // ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Allow usefull button'),
                    'name' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Allow report button'),
                    'name' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Allow guest reviews'),
                    'name' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Minimum time between 2 reviews from the same user'),
                    'name' => 'WBFEATURE_PRODUCT_REVIEWS_MINIMAL_TIME',
                    'lang' => false,
                    'suffix' => $this->l('second(s)'),
                ),
                
            ),
            'submit' => array('title' => $this->l('Save'), 'class' => 'btn btn-default')
        );
        //DONGND:: css setting
        $fields_form[2]['form'] = array(
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable product compare'),
                    'name' => 'WBFEATURE_ENABLE_PRODUCTCOMPARE',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_ENABLE_PRODUCTCOMPARE_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_ENABLE_PRODUCTCOMPARE_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show product compare at list product'),
                    'name' => 'WBFEATURE_SHOW_PRODUCTCOMPARE_LISTPRODUCT',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTCOMPARE_LISTPRODUCT_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTCOMPARE_LISTPRODUCT_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show product compare at product page'),
                    'name' => 'WBFEATURE_SHOW_PRODUCTCOMPARE_PRODUCTPAGE',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTCOMPARE_PRODUCTPAGE_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTCOMPARE_PRODUCTPAGE_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Number product comparison '),
                    'name' => 'WBFEATURE_COMPARATOR_MAX_ITEM',
                    'lang' => false,
                ),
            ),
            'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default')
        );

        //DONGND:: navigatior and direction
        $fields_form[3]['form'] = array(
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable product wishlist'),
                    'name' => 'WBFEATURE_ENABLE_PRODUCTWISHLIST',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_ENABLE_PRODUCTWISHLIST_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_ENABLE_PRODUCTWISHLIST_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show product wishlist at list product'),
                    'name' => 'WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show product wishlist at product page'),
                    'name' => 'WBFEATURE_SHOW_PRODUCTWISHLIST_PRODUCTPAGE',
                    'is_bool' => true,
                    //'desc' => $this->l('Show Input Quantity'),
                    'values' => array(
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTWISHLIST_PRODUCTPAGE_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'WBFEATURE_SHOW_PRODUCTWISHLIST_PRODUCTPAGE_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                
            ),
            'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default')
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->name_controller = 'wbfeature';
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitWbfeatureConfig';
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getGroupFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            
        );

        $globalform = $helper->generateForm($fields_form);
        
        //DONGND::
        $this->context->smarty->assign(array(
            'globalform' => $globalform,
            'url_admin' => $this->context->link->getAdminLink(
                'AdminModules'
            ).'&configure='.$this->name,
            'default_tab' => Configuration::get('WBFEATURE_DEFAULT_TAB'),
           
        ));
        return $this->context->smarty->fetch(
            $this->local_path.'views/templates/admin/panel.tpl'
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getGroupFieldsValues()
    {
        $list_value = array(
            'WBFEATURE_DEFAULT_TAB',
            'WBFEATURE_ENABLE_AJAXCART',
            'WBFEATURE_ENABLE_SELECTATTRIBUTE',
            'WBFEATURE_ENABLE_UPDATELABEL',
            'WBFEATURE_ENABLE_INPUTQUANTITY',
            'WBFEATURE_ENABLE_FLYCART_EFFECT',
            'WBFEATURE_ENABLE_NOTIFICATION',
            'WBFEATURE_SHOW_POPUP',
            'WBFEATURE_ENABLE_PRODUCT_REVIEWS',
            'WBFEATURE_SHOW_PRODUCT_REVIEWS_LISTPRODUCT',
            'WBFEATURE_SHOW_NUMBER_PRODUCT_REVIEWS_LISTPRODUCT',
            'WBFEATURE_SHOW_ZERO_PRODUCT_REVIEWS_LISTPRODUCT',
            'WBFEATURE_PRODUCT_REVIEWS_MODERATE',
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS',
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON',
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON',
            'WBFEATURE_PRODUCT_REVIEWS_MINIMAL_TIME',
            'WBFEATURE_ENABLE_PRODUCTCOMPARE',
            'WBFEATURE_SHOW_PRODUCTCOMPARE_LISTPRODUCT',
            'WBFEATURE_SHOW_PRODUCTCOMPARE_PRODUCTPAGE',
            'WBFEATURE_COMPARATOR_MAX_ITEM',
            'WBFEATURE_ENABLE_PRODUCTWISHLIST',
            'WBFEATURE_SHOW_PRODUCTWISHLIST_PRODUCTPAGE',
            'WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT',
            'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART',
            'WBFEATURE_TYPE_DROPDOWN_DEFAULTCART',
            // 'WBFEATURE_ENABLE_PUSHEFFECT_DEFAULTCART',
            'WBFEATURE_ENABLE_DROPDOWN_FLYCART',
            'WBFEATURE_TYPE_DROPDOWN_FLYCART',
            // 'WBFEATURE_ENABLE_PUSHEFFECT_FLYCART',
            'WBFEATURE_TYPE_POSITION_FLYCART',
            'WBFEATURE_POSITION_VERTICAL_FLYCART',
            'WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART',
            'WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART',
            'WBFEATURE_POSITION_HORIZONTAL_FLYCART',
            'WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART',
            'WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART',
            'WBFEATURE_TYPE_EFFECT_FLYCART',
            'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART',
            'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART',
            'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART',
            'WBFEATURE_SHOW_COMBINATION_ALLCART',
            'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART',
            'WBFEATURE_WIDTH_CARTITEM_ALLCART',
            'WBFEATURE_HEIGHT_CARTITEM_ALLCART',
            'WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART',
            'WBFEATURE_WIDTH_NOTIFICATION',
            'WBFEATURE_POSITION_VERTICAL_NOTIFICATION',
            'WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION',
            'WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION',
            'WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION',
            'WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION',
            'WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION',
        );
        $return = array();
        foreach ($list_value as $list_value_val) {
            $return[$list_value_val] = Configuration::get($list_value_val);
        }
        return $return;
    }
    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getGroupFieldsValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
        Tools::redirectAdmin(
            'index.php?controller=AdminModules&configure=wbfeature&token='.Tools::getAdminTokenLite(
                'AdminModules'
            ).'&conf=4'
        );
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addJS($this->_path.'/views/js/back.js');
        $this->context->controller->addCSS($this->_path.'/views/css/back.css');
        Media::addJsDef(
            array(
                'wbfeature_module_dir' => $this->_path,
            )
        );
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        if (Configuration::get('WBFEATURE_ENABLE_AJAXCART') ||
            Configuration::get('WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART')
        ) {
            $this->context->controller->addJS(
                $this->_path.'/views/js/wbfeature_cart.js'
            );
        }
        Media::addJsDef(
            array(
                'enable_flycart_effect' => (int)Configuration::get(
                    'WBFEATURE_ENABLE_FLYCART_EFFECT'
                ),
                'type_flycart_effect' => Configuration::get(
                    'WBFEATURE_TYPE_EFFECT_FLYCART'
                ),
                'enable_notification' => (int)Configuration::get(
                    'WBFEATURE_ENABLE_NOTIFICATION'
                ),
                'show_popup' => (int)Configuration::get(
                    'WBFEATURE_SHOW_POPUP'
                ),
            )
        );
        //DONGND:: ajax cart
        if (Configuration::get('WBFEATURE_ENABLE_AJAXCART')) {
            if (Configuration::get('WBFEATURE_ENABLE_SELECTATTRIBUTE')) {
                Media::addJsDef(
                    array(
                        'enable_product_label' => (int)Configuration::get(
                            'WBFEATURE_ENABLE_UPDATELABEL'
                        ),
                    )
                );
            }
        }
        $page_name = Dispatcher::getInstance()->getController();
        
        //DONGND:: dropdown cart
        if ((Configuration::get('WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART')
            ) && $page_name != 'order'
        ) {
            $this->context->controller->addJS(
                $this->_path.'/views/js/jquery.mousewheel.min.js'
            );
            $this->context->controller->addJS(
                $this->_path.'/views/js/jquery.mCustomScrollbar.js'
            );
            $this->context->controller->addCSS(
                $this->_path.'/views/css/jquery.mCustomScrollbar.css'
            );
            $type_dropdown_defaultcart = '';
            $type_dropdown_defaultcart = Configuration::get(
                'WBFEATURE_TYPE_DROPDOWN_DEFAULTCART'
            );
            if ($this->context->language->is_rtl) {
                if (Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_left') {
                    $type_dropdown_defaultcart = 'slidebar_right';
                }
                if (Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_right') {
                    $type_dropdown_defaultcart = 'slidebar_left';
                }
            }
            Media::addJsDef(
                array(
                    'enable_dropdown_defaultcart' => (int)Configuration::get(
                        'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART'
                    ),
                    'type_dropdown_defaultcart' => $type_dropdown_defaultcart,
                    'number_cartitem_display' => (int)Configuration::get('WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART'),
                    'width_cart_item' => Configuration::get(
                        'WBFEATURE_WIDTH_CARTITEM_ALLCART'
                    ),
                    'height_cart_item' => Configuration::get(
                        'WBFEATURE_HEIGHT_CARTITEM_ALLCART'
                    )
                )
            );
        }
        
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCT_REVIEWS')) {
            $this->context->controller->addJS(
                $this->_path.'/views/js/jquery.rating.pack.js'
            );
            $this->context->controller->addJS(
                $this->_path.'/views/js/wbfeature_review.js'
            );
        }
        // }
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTCOMPARE') &&
            Configuration::get('WBFEATURE_COMPARATOR_MAX_ITEM') > 0) {
            $this->context->controller->addJS(
                $this->_path.'/views/js/wbfeature_compare.js'
            );
            
            //DONGND:: add javascript param for compare
            $compared_products = array();
            if (Configuration::get('WBFEATURE_COMPARATOR_MAX_ITEM') &&
                isset($this->context->cookie->id_compare)) {
                $compared_products = CompareProduct::getCompareProducts(
                    $this->context->cookie->id_compare
                );
            }
            $comparator_max_item = (int)Configuration::get('WBFEATURE_COMPARATOR_MAX_ITEM');
            
            $productcompare_max_item = sprintf(
                $this->l(
                    'You cannot add more than %d product(s) to the product comparison'
                ),
                $comparator_max_item
            );
            Media::addJsDef(
                array(
                    'productcompare_url' => $this->link->getModuleLink('wbfeature', 'productscompare'),
                    'productcompare_add' => $this->l('The product has been added to list compare'),
                    'productcompare_viewlistcompare' => $this->l('View list compare'),
                    'productcompare_remove' => $this->l('The product was successfully removed from list compare'),
                    'comparator_max_item' => $comparator_max_item,
                    'compared_products' => (count($compared_products)>0) ? $compared_products : array(),
                    'productcompare_max_item' => $productcompare_max_item,
                    'buttoncompare_title_add' => $this->l('Add to Compare'),
                    'buttoncompare_title_remove' => $this->l('Remove from Compare'),
                )
            );
        }
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTWISHLIST')) {
            $this->context->controller->addJS($this->_path.'/views/js/wbfeature_wishlist.js');
            //DONGND:: add javascript param for wishlist
            if ($this->context->customer->isLogged()) {
                $isLogged = true;
            } else {
                $isLogged = false;
            }
            Media::addJsDef(
                array(
                    'wishlist_url' => $this->link->getModuleLink('wbfeature', 'mywishlist'),
                    'wishlist_add' => $this->l('The product was successfully added to your wishlist'),
                    'wishlist_viewwishlist' => $this->l('View your wishlist'),
                    'wishlist_remove' => $this->l('The product was successfully removed from your wishlist'),
                    'buttonwishlist_title_add' => $this->l('Add to Wishlist'),
                    'buttonwishlist_title_remove' => $this->l('Remove from WishList'),
                    'wishlist_loggin_required' => $this->l('You must be logged in to manage your wishlist'),
                    'isLogged' => $isLogged,
                    'wishlist_cancel_txt' => $this->l('Cancel'),
                    'wishlist_ok_txt' => $this->l('Ok'),
                    'wishlist_send_txt' => $this->l('Send'),
                    'wishlist_reset_txt' => $this->l('Reset'),
                    'wishlist_send_wishlist_txt' => $this->l('Send wishlist'),
                    'wishlist_email_txt' => $this->l('Email'),
                    'wishlist_confirm_del_txt' => $this->l('Delete selected item?'),
                    'wishlist_del_default_txt' => $this->l('Cannot delete default wishlist'),
                    'wishlist_quantity_required' => $this->l('You must enter a quantity'),
                )
            );
        }
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCT_REVIEWS')) {
            Media::addJsDef(
                array(
                    'disable_review_form_txt' => $this->l(
                        'Not exists a criterion to review for this product or this language'
                    ),
                )
            );
        }
    }

    public function hookdisplayWbCartButton($params)
    {
        if (Configuration::get('WBFEATURE_ENABLE_AJAXCART')) {
            $this->link_cart = $this->context->link->getPageLink('cart', true);
            // $presenter = new ProductPresenter();
            $product = $params['product'];
            $id_product = $product['id_product'];
            if ($this->shouldEnableAddToCartButton($product)) {
                $product['add_to_cart_urls'] = $this->getAddToCartURL($product);
            } else {
                $product['add_to_cart_urls'] = null;
            }
            
            if ($product['customizable']) {
                $customization_datas = $this->context->cart->getProductCustomization(
                    $id_product,
                    null,
                    true
                );
            }
            
            $product['id_customization'] = empty($customization_datas) ? null : $customization_datas[0]['id_customization'];
            
            //DONGND:: fix for some case have not
            if (!isset($product['product_attribute_minimal_quantity'])) {
                // print_r('test');die();
                $product['product_attribute_minimal_quantity'] = Attribute::getAttributeMinimalQty(
                    $product['id_product_attribute']
                );
            }
            
            $templateVars = array(
                'static_token' => Tools::getToken(false),
                'wb_cart_product' => $product,
                'link_cart' => $this->link_cart,
                // 'show_input_quantity' => Configuration::get('WBFEATURE_ENABLE_INPUTQUANTITY'),
            );
            // echo '<pre>';
            // print_r($product);die();
            $this->context->smarty->assign($templateVars);
            return $this->display(__FILE__, 'wb_cart_button.tpl');
        }
    }

    public function hookdisplayWbCartQuantity($params)
    {
        $product = $params['product'];
        
        if (Configuration::get('WBFEATURE_ENABLE_INPUTQUANTITY') &&
            Configuration::get('WBFEATURE_ENABLE_AJAXCART')) {
            $id_product = $product['id_product'];
            
            $templateVars = array(
                'wb_cart_product_quantity' => $product,
            );
            // echo '<pre>';
            // print_r($product);die();
            $this->context->smarty->assign($templateVars);
            unset($id_product);
            return $this->display(__FILE__, 'wb_cart_button_quantity.tpl');
        }
    }
    
    public function hookdisplayWbCartAttribute($params)
    {
        $product = $params['product'];
        
        if (Configuration::get('WBFEATURE_ENABLE_SELECTATTRIBUTE') &&
            count($product['attributes'])>0 &&
            Configuration::get('WBFEATURE_ENABLE_AJAXCART')) {
            $id_product = $product['id_product'];
            $attributes = $this->getAttributesResume(
                $id_product,
                $this->context->language->id
            );
            
            if (!empty($attributes)) {
                $whitelist = $this->getProductAttributeWhitelist();
                foreach ($attributes as $k_attributes => $v_attributes) {
                    if ($v_attributes['id_product_attribute'] == $product['id_product_attribute']) {
                        $product['attribute_designation'] = $v_attributes['attribute_designation'];
                    }
                    foreach ($whitelist as $v_whitelist) {
                        if (isset($product[$v_whitelist])) {
                            $attributes[$k_attributes][$v_whitelist] = $product[$v_whitelist];
                        }
                    }
                    
                    if ($this->shouldEnableAddToCartButton($attributes[$k_attributes])) {
                        $attributes[$k_attributes]['add_to_cart_urls'] = $this->getAddToCartURL(
                            $attributes[$k_attributes]
                        );
                    } else {
                        $attributes[$k_attributes]['add_to_cart_urls'] = null;
                    }
                }
                $product['combinations'] = $attributes;
            }
            $templateVars = array(
                'wb_cart_product_attribute' => $product,
            );
            // echo '<pre>';
            // print_r($product);die();
            $this->context->smarty->assign($templateVars);
            return $this->display(__FILE__, 'wb_cart_button_attribute.tpl');
        }
    }
    
    public function hookdisplayWbProductReviewExtra($params)
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCT_REVIEWS')) {
            $product = $params['product'];

            $id_product = $product['id_product'];
            
            $id_guest = (!$id_customer = (int) $this->context->cookie->id_customer) ? (int) $this->context->cookie->id_guest : false;
            $customerReview = ProductReview::getByCustomer(
                (int) $id_product,
                (int) $this->context->cookie->id_customer,
                true,
                (int) $id_guest
            );

            $average = ProductReview::getAverageGrade((int) $id_product);
                    
            $this->context->smarty->assign(array(
                    'allow_guests_extra' => (int) Configuration::get(
                        'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS'
                    ),
                    'averageTotal_extra' => round($average['grade']),
                    'ratings_extra' => ProductReview::getRatings((int) $id_product),
                    'too_early_extra' => (
                        $customerReview && (
                            strtotime(
                                $customerReview['date_add']
                            ) + Configuration::get(
                                'WBFEATURE_PRODUCT_REVIEWS_MINIMAL_TIME'
                            )
                        ) > time()
                    ),
                    'nbReviews_product_extra' => (int) (
                        ProductReview::getReviewNumber(
                            (int) $id_product
                        )
                    ),
                    'id_product_review_extra' => $id_product,
                    'link_product_review_extra' => $product['link'],
            ));
            unset($id_customer);
            return $this->display(__FILE__, 'wb_product_review_extra.tpl');
        }
    }
    
    //DONGND:: create review tab at product page
    public function hookdisplayWbProductTab()
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCT_REVIEWS')) {
            // print_r($params['use_ptabs']);die();
            if (Module::isInstalled('appagebuilder') &&
                Module::isEnabled('appagebuilder')) {
                include_once(_PS_MODULE_DIR_.'appagebuilder/appagebuilder.php');
                $module = new APPageBuilder();
                $this->context->smarty->assign(array(
                    'USE_PTABS' => $module->getConfig('ENABLE_PTAB'),
                ));
            }
            return $this->display(__FILE__, 'wb_product_tab.tpl');
        }
    }
    
    //DONGND:: display reviews on review tab at product detail
    public function hookdisplayWbProductTabContent($params)
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCT_REVIEWS')) {
            $product = $params['product'];
            $id_product = $product['id_product'];
            
            $id_guest = (!$id_customer = (int) $this->context->cookie->id_customer) ? (int) $this->context->cookie->id_guest : false;
            $customerReview = ProductReview::getByCustomer(
                (int) $id_product,
                (int) $this->context->cookie->id_customer,
                true,
                (int) $id_guest
            );

            $this->context->smarty->assign(array(
                'reviews' => ProductReview::getByProduct(
                    (int) $id_product,
                    1,
                    null,
                    $this->context->cookie->id_customer
                ),
                'allow_guests' => (int) Configuration::get(
                    'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS'
                ),
                'too_early' => (
                    $customerReview && (
                        strtotime(
                            $customerReview['date_add']
                        ) + Configuration::get(
                            'WBFEATURE_PRODUCT_REVIEWS_MINIMAL_TIME'
                        )
                    ) > time()
                ),
                'allow_report_button' => (int) Configuration::get(
                    'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON'
                ),
                'allow_usefull_button' => (int) Configuration::get(
                    'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON'
                ),
                'id_product_tab_content' => $id_product,
                'link_product_tab_content' => $product['link'],
            ));
            if (Module::isInstalled('appagebuilder') &&
                Module::isEnabled('appagebuilder')) {
                include_once(_PS_MODULE_DIR_.'appagebuilder/appagebuilder.php');
                $module = new APPageBuilder();
                $this->context->smarty->assign(array(
                    'USE_PTABS' => $module->getConfig('ENABLE_PTAB'),
                ));
            }
            unset($id_customer);
            return $this->display(__FILE__, 'wb_product_tab_content.tpl');
        }
    }
    
    //DONGND:: display review of product at product list
    public function hookdisplayWbProductListReview($params)
    {
        $id_product = (int)$params['product']['id_product'];
        // if (!$this->isCached('wb_list_product_review.tpl', $this->getCacheId($id_product))) {
            $average = ProductReview::getAverageGrade($id_product);
            $this->smarty->assign(array(
                'product' => $params['product'],
                'averageTotal' => round($average['grade']),
                'ratings' => ProductReview::getRatings($id_product),
                'nbReviews' => (int)ProductReview::getReviewNumber($id_product),
            ));
        // }

        return $this->display(__FILE__, 'wb_list_product_review.tpl', $this->getCacheId($id_product));
    }
    
    //DONGND:: display compare button
    public function hookdisplayWbCompareButton($params)
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTCOMPARE') &&
            Configuration::get('WBFEATURE_COMPARATOR_MAX_ITEM') > 0) {
            $page_name = Dispatcher::getInstance()->getController();
            if ((Configuration::get('WBFEATURE_SHOW_PRODUCTCOMPARE_LISTPRODUCT') &&
                $page_name != 'product')
                || (Configuration::get('WBFEATURE_SHOW_PRODUCTCOMPARE_PRODUCTPAGE') &&
                    $page_name == 'product')
            ) {
                $id_product = $params['product']['id_product'];
                $compared_products = array();
                if (Configuration::get('WBFEATURE_COMPARATOR_MAX_ITEM') &&
                    isset($this->context->cookie->id_compare)) {
                    $compared_products = CompareProduct::getCompareProducts(
                        $this->context->cookie->id_compare
                    );
                }
                $added = false;
                if (count($compared_products) > 0 &&
                    in_array($id_product, $compared_products)) {
                    $added = true;
                }
                $this->smarty->assign(array(
                    'added' => $added,
                    'wb_compare_id_product' => $id_product,
                ));
                return $this->display(__FILE__, 'wb_compare_button.tpl');
            }
        }
    }
    
    //DONGND:: display review at product compare page
    public function hookdisplayWbProducReviewCompare($params)
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCT_REVIEWS')) {
            // echo '<pre>';
            // print_r($params['list_product']);die();
            $list_grades = array();
            $list_product_grades = array();
            $list_product_average = array();
            $list_product_review = array();

            foreach ($params['list_product'] as $id_product) {
                $id_product = (int) $id_product;
                $grades = ProductReview::getAveragesByProduct(
                    $id_product,
                    $this->context->language->id
                );
                $criterions = ProductReviewCriterion::getByProduct(
                    $id_product,
                    $this->context->language->id
                );
                $grade_total = 0;
                if (count($grades) > 0) {
                    foreach ($criterions as $criterion) {
                        if (isset($grades[$criterion['id_product_review_criterion']])) {
                            $list_product_grades[$criterion['id_product_review_criterion']][$id_product] = $grades[$criterion['id_product_review_criterion']];
                            $grade_total += (float) ($grades[$criterion['id_product_review_criterion']]);
                        } else {
                            $list_product_grades[$criterion['id_product_review_criterion']][$id_product] = 0;
                        }

                        if (!array_key_exists($criterion['id_product_review_criterion'], $list_grades)) {
                            $list_grades[$criterion['id_product_review_criterion']] = $criterion['name'];
                        }
                    }

                    $list_product_average[$id_product] = $grade_total / count($criterions);
                    $list_product_review[$id_product] = ProductReview::getByProduct($id_product);
                }
            }

            if (count($list_grades) < 1) {
                return false;
            }

            $this->context->smarty->assign(array(
                'grades' => $list_grades,
                'product_grades' => $list_product_grades,
                'list_ids_product' => $params['list_product'],
                'list_product_average' => $list_product_average,
                'product_reviews' => $list_product_review,
            ));

            return $this->display(__FILE__, '/wb_product_review_compare.tpl');
        }
    }
    
    //DONGND:: display wishlist button
    public function hookdisplayWbWishlistButton($params)
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTWISHLIST')) {
            $page_name = Dispatcher::getInstance()->getController();
            if ((Configuration::get('WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT') &&
                $page_name != 'product')
                || (Configuration::get('WBFEATURE_SHOW_PRODUCTWISHLIST_PRODUCTPAGE') &&
                    $page_name == 'product')
            ) {
                $wishlists = array();
                $wishlists_added = array();
                $id_wishlist = false;
                $added_wishlist = false;
                $id_product = $params['product']['id_product'];
                $id_product_attribute = $params['product']['id_product_attribute'];
                if ($this->context->customer->isLogged()) {
                    $wishlists = Wishlist::getByIdCustomer($this->context->customer->id);
                    if (empty($this->context->cookie->id_wishlist) === true ||
                        WishList::exists($this->context->cookie->id_wishlist, $this->context->customer->id) === false) {
                        if (!count($wishlists)) {
                            $id_wishlist = false;
                        } else {
                            $id_wishlist = (int)$wishlists[0]['id_wishlist'];
                            $this->context->cookie->id_wishlist = (int)$id_wishlist;
                        }
                    } else {
                        $id_wishlist = $this->context->cookie->id_wishlist;
                    }
                    $wishlist_products = ($id_wishlist == false ? array() : WishList::getSimpleProductByIdCustomer(
                        $this->context->customer->id,
                        $this->context->shop->id
                    ));

                    $check_product_added = array(
                        'id_product' => $id_product,
                        'id_product_attribute' => $id_product_attribute
                    );
                    foreach ($wishlist_products as $key => $wishlist_products_val) {
                        if (in_array($check_product_added, $wishlist_products_val)) {
                            $added_wishlist = true;
                            $wishlists_added[] = $key;
                        }
                    }
                }
                $this->smarty->assign(
                    array(
                        'wishlists_added' => $wishlists_added,
                        'wishlists' => $wishlists,
                        'added_wishlist' => $added_wishlist,
                        'id_wishlist' => $id_wishlist,
                        'wb_wishlist_id_product' => $id_product,
                        'wb_wishlist_id_product_attribute' => $id_product_attribute,
                    )
                );
                return $this->display(__FILE__, 'wb_wishlist_button.tpl');
            }
        }
    }

    public function hookdisplayWbWishlistProductButton($params)
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTWISHLIST')) {
            if ((Configuration::get('WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT'))
            ) {
                $wishlists = array();
                $wishlists_added = array();
                $id_wishlist = false;
                $added_wishlist = false;
                $id_product = $params['product']['id_product'];
                $id_product_attribute = $params['product']['id_product_attribute'];
                if ($this->context->customer->isLogged()) {
                    $wishlists = Wishlist::getByIdCustomer($this->context->customer->id);
                    if (empty($this->context->cookie->id_wishlist) === true ||
                        WishList::exists($this->context->cookie->id_wishlist, $this->context->customer->id) === false) {
                        if (!count($wishlists)) {
                            $id_wishlist = false;
                        } else {
                            $id_wishlist = (int)$wishlists[0]['id_wishlist'];
                            $this->context->cookie->id_wishlist = (int)$id_wishlist;
                        }
                    } else {
                        $id_wishlist = $this->context->cookie->id_wishlist;
                    }
                    $wishlist_products = ($id_wishlist == false ? array() : WishList::getSimpleProductByIdCustomer(
                        $this->context->customer->id,
                        $this->context->shop->id
                    ));

                    $check_product_added = array(
                        'id_product' => $id_product,
                        'id_product_attribute' => $id_product_attribute
                    );
                    foreach ($wishlist_products as $key => $wishlist_products_val) {
                        if (in_array($check_product_added, $wishlist_products_val)) {
                            $added_wishlist = true;
                            $wishlists_added[] = $key;
                        }
                    }
                }
                $this->smarty->assign(
                    array(
                        'wishlists_added' => $wishlists_added,
                        'wishlists' => $wishlists,
                        'added_wishlist' => $added_wishlist,
                        'id_wishlist' => $id_wishlist,
                        'wb_wishlist_id_product' => $id_product,
                        'wb_wishlist_id_product_attribute' => $id_product_attribute,
                    )
                );
                return $this->display(__FILE__, 'wb_wishlist_product_button.tpl');
            }
        }
    }
    //DONGND:: add mywishlist link to page my account
    public function hookdisplayCustomerAccount()
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTWISHLIST')) {
            $this->context->smarty->assign(array(
                'wishlist_link' => $this->link->getModuleLink(
                    'wbfeature',
                    'mywishlist'
                ),
            ));
            return $this->display(__FILE__, 'wb_wishlist_link.tpl');
        }
    }

    //DONGND:: add mywishlist link to page my account
    public function hookdisplayWbNav2()
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTWISHLIST')) {
            $this->context->smarty->assign(array(
                'wishlist_link' => $this->link->getModuleLink(
                    'wbfeature',
                    'mywishlist'
                ),
            ));
            return $this->display(__FILE__, 'wb_wishlist_headlink.tpl');
        }
    }
// comapre top
    public function hookdisplayWbTop()
    {
        if (Configuration::get('WBFEATURE_ENABLE_PRODUCTCOMPARE')) {
            $this->context->smarty->assign(array(
                'productcompare_url' => $this->link->getModuleLink(
                    'wbfeature',
                    'productscompare'
                ),
            ));
            return $this->display(__FILE__, 'wb_compare_headlink.tpl');
        }
    }

    
    //DONGND:: create fly cart
    public function hookDisplayBeforeBodyClosingTag()
    {
        // print_r('test');die();
        $output = '';
        $check_create_slidebar = false;
        $page_name = Dispatcher::getInstance()->getController();
        
        if (Configuration::get('WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART')
            && (Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_left'
                || Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_right'
                || Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_top'
                || Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_bottom'
                ) && $page_name != 'order'
        ) {
            //DONGND:: reverse position with rtl
            $type_dropdown_defaultcart = '';
            $type_dropdown_defaultcart = Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART');
            if ($this->context->language->is_rtl) {
                if (Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_left') {
                    $type_dropdown_defaultcart = 'slidebar_right';
                }
                if (Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == 'slidebar_right') {
                    $type_dropdown_defaultcart = 'slidebar_left';
                }
            }
            $output .= $this->buildFlyCartSlideBar($type_dropdown_defaultcart);
            if (Configuration::get('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART') == Configuration::get('WBFEATURE_TYPE_DROPDOWN_FLYCART')) {
                $check_create_slidebar = true;
            }
        }
        unset($check_create_slidebar);
        return $output;
    }
    
    //DONGND:: build fly cart
    public function buildFlyCart()
    {
        $vertical_position = '';
        
        $vertical_position .= Configuration::get('WBFEATURE_POSITION_VERTICAL_FLYCART').':';

        if (Configuration::get('WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART') == 'percent') {
            $vertical_position .= Configuration::get('WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART').'%';
        }
        if (Configuration::get('WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART') == 'pixel') {
            $vertical_position .= Configuration::get('WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART').'px';
        }
        $horizontal_position = '';
        //DONGND:: reverse position with rtl
        $type_horizontal_position = '';
        $type_horizontal_position = Configuration::get('WBFEATURE_POSITION_HORIZONTAL_FLYCART');
        if ($this->context->language->is_rtl) {
            if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_FLYCART') == 'left') {
                $type_horizontal_position = 'right';
            }
            if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_FLYCART') == 'right') {
                $type_horizontal_position = 'left';
            }
        }
        $horizontal_position .= $type_horizontal_position.':';
        if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART') == 'percent') {
            $horizontal_position .= Configuration::get('WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART').'%';
        }
        if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART') == 'pixel') {
            $horizontal_position .= Configuration::get('WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART').'px';
        }
        //DONGND:: reverse position with rtl
        $type_fly_cart = '';
        $type_fly_cart = Configuration::get('WBFEATURE_TYPE_DROPDOWN_FLYCART');
        if ($this->context->language->is_rtl) {
            if (Configuration::get('WBFEATURE_TYPE_DROPDOWN_FLYCART') == 'slidebar_left') {
                $type_fly_cart = 'slidebar_right';
            }
            if (Configuration::get('WBFEATURE_TYPE_DROPDOWN_FLYCART') == 'slidebar_right') {
                $type_fly_cart = 'slidebar_left';
            }
        }

        $templateVars = array(
            'type_fly_cart' => $type_fly_cart,
            // 'pusheffect' => (int)Configuration::get('WBFEATURE_ENABLE_PUSHEFFECT_FLYCART'),
            'type_position' => Configuration::get('WBFEATURE_TYPE_POSITION_FLYCART'),
            'vertical_position' => $vertical_position,
            'horizontal_position' => $horizontal_position,
        );
        $this->smarty->assign($templateVars);
        
        return $this->fetch('module:wbfeature/views/templates/front/fly_cart.tpl');
    }
    
    //DONGND:: build fly cart
    public function buildFlyCartSlideBar($type)
    {
        $templateVars = array(
            'type' => $type,
            'enable_overlay_background' => (int)Configuration::get(
                'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART'
            ),
        );
        $this->smarty->assign($templateVars);
        
        return $this->fetch('module:wbfeature/views/templates/front/fly_cart_slide_bar.tpl');
    }
    
    //DONGND:: copy function from base
    protected function shouldEnableAddToCartButton($product)
    {
        if (($product['customizable'] == 2 || !empty($product['customization_required']))) {
            $shouldShowButton = false;

            if (isset($product['customizations'])) {
                $shouldShowButton = true;
                foreach ($product['customizations']['fields'] as $field) {
                    if ($field['required'] && !$field['is_customized']) {
                        $shouldShowButton = false;
                    }
                }
            }
        } else {
            $shouldShowButton = true;
        }

        $shouldShowButton = $shouldShowButton && $this->shouldShowAddToCartButton($product);

        if ($product['quantity'] <= 0 && !$product['allow_oosp']) {
            $shouldShowButton = false;
        }

        return $shouldShowButton;
    }
    
    //DONGND:: copy function from base
    private function shouldShowAddToCartButton($product)
    {
        return (bool) $product['available_for_order'];
    }
    
    //DONGND:: copy function from base
    private function getAddToCartURL($product)
    {
        // echo '<pre>';
        // print_r($this->link);die();
        return $this->link->getAddToCartURL(
            $product['id_product'],
            $product['id_product_attribute']
        );
    }
    
    //DONGND:: render modal cart popup
    public function renderModal()
    {
        $output = $this->fetch('module:wbfeature/views/templates/front/modal.tpl');

        return $output;
    }
    
    //DONGND:: render notification
    public function renderNotification()
    {
        if ((Configuration::get('WBFEATURE_ENABLE_AJAXCART') &&
            Configuration::get('WBFEATURE_ENABLE_NOTIFICATION'))
            || Configuration::get('WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART')
        ) {
            $vertical_position = '';

            $vertical_position .= Configuration::get('WBFEATURE_POSITION_VERTICAL_NOTIFICATION').':';

            if (Configuration::get('WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION') == 'percent') {
                $vertical_position .= Configuration::get(
                    'WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION'
                ).'%';
            }
            if (Configuration::get('WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION') == 'pixel') {
                $vertical_position .= Configuration::get(
                    'WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION'
                ).'px';
            }
            $horizontal_position = '';
            //DONGND:: reverse position with rtl
            $type_horizontal_position = '';
            $type_horizontal_position = Configuration::get('WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION');
            if ($this->context->language->is_rtl) {
                if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION') == 'left') {
                    $type_horizontal_position = 'right';
                }
                if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION') == 'right') {
                    $type_horizontal_position = 'left';
                }
            }
            $horizontal_position .= $type_horizontal_position.':';
            if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION') == 'percent') {
                $horizontal_position .= Configuration::get('WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION').'%';
            }
            if (Configuration::get('WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION') == 'pixel') {
                $horizontal_position .= Configuration::get('WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION').'px';
            }
            $templateVars = array(
                'vertical_position' => $vertical_position,
                'horizontal_position' => $horizontal_position,
                'width_notification' => Configuration::get('WBFEATURE_WIDTH_NOTIFICATION'),
            );
            $this->smarty->assign($templateVars);
            $output = $this->fetch(
                'module:wbfeature/views/templates/front/notification.tpl'
            );

            return $output;
        }
    }
    
    //DONGND:: render modal review popup
    public function renderModalReview($id_product, $is_logged)
    {
        $product = new Product(
            (int)$id_product,
            false,
            $this->context->language->id,
            $this->context->shop->id
        );
        // echo '<pre>';
        // print_r($product);die();
        $image = Product::getCover((int) $id_product);
        $cover_image = $this->context->link->getImageLink(
            $product->link_rewrite,
            $image['id_image'],
            ImageType::getFormattedName('medium')
        );
        // print_r($cover_image);die();
        $this->context->smarty->assign(array(
            'product_modal_review' => $product,
            'criterions' => ProductReviewCriterion::getByProduct(
                (int) $id_product,
                $this->context->language->id
            ),
            'secure_key' => $this->secure_key,
            'productcomment_cover_image' => $cover_image,
            'allow_guests' => (int) Configuration::get(
                'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS'
            ),
            'is_logged' => (int) $is_logged,
        ));
       
        $output = $this->fetch(
            'module:wbfeature/views/templates/front/modal_review.tpl'
        );

        return $output;
    }
    
    //DONGND:: render modal popup
    public function renderPriceAttribute($product)
    {
        $templateVars = array(
            'product_price_attribute' => $product,
        );
        $this->context->smarty->assign($templateVars);
        
        $output = $this->fetch(
            'module:wbfeature/views/templates/front/price_attribute.tpl'
        );

        return $output;
    }
    
    //DONGND:: get list attribute of product
    public function getAttributesResume($id_product, $id_lang, $attribute_value_separator = ' - ', $attribute_separator = ', ')
    {
        if (!Combination::isFeatureActive()) {
            return array();
        }

        $combinations = Db::getInstance()->executeS(
            'SELECT pa.*, product_attribute_shop.*
            FROM `'._DB_PREFIX_.'product_attribute` pa
            '.Shop::addSqlAssociation('product_attribute', 'pa').'
            WHERE pa.`id_product` = '.(int)$id_product.'
            GROUP BY pa.`id_product_attribute`'
        );

        if (!$combinations) {
            return false;
        }

        $product_attributes = array();
        foreach ($combinations as $combination) {
            $product_attributes[] = (int)$combination['id_product_attribute'];
        }

        $lang = Db::getInstance()->executeS(
            'SELECT pac.id_product_attribute, GROUP_CONCAT(agl.`name`, \''.pSQL($attribute_value_separator).'\',al.`name`
            ORDER BY agl.`id_attribute_group` SEPARATOR \''.pSQL($attribute_separator).'\') as attribute_designation
            FROM `'._DB_PREFIX_.'product_attribute_combination` pac LEFT JOIN
            `'._DB_PREFIX_.'attribute` a ON
            a.`id_attribute` = pac.`id_attribute`
            LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON
            ag.`id_attribute_group` = a.`id_attribute_group`
            LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON
            (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)$id_lang.')
            LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON
            (ag.`id_attribute_group` = agl.`id_attribute_group` AND
                agl.`id_lang` = '.(int)$id_lang.')
            WHERE pac.id_product_attribute IN ('.implode(',', $product_attributes).')
            GROUP BY pac.id_product_attribute'
        );

        foreach ($lang as $k => $row) {
            $combinations[$k]['attribute_designation'] = $row['attribute_designation'];
        }

        //Get quantity of each variations
        foreach ($combinations as $key => $row) {
            $cache_key = $row['id_product'].'_'.$row['id_product_attribute'].'_quantity';

            if (!Cache::isStored($cache_key)) {
                $result = StockAvailable::getQuantityAvailableByProduct(
                    $row['id_product'],
                    $row['id_product_attribute']
                );
                Cache::store(
                    $cache_key,
                    $result
                );
                $combinations[$key]['quantity'] = $result;
            } else {
                $combinations[$key]['quantity'] = Cache::retrieve($cache_key);
            }
        }

        return $combinations;
    }
    
    //DONGND:: get list attribute of product inherit to attribute of its
    public function getProductAttributeWhitelist()
    {
        return array(
            "customizable",
            "available_for_order",
            "customization_required",
            "customizations",
            "allow_oosp",
        );
    }
    
    //DONGND:: render dopdown cart
    public function renderDropDown($only_total)
    {
        // echo '<pre>';
        // print_r((new CartPresenter)->present($this->context->cart));die();
        $cart = (new CartPresenter)->present($this->context->cart);
        $drop_down_html = '';
        if ($cart['products_count'] > 0) {
            $templateVars = array(
                'only_total' => $only_total,
                'cart' => $cart,
                'cart_url' => $this->context->link->getPageLink(
                    'cart',
                    null,
                    $this->context->language->id,
                    array(
                        'action' => 'show'
                    ),
                    false,
                    null,
                    true
                ),
                'order_url' => $this->context->link->getPageLink('order'),
                'enable_update_quantity' => (int)Configuration::get(
                    'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART'
                ),
                'enable_button_quantity' => (int)Configuration::get(
                    'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART'
                ),
                'show_combination' => (int)Configuration::get(
                    'WBFEATURE_SHOW_COMBINATION_ALLCART'
                ),
                'show_customization' => (int)Configuration::get(
                    'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART'
                ),
                // 'cart_count' => $cart['products_count'],
                'width_cart_item' => Configuration::get(
                    'WBFEATURE_WIDTH_CARTITEM_ALLCART'
                ),
                'height_cart_item' => Configuration::get(
                    'WBFEATURE_HEIGHT_CARTITEM_ALLCART'
                )
            );
            $this->smarty->assign($templateVars);
            $drop_down_html = $this->fetch(
                'module:wbfeature/views/templates/front/drop_down.tpl'
            );
        }
        return $drop_down_html;
    }
    
    /**
     * Common method
     * Resgister all hook for module
     */
    public function registerWbHook()
    {
        $res = true;
        $res &= $this->registerHook('header');
        $res &= $this->registerHook('displayWbCartButton');
        $res &= $this->registerHook('displayWbCartQuantity');
        $res &= $this->registerHook('displayWbCartAttribute');
        $res &= $this->registerHook('displayBackOfficeHeader');
        $res &= $this->registerHook('displayWbProductReviewExtra');
        $res &= $this->registerHook('displayWbProductTab');
        $res &= $this->registerHook('displayWbProductTabContent');
        $res &= $this->registerHook('displayWbProductListReview');
        $res &= $this->registerHook('displayWbCompareButton');
        $res &= $this->registerHook('displayWbWishlistButton');
        $res &= $this->registerHook('displayWbWishlistProductButton');
        $res &= $this->registerHook('displayWbProducReviewCompare');
        $res &= $this->registerHook('displayCustomerAccount');
        $res &= $this->registerHook('displayWbNav2');
        $res &= $this->registerHook('displayWbTop');
        $res &= $this->registerHook('actionAdminControllerSetMedia');
        $res &= $this->registerHook('displayBeforeBodyClosingTag');
        return $res;
    }
    
    /**
     * Common method
     * Unresgister all hook for module
     */
    public function unregisterWbHook()
    {
        $res = true;
        $res &= $this->unregisterHook('header');
        $res &= $this->unregisterHook('displayWbCartButton');
        $res &= $this->unregisterHook('displayWbCartQuantity');
        $res &= $this->unregisterHook('displayWbCartAttribute');
        $res &= $this->unregisterHook('displayBackOfficeHeader');
        $res &= $this->unregisterHook('displayWbProductReviewExtra');
        $res &= $this->unregisterHook('displayWbProductTab');
        $res &= $this->unregisterHook('displayWbProductTabContent');
        $res &= $this->unregisterHook('displayWbProductListReview');
        $res &= $this->unregisterHook('displayWbCompareButton');
        $res &= $this->unregisterHook('displayWbWishlistButton');
        $res &= $this->unregisterHook('displayWbWishlistProductButton');
        $res &= $this->unregisterHook('displayWbProducReviewCompare');
        $res &= $this->unregisterHook('displayCustomerAccount');
        $res &= $this->unregisterHook('displayWbNav2');
        $res &= $this->unregisterHook('displayWbTop');
        $res &= $this->unregisterHook('actionAdminControllerSetMedia');
        $res &= $this->unregisterHook('displayBeforeBodyClosingTag');
        return $res;
    }
    
    /**
     * Install Module Tabs
     */
    private function installModuleTab($title, $class_sfx = '', $parent = '')
    {
        $class = 'Admin'.Tools::ucfirst($this->name).Tools::ucfirst($class_sfx);
        // @copy(_PS_MODULE_DIR_.$this->name.'/logo.gif', _PS_IMG_DIR_.'t/'.$class.'.gif');
        if ($parent == '') {
            # validate module
            $position = Tab::getCurrentTabId();
        } else {
            # validate module
            $position = Tab::getIdFromClassName($parent);
        }

        $tab1 = new Tab();
        $tab1->class_name = $class;
        $tab1->module = $this->name;
        $tab1->id_parent = (int)$position;
        $langs = Language::getLanguages(false);
        foreach ($langs as $l) {
            # validate module
            $tab1->name[$l['id_lang']] = $title;
        }
        $tab1->add(true, false);
    }
    
    /**
     * Uninstall tabs
     */
    private function uninstallModuleTab($class_sfx = '')
    {
        $tab_class = 'Admin'.Tools::ucfirst($this->name).Tools::ucfirst($class_sfx);

        $id_tab = Tab::getIdFromClassName($tab_class);
        if ($id_tab != 0) {
            $tab = new Tab($id_tab);
            $tab->delete();
            return true;
        }
        return false;
    }
    
    /**
     * Creates tables
     */
    protected function createTables()
    {
        if ($this->_installDataSample()) {
            return true;
        }
        $res = 1;
        include_once(dirname(__FILE__).'/install/install.php');
        return $res;
    }
    
    public function deleteTables()
    {
        return Db::getInstance()->execute('
            DROP TABLE IF EXISTS
            `'._DB_PREFIX_.'wbfeature_product_review`,
            `'._DB_PREFIX_.'wbfeature_product_review_criterion`,
            `'._DB_PREFIX_.'wbfeature_product_review_criterion_product`,
            `'._DB_PREFIX_.'wbfeature_product_review_criterion_lang`,
            `'._DB_PREFIX_.'wbfeature_product_review_criterion_category`,
            `'._DB_PREFIX_.'wbfeature_product_review_grade`,
            `'._DB_PREFIX_.'wbfeature_product_review_usefulness`,
            `'._DB_PREFIX_.'wbfeature_product_review_report`,
            `'._DB_PREFIX_.'wbfeature_compare`,
            `'._DB_PREFIX_.'wbfeature_compare_product`,
            `'._DB_PREFIX_.'wbfeature_wishlist`,
            `'._DB_PREFIX_.'wbfeature_wishlist_product`
        ');
    }
    
    //DONGND:: create configs
    public function createConfiguration()
    {
        $list_config_create = array(
            'WBFEATURE_ENABLE_AJAXCART' => 1,
            'WBFEATURE_ENABLE_SELECTATTRIBUTE' => 0,
            'WBFEATURE_ENABLE_UPDATELABEL' => 0,
            'WBFEATURE_ENABLE_INPUTQUANTITY' => 1,
            'WBFEATURE_ENABLE_FLYCART_EFFECT' => 1,
            'WBFEATURE_ENABLE_NOTIFICATION' => 0,
            'WBFEATURE_SHOW_POPUP' => 1,
            'WBFEATURE_ENABLE_PRODUCT_REVIEWS' => 1,
            'WBFEATURE_SHOW_PRODUCT_REVIEWS_LISTPRODUCT' => 1,
            'WBFEATURE_SHOW_NUMBER_PRODUCT_REVIEWS_LISTPRODUCT' => 1,
            'WBFEATURE_SHOW_ZERO_PRODUCT_REVIEWS_LISTPRODUCT' => 1,
            'WBFEATURE_PRODUCT_REVIEWS_MINIMAL_TIME' => 30,
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS' => 0,
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON' => 1,
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON' => 1,
            'WBFEATURE_PRODUCT_REVIEWS_MODERATE' => 1,
            'WBFEATURE_ENABLE_PRODUCTCOMPARE' => 1,
            'WBFEATURE_SHOW_PRODUCTCOMPARE_PRODUCTPAGE' => 1,
            'WBFEATURE_SHOW_PRODUCTCOMPARE_LISTPRODUCT' => 1,
            'WBFEATURE_COMPARATOR_MAX_ITEM' => 3,
            'WBFEATURE_ENABLE_PRODUCTWISHLIST' => 1,
            'WBFEATURE_SHOW_PRODUCTWISHLIST_PRODUCTPAGE' => 1,
            'WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT' => 1,
            'WBFEATURE_DEFAULT_TAB' => '#fieldset_0',
            'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART' => 1,
            'WBFEATURE_TYPE_DROPDOWN_DEFAULTCART' => 'dropdown',
            // 'WBFEATURE_ENABLE_PUSHEFFECT_DEFAULTCART' => 0,
            'WBFEATURE_ENABLE_DROPDOWN_FLYCART' => 0,
            'WBFEATURE_TYPE_DROPDOWN_FLYCART' => 'slidebar_bottom',
            // 'WBFEATURE_ENABLE_PUSHEFFECT_FLYCART' => 0,
            'WBFEATURE_TYPE_POSITION_FLYCART' => 'fixed',
            'WBFEATURE_POSITION_VERTICAL_FLYCART' => 'bottom',
            'WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART' => 20,
            'WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART' => 'pixel',
            'WBFEATURE_POSITION_HORIZONTAL_FLYCART' => 'left',
            'WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART' => 20,
            'WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART' => 'pixel',
            'WBFEATURE_TYPE_EFFECT_FLYCART' => 'fade',
            'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART' => 0,
            'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART' => 1,
            'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART' => 1,
            'WBFEATURE_SHOW_COMBINATION_ALLCART' => 1,
            'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART' => 1,
            'WBFEATURE_WIDTH_CARTITEM_ALLCART' => 265,
            'WBFEATURE_HEIGHT_CARTITEM_ALLCART' => 135,
            'WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART' => 8,
            'WBFEATURE_WIDTH_NOTIFICATION' => 320,
            'WBFEATURE_POSITION_VERTICAL_NOTIFICATION' => 'top',
            'WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION' => 50,
            'WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION' => 'pixel',
            'WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION' => 'right',
            'WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION' => 20,
            'WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION' => 'pixel',
        );
        foreach ($list_config_create as $key => $value) {
            Configuration::updateValue($key, $value);
        }
        Configuration::updateValue('WBFEATURE_TYPE_DROPDOWN_DEFAULTCART', 'dropdown');
        Configuration::updateValue('WBFEATURE_SHOW_POPUP', '1');
        configuration::updateValue('WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART', '3');
        return true;
    }
    
    //DONGND:: delete configs
    public function deleteConfiguration()
    {
        $list_config_delete = array(
            'WBFEATURE_ENABLE_AJAXCART',
            'WBFEATURE_ENABLE_SELECTATTRIBUTE',
            'WBFEATURE_ENABLE_UPDATELABEL',
            'WBFEATURE_ENABLE_INPUTQUANTITY',
            'WBFEATURE_ENABLE_FLYCART_EFFECT',
            'WBFEATURE_ENABLE_NOTIFICATION',
            'WBFEATURE_SHOW_POPUP',
            'WBFEATURE_ENABLE_PRODUCT_REVIEWS',
            'WBFEATURE_SHOW_PRODUCT_REVIEWS_LISTPRODUCT',
            'WBFEATURE_SHOW_NUMBER_PRODUCT_REVIEWS_LISTPRODUCT',
            'WBFEATURE_SHOW_ZERO_PRODUCT_REVIEWS_LISTPRODUCT',
            'WBFEATURE_PRODUCT_REVIEWS_MINIMAL_TIME',
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_GUESTS',
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON',
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON',
            'WBFEATURE_PRODUCT_REVIEWS_MODERATE',
            'WBFEATURE_ENABLE_PRODUCTCOMPARE',
            'WBFEATURE_SHOW_PRODUCTCOMPARE_PRODUCTPAGE',
            'WBFEATURE_SHOW_PRODUCTCOMPARE_LISTPRODUCT',
            'WBFEATURE_COMPARATOR_MAX_ITEM',
            'WBFEATURE_ENABLE_PRODUCTWISHLIST',
            'WBFEATURE_SHOW_PRODUCTWISHLIST_PRODUCTPAGE',
            'WBFEATURE_SHOW_PRODUCTWISHLIST_LISTPRODUCT',
            'WBFEATURE_DEFAULT_TAB',
            'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART',
            //'WBFEATURE_TYPE_DROPDOWN_DEFAULTCART',
            // 'WBFEATURE_ENABLE_PUSHEFFECT_DEFAULTCART',
            // 'WBFEATURE_ENABLE_DROPDOWN_FLYCART',
            // 'WBFEATURE_TYPE_DROPDOWN_FLYCART',
            // // 'WBFEATURE_ENABLE_PUSHEFFECT_FLYCART',
            // 'WBFEATURE_TYPE_POSITION_FLYCART',
            // 'WBFEATURE_POSITION_VERTICAL_FLYCART',
            // 'WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART',
            // 'WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART',
            // 'WBFEATURE_POSITION_HORIZONTAL_FLYCART',
            // 'WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART',
            // 'WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART',
            // 'WBFEATURE_TYPE_EFFECT_FLYCART',
            'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART',
            'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART',
            'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART',
            'WBFEATURE_SHOW_COMBINATION_ALLCART',
            'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART',
            'WBFEATURE_WIDTH_CARTITEM_ALLCART',
            'WBFEATURE_HEIGHT_CARTITEM_ALLCART',
            'WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART',
            'WBFEATURE_WIDTH_NOTIFICATION',
            'WBFEATURE_POSITION_VERTICAL_NOTIFICATION',
            'WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION',
            'WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION',
            'WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION',
            'WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION',
            'WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION',
        );
        foreach ($list_config_delete as $list_config_delete_val) {
            Configuration::deleteByName($list_config_delete_val);
        }
        return true;
    }

    private function _installDataSample()
    {
        if (!file_exists(_PS_MODULE_DIR_.'appagebuilder/libs/WbDataSample.php')) {
            return false;
        }
        require_once(_PS_MODULE_DIR_.'appagebuilder/libs/WbDataSample.php');

        $sample = new Datasample(1);
        return $sample->processImport($this->name);
    }
    
    public function _clearCache($template, $cache_id = null, $compile_id = null)
    {
        parent::_clearCache($template);
        unset($cache_id, $compile_id);
    }
    
    public function correctModule()
    {
        if (Configuration::hasKey('WBFEATURE_ENABLE_PUSHEFFECT_DEFAULTCART')) {
            Configuration::updateValue('WBFEATURE_ENABLE_PUSHEFFECT_DEFAULTCART', 0);
        }
        if (Configuration::hasKey('WBFEATURE_ENABLE_PUSHEFFECT_FLYCART')) {
            Configuration::updateValue('WBFEATURE_ENABLE_PUSHEFFECT_FLYCART', 0);
        }
        $list_config_check = array(
            'WBFEATURE_WIDTH_CARTITEM_ALLCART' => 265,
            'WBFEATURE_HEIGHT_CARTITEM_ALLCART' => 135,
            'WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART' => 3,
            'WBFEATURE_ENABLE_UPDATE_QUANTITY_ALLCART' => 1,
            'WBFEATURE_ENABLE_BUTTON_QUANTITY_ALLCART' => 1,
            'WBFEATURE_SHOW_COMBINATION_ALLCART' => 1,
            'WBFEATURE_SHOW_CUSTOMIZATION_ALLCART' => 1,
            'WBFEATURE_WIDTH_NOTIFICATION' => 320,
            'WBFEATURE_POSITION_VERTICAL_NOTIFICATION' => 'top',
            'WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION' => 50,
            'WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION' => 'pixel',
            'WBFEATURE_POSITION_HORIZONTAL_NOTIFICATION' => 'right',
            'WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION' => 20,
            'WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION' => 'pixel',
            'WBFEATURE_SHOW_POPUP' => 1,
            'WBFEATURE_ENABLE_NOTIFICATION' => 0,
            'WBFEATURE_ENABLE_OVERLAYBACKGROUND_ALLCART' => 0,
            'WBFEATURE_TYPE_POSITION_FLYCART' => 'fixed',
            'WBFEATURE_POSITION_VERTICAL_FLYCART' => 'bottom',
            'WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART' => 20,
            'WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART' => 'pixel',
            'WBFEATURE_POSITION_HORIZONTAL_FLYCART' => 'left',
            'WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART' => 20,
            'WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART' => 'pixel',
            // 'WBFEATURE_ENABLE_PUSHEFFECT_FLYCART' => 0,
            'WBFEATURE_TYPE_DROPDOWN_FLYCART' => 'slidebar_bottom',
            'WBFEATURE_ENABLE_DROPDOWN_FLYCART' => 0,
            // 'WBFEATURE_ENABLE_PUSHEFFECT_DEFAULTCART' => 0,
            'WBFEATURE_TYPE_DROPDOWN_DEFAULTCART' => 'dropdown',
            'WBFEATURE_ENABLE_DROPDOWN_DEFAULTCART' => 1,
            'WBFEATURE_SHOW_ZERO_PRODUCT_REVIEWS_LISTPRODUCT' => 1,
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_USEFULL_BUTTON' => 1,
            'WBFEATURE_PRODUCT_REVIEWS_ALLOW_REPORT_BUTTON' => 1,
            'WBFEATURE_ENABLE_UPDATELABEL' => 0,
            'WBFEATURE_ENABLE_FLYCART_EFFECT' => 1,
            'WBFEATURE_TYPE_EFFECT_FLYCART' => 'fade',
        );
        foreach ($list_config_check as $key => $value) {
            if (!Configuration::hasKey($key)) {
                Configuration::updateValue($key, $value);
            }
        };
        
        //DONGND:: add hook for attribute of product
        $this->registerHook('displayWbCartAttribute');
        
        //DONGND:: add hook for quantity of product
        $this->registerHook('displayWbCartQuantity');
        
        //DONGND:: add id field to product_review_grade table
        $sql = 'SHOW FIELDS FROM `'._DB_PREFIX_.'wbfeature_product_review_grade` LIKE "id_product_review_grade"';
        $column = Db::getInstance()->executeS($sql);
        
        if (empty($column)) {
            Db::getInstance()->execute(
                'ALTER TABLE '._DB_PREFIX_.'wbfeature_product_review_grade DROP PRIMARY KEY'
            );
            Db::getInstance()->execute(
                'ALTER TABLE '._DB_PREFIX_.'wbfeature_product_review_grade ADD id_product_review_grade INT AUTO_INCREMENT PRIMARY KEY FIRST'
            );
        }
        
        //DONGND:: add hook for fly cart
        $this->registerHook('displayBeforeBodyClosingTag');
    }
    
    /**
     * Run only one when install/change Theme_of_Wb
     */
    public function hookActionAdminBefore()
    {
        $this->unregisterHook('actionAdminBefore');
        
        # FIX : update Prestashop by 1-Click module -> NOT NEED RESTORE DATABASE
        $ap_version = Configuration::get('AP_CURRENT_VERSION');
        if ($ap_version != false) {
            $ps_version = Configuration::get('PS_VERSION_DB');
            $versionCompare =  version_compare($ap_version, $ps_version);
            if ($versionCompare != 0) {
                // Just update Prestashop
                Configuration::updateValue('AP_CURRENT_VERSION', $ps_version);
                return;
            }
        }
        
        
        # WHENE INSTALL THEME, INSERT HOOK FROM DATASAMPLE IN THEME
        $hook_from_theme = false;
        if (file_exists(_PS_MODULE_DIR_.'appagebuilder/libs/WbDataSample.php')) {
            require_once(_PS_MODULE_DIR_.'appagebuilder/libs/WbDataSample.php');
            $sample = new Datasample();
            if ($sample->processHook($this->name)) {
                $hook_from_theme = true;
            };
        }
        
        # INSERT HOOK FROM MODULE_DATASAMPLE
        if ($hook_from_theme == false) {
            $this->registerWbHook();
        }
        
        # WHEN INSTALL MODULE, NOT NEED RESTORE DATABASE IN THEME
        $install_module = (int)Configuration::get('AP_INSTALLED_WBFEATURE', 0);
        if ($install_module) {
            Configuration::updateValue('AP_INSTALLED_WBFEATURE', '0');    // next : allow restore sample
            return;
        }
        
        # INSERT DATABASE FROM THEME_DATASAMPLE
        if (file_exists(_PS_MODULE_DIR_.'appagebuilder/libs/WbDataSample.php')) {
            require_once(_PS_MODULE_DIR_.'appagebuilder/libs/WbDataSample.php');
            $sample = new Datasample();
            $sample->processImport($this->name);
        }
    }
    
    protected function postValidation()
    {
        if (Tools::isSubmit('submitWbfeatureConfig')) {
            if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_COMPARATOR_MAX_ITEM'))) {
                $this->_postErrors[] = $this->l(
                    '"Number product comparison" is invalid. Must an integer validity (unsigned).'
                );
            }
            if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_PRODUCT_REVIEWS_MINIMAL_TIME'))) {
                $this->_postErrors[] = $this->l(
                    '"Minimum time between 2 reviews from the same user" is invalid.
                     Must an integer validity (unsigned).'
                );
            }
            // if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART'))) {
            //     $this->_postErrors[] = $this->l(
            //         '"Position By Vertical Value (Fly Cart)" is invalid. Must an integer validity (unsigned123).'
            //     );
            // } else {
            //     if (Tools::getValue('WBFEATURE_POSITION_VERTICAL_UNIT_FLYCART') == 'percent' &&
            //         Tools::getValue('WBFEATURE_POSITION_VERTICAL_VALUE_FLYCART') > 100) {
            //         $this->_postErrors[] = $this->l(
            //             '"Position By Vertical Value (Fly Cart)" is invalid. Must an integer validity
            //             (unsigned). Must has value from 0 to 100 with the unit type is percent'
            //         );
            //     }
            // }
            // if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART'))) {
            //     $this->_postErrors[] = $this->l(
            //         '"Position By Horizontal Value (Fly Cart)" is invalid.
            //          Must an integer validity (unsigned).'
            //     );
            // } else {
            //     if (Tools::getValue('WBFEATURE_POSITION_HORIZONTAL_UNIT_FLYCART') == 'percent' &&
            //         Tools::getValue('WBFEATURE_POSITION_HORIZONTAL_VALUE_FLYCART') > 100) {
            //         $this->_postErrors[] = $this->l(
            //             '"Position By Horizontal Value (Fly Cart)" is invalid. Must an integer validity (unsigned).
            //             Must has value from 0 to 100 with the unit type is percent'
            //         );
            //     }
            // }
            if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_WIDTH_CARTITEM_ALLCART'))) {
                $this->_postErrors[] = $this->l(
                    '"Width Of Cart Item (All Cart)" is invalid. Must an integer validity (unsigned).'
                );
            }
            if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_HEIGHT_CARTITEM_ALLCART'))) {
                $this->_postErrors[] = $this->l(
                    '"Height Of Cart Item (All Cart)" is invalid. Must an integer validity (unsigned).'
                );
            }
            // if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_NUMBER_CARTITEM_DISPLAY_ALLCART'))) {
            //     $this->_postErrors[] = $this->l(
            //         '"Number Cart Item To Display (All Cart)" is invalid. Must an integer validity (unsigned).'
            //     );
            // }
            if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_WIDTH_NOTIFICATION'))) {
                $this->_postErrors[] = $this->l(
                    '"Width (Notification)" is invalid. Must an integer validity (unsigned).'
                );
            }
            if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION'))) {
                $this->_postErrors[] = $this->l(
                    '"Position By Vertical Value (Notification)" is invalid. Must an integer validity (unsigned).'
                );
            } else {
                if (Tools::getValue('WBFEATURE_POSITION_VERTICAL_UNIT_NOTIFICATION') == 'percent' &&
                    Tools::getValue('WBFEATURE_POSITION_VERTICAL_VALUE_NOTIFICATION') > 100) {
                    $this->_postErrors[] = $this->l(
                        '"Position By Vertical Value (Notification)" is invalid. Must an integer validity (unsigned).
                        Must has value from 0 to 100 with the unit type is percent'
                    );
                }
            }
            if (!Validate::isUnsignedInt(Tools::getValue('WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION'))) {
                $this->_postErrors[] = $this->l(
                    '"Position By Horizontal Value (Notification)" is invalid. Must an integer validity (unsigned).'
                );
            } else {
                if (Tools::getValue('WBFEATURE_POSITION_HORIZONTAL_UNIT_NOTIFICATION') == 'percent' &&
                    Tools::getValue('WBFEATURE_POSITION_HORIZONTAL_VALUE_NOTIFICATION') > 100) {
                    $this->_postErrors[] = $this->l(
                        '"Position By Horizontal Value (Notification)" is invalid. Must an integer validity (unsigned).
                        Must has value from 0 to 100 with the unit type is percent'
                    );
                }
            }
        }
    }
}
