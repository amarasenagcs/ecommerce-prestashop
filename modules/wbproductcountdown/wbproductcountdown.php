<?php
/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * @author    Presta.Site
 * @copyright 2017 Presta.Site
 * @license   LICENSE.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class WBProductCountdown extends Module
{
    private $html;

    public $settings_prefix = 'WBPC_';

    public $theme;
    public $activate_all_special;
    public $show_weeks;
    public $hide_zero_weeks;
    public $clear_cache_mod_save;
    public $clear_cache_prod_save;
    public $custom_css;

    public function __construct()
    {
        $this->name = 'wbproductcountdown';
        $this->tab = 'front_office_features';
        $this->version = '1.2.2';
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
        $this->author = 'Webitheme';
        $this->bootstrap = true;

        parent::__construct();
        $this->loadSettings();

        $this->displayName = $this->l('Product countdown');
        $this->description = $this->l('Countdown timer for products.');
    }

    public function install()
    {
        if (!parent::install()
            or
            !$this->registerHook('WBProductCountdown') ||
            !$this->registerHook('header') ||
            !$this->registerHook('actionProductUpdate') ||
            !$this->registerHook('displayAdminProductsExtra') ||
            !$this->registerHook('displayBackOfficeHeader')
        ) {
            return false;
        }

        if ($this->getPSVersion() <= 1.6) {
            if (!$this->registerHook('displayProductListReviews') ||
                !$this->registerHook('displayProductButtons')
            ) {
                return false;
            }
        } elseif ($this->getPSVersion() == 1.7) {
            if (!$this->registerHook('displayProductPriceBlock')) {
                return false;
            }
        }

        // main table
        $db_result = Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'wbproductcountdown` (
            `id_countdown` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_product` INT(6) UNSIGNED NOT NULL,
            `id_shop` INTEGER UNSIGNED NOT NULL,
            `from` DATETIME,
            `to` DATETIME,
            `active` TINYINT(1) DEFAULT 1,
            PRIMARY KEY (`id_countdown`),
            UNIQUE `id_product_id_shop` (`id_product`, `id_shop`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8');
        if (!$db_result) {
            return false;
        }

        // lang table
        $db_result = Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'wbproductcountdown_lang` (
            `id_countdown` INT(6) NOT NULL,
            `id_lang` INT(6) NOT NULL,
            `name` VARCHAR(255) NOT NULL
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8');
        if (!$db_result) {
            return false;
        }

        //default values:
        foreach ($this->getSettings() as $item) {
            if ($item['type'] == 'html') {
                continue;
            }
            
            if (Configuration::get($this->settings_prefix . $item['name']) === false) {
                if (isset($item['default_'.$this->getPSVersion(true)])) {
                    Configuration::updateValue(
                        $this->settings_prefix . $item['name'],
                        $item['default_'.$this->getPSVersion(true)]
                    );
                } elseif (isset($item['default'])) {
                    Configuration::updateValue(
                        $this->settings_prefix . $item['name'],
                        $item['default']
                    );
                }
            }
        }

        $this->loadSettings();

        // Check whether the theme is valid
        $avail_themes = $this->getThemesSimple();
        if (!in_array($this->theme, $avail_themes)) {
            Configuration::updateValue($this->settings_prefix . 'THEME', $avail_themes[0]);
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }
        return true;
    }

    public function hookHeader()
    {
        $this->context->controller->addJquery();
        $this->context->controller->addJS($this->_path . 'views/js/underscore.min.js');
        $this->context->controller->addJS($this->_path . 'views/js/jquery.countdown.min.js');
        $this->context->controller->addJS($this->_path . 'views/js/wbproductcountdown.js');
        $this->context->controller->addCSS(($this->_path) . 'views/css/wbproductcountdown.css');
        if ($this->theme) {
            $this->context->controller->addCSS(
                $this->_path . 'views/css/themes/' . $this->getPSVersion() . '/' . $this->theme
            );
        }

        $this->context->smarty->assign(array(
            'theme' => $this->theme,
            'upload_dir' => $this->_path.'upload/',
            'show_weeks' => $this->show_weeks,
            'custom_css' => html_entity_decode($this->custom_css),
            'wbv' => $this->getPSVersion(),
        ));

        return $this->display(__FILE__, 'header.tpl');
    }

    public function hookWBProductCountdown($params)
    {
        $return = null;
        $id_product = null;

        // Get id_product
        if (isset($params['id_product']) && $params['id_product'] > 0) {
            $id_product = $params['id_product'];
        } elseif (isset($params['product']) && $params['product']) {
            $product = $params['product'];
            if (is_array($product) && isset($product['id_product'])) {
                $id_product = $product['id_product'];
            } elseif (is_object($product)) {
                $id_product = $product->id;
            } else {
                return false;
            }
        } else {
            $id_product = Tools::getValue('id_product');
        }

        // Render countdown
        if ($id_product) {
            $countdown = $this->getCountdown($id_product);

            if ($countdown) {
                $datetime_current = new DateTime();
                $datetime_from = new DateTime($countdown['from']);
                $datetime_to = new DateTime($countdown['to']);
                $interval = $datetime_current->diff($datetime_to);
                $days_diff = (int)$interval->days;
                $weeks_diff = floor($days_diff / 7);

                // Return false if countdown is expired or not started yet
                if ($datetime_from > $datetime_current || $datetime_to < $datetime_current) {
                    return false;
                }

                $this->context->smarty->assign(array(
                    'id_product' => $id_product,
                    'countdown' => $countdown,
                    'interval' => $interval,
                    'days_diff' => $days_diff,
                    'weeks_diff' => $weeks_diff,
                    'theme' => $this->theme,
                    'hide_zero_weeks' => $this->hide_zero_weeks,
                ));

                $return = $this->display(
                    __FILE__,
                    'wbproductcountdown.tpl',
                    $this->getCacheId(null, $countdown['to_time'])
                );
            }
        }

        return $return;
    }

    public function hookDisplayProductListReviews($params)
    {
        return $this->hookWBProductCountdown($params);
    }
    public function hookDisplayProductPriceBlock($params)
    {
        if (isset($params['type']) && $params['type'] == 'weight') {
            return $this->hookWBProductCountdown($params);
        }
    }

    public function hookDisplayProductButtons($params)
    {
        if ($this->getPSVersion() < 1.7) {
            return $this->hookWBProductCountdown($params);
        }
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        if (isset($params['id_product']) && $params['id_product']) {
            $id_product = $params['id_product'];
        } else {
            $id_product = (int)Tools::getValue('id_product');
        }
        $token = Tools::getAdminTokenLite('AdminModules');
        $ajax_url = 'index.php?tab=AdminModules&configure=' . $this->name . '&token=' . $token;

        if (Validate::isLoadedObject($product = new Product($id_product))) {
            $this->context->smarty->assign(array(
                'wbv' => $this->getPSVersion(),
                'module_name' => $this->name,
                'languages' => Language::getLanguages(),
                'specific_prices' => $this->getProductSpecificPrices($id_product),
                'countdown_data' => $this->getCountdownBOData($id_product),
                'link' => $this->context->link,
                'ajax_url' => $ajax_url,
            ));
            unset($product);
            return $this->display(__FILE__, 'admin_products_extra'.$this->getPSVersion(true).'.tpl');
        }
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        // check whether it's a product page
        if ($this->context->controller->controller_name == 'AdminProducts') {
            $this->context->controller->addCSS($this->_path.'views/css/admin.css');
            $this->context->controller->addJquery();
            $this->context->controller->addJqueryUI('ui.datepicker');
            $this->context->controller->addJS(array(
                _PS_JS_DIR_ . 'jquery/plugins/timepicker/jquery-ui-timepicker-addon.js',
                $this->_path . 'views/js/admin_product.js'
            ));
        }

        // check whether it's a module page
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addCSS(array(
                $this->_path.'views/css/admin.css',
            ));
            $this->context->controller->addJquery();
            $this->context->controller->addJS(array(
                $this->_path . 'views/js/admin.js',
            ));
        }

        $this->context->smarty->assign(array(
            'wbv' => $this->getPSVersion(),
        ));

        return $this->context->smarty->fetch($this->local_path . 'views/templates/hook/admin_header.tpl');
    }

    public function hookActionProductUpdate($params)
    {
        if ($this->getPSVersion() >= 1.6) {
            $product = $params['product'];
        } else {
            $id_product = $params['id_product'];
            $product = new Product($id_product);
        }

        //process only if it's a product page
        if (Tools::isSubmit($this->name . '-submit')) {
            $from = Tools::getValue('wbpc_from');
            $to = Tools::getValue('wbpc_to');
            $active = Tools::getValue('wbpc_active');

            $id_countdown = Db::getInstance()->getValue(
                'SELECT `id_countdown` 
                FROM `' . _DB_PREFIX_ . 'wbproductcountdown` 
                WHERE `id_shop` = ' . (int)$this->context->shop->id . ' AND `id_product` = ' . (int)$product->id
            );

            // save / add
            if ($id_countdown) {
                // If 'from' and 'to' are not submitted and 'active' set to true, then just delete the countdown
                if (!$from && !$to && $active) {
                    Db::getInstance()->execute(
                        'DELETE FROM `' . _DB_PREFIX_ . 'wbproductcountdown`
                        WHERE `id_countdown` = ' . (int)$id_countdown
                    );
                } else {
                    // Save
                    Db::getInstance()->execute(
                        'UPDATE `' . _DB_PREFIX_ . 'wbproductcountdown`
                        SET `from` = "' . pSQL($from) . '", `to` = "' . pSQL($to) . '", `active` = ' . (int)$active . '
                        WHERE `id_countdown` = ' . (int)$id_countdown
                    );

                    foreach (Language::getLanguages(true, false, true) as $id_language) {
                        if (is_array($id_language) && isset($id_language['id_lang'])) {
                            $id_language = $id_language['id_lang'];
                        }
                        $name = Tools::getValue('wbpc_name_' . $id_language);
                        Db::getInstance()->execute(
                            'UPDATE `' . _DB_PREFIX_ . 'wbproductcountdown_lang`
                            SET `name` = "' . pSQL($name) . '"
                            WHERE `id_countdown` = ' . (int)$id_countdown . ' AND `id_lang` = ' . (int)$id_language
                        );
                    }
                }
            } else {
                // If 'from' and 'to' are not submitted and 'active' set to true, then just ignore the countdown
                if (!$from && !$to && $active) {
                    // ignore
                } else {
                    // add countdown
                    Db::getInstance()->execute(
                        'INSERT INTO `' . _DB_PREFIX_ . 'wbproductcountdown`
                        (`id_product`, `id_shop`, `from`, `to`, `active`)
                        VALUES
                        (' . (int)$product->id . ',
                        ' . (int)$this->context->shop->id . ',
                        "' . pSQL($from) . '", "' . pSQL($to) . '",
                        ' . (int)$active . ')'
                    );
                    $id_countdown = Db::getInstance()->Insert_ID();

                    foreach (Language::getLanguages(true, false, true) as $id_language) {
                        if (is_array($id_language) && isset($id_language['id_lang'])) {
                            $id_language = $id_language['id_lang'];
                        }
                        $name = Tools::getValue('wbpc_name_' . $id_language);
                        Db::getInstance()->execute(
                            'INSERT INTO `' . _DB_PREFIX_ . 'wbproductcountdown_lang`
                            (`id_countdown`, `id_lang`, `name`)
                            VALUES
                            (' . (int)$id_countdown . ', ' . (int)$id_language . ', "' . pSQL($name) . '")'
                        );
                    }
                }
            }

            // Clear smarty cache
            if ($this->clear_cache_prod_save) {
                $this->clearSmartyCache();
            }
        }
    }

    public function getContent()
    {
        $this->html = '';
        $this->html .= $this->postProcess();
        $this->html .= $this->renderForm();
        $this->html .= $this->renderCountdownsList();

        return $this->html;
    }

    protected function postProcess()
    {
        $html = '';
        $errors = array();
        $settings_updated = false;

        if (Tools::isSubmit('submitModule')) {
            //saving settings:
            $settings = $this->getSettings();

            foreach ($settings as $item) {
                if ($item['type'] == 'html' || (isset($item['lang']) && $item['lang'] == true)) {
                    continue;
                }

                if (Tools::isSubmit($item['name'])) {
                    Configuration::updateValue(
                        $this->settings_prefix . $item['name'],
                        Tools::getValue($item['name']),
                        true
                    );
                    $settings_updated = true;
                }
            }

            //update lang fields:
            $languages = Language::getLanguages();
            foreach ($settings as $item) {
                if ($item['type'] == 'html') {
                    continue;
                }
                $lang_value = array();
                foreach ($languages as $lang) {
                    if (Tools::isSubmit($item['name'] . '_' . $lang['id_lang'])) {
                        $lang_value[$lang['id_lang']] = Tools::getValue($item['name'] . '_' . $lang['id_lang']);
                        $settings_updated = true;
                    }
                }
                if (sizeof($lang_value)) {
                    Configuration::updateValue($this->settings_prefix . $item['name'], $lang_value, true);
                }
            }
        }

        $this->loadSettings();

        if ($settings_updated && !sizeof($errors)) {
            // Clear smarty cache
            if ($this->clear_cache_mod_save) {
                $this->clearSmartyCache();
            }
            $token = Tools::getAdminTokenLite('AdminModules');
            $redirect_url = 'index.php?tab=AdminModules&configure=' . $this->name . '&token=' . $token . '&conf=6';
            Tools::redirectAdmin($redirect_url);
        } elseif (sizeof($errors)) {
            $html .= '<div class="alert alert-danger">'.implode('<br/>', $errors).'</div>';
        }

        return $html;
    }

    protected function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => $this->getSettings(),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        if ($this->getPSVersion() == 1.5) {
            $fields_form['form']['submit']['class'] = 'button';
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang =
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?
                Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') :
                0;
        $this->fields_form = array();

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) .
            '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => array(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'wbvd' => $this->getPSVersion(true),
        );
        $helper->module = $this;

        foreach ($this->getSettings() as $item) {
            if ($item['type'] == 'html') {
                continue;
            }
            $helper->tpl_vars['fields_value'][$item['name']] = Configuration::get(
                $this->settings_prefix .
                $item['name']
            );
            if ($item['name'] == 'CUSTOM_CSS') {
                $helper->tpl_vars['fields_value'][$item['name']] = html_entity_decode(
                    Configuration::get($this->settings_prefix.$item['name'])
                );
            }
        }

        return $helper->generateForm(array($fields_form));
    }

    public function getSettings()
    {
        $settings = array(
            array(
                'type' => $this->getPSVersion() == 1.5 ? 'radio' : 'switch',
                'name' => 'ACTIVATE_ALL_SPECIAL',
                'label' => $this->l('Show countdown for all products with specific prices:'),
                'class' => 't',
                'values' => array(
                    array(
                        'id' => 'activate_all_special_on',
                        'value' => 1,
                        'label' => $this->l('Yes'),
                    ),
                    array(
                        'id' => 'activate_all_special_off',
                        'value' => 0,
                        'label' => $this->l('No'),
                    ),
                ),
                'hint' => $this->l('Activate this module for all products with specific prices OR 
                    activate it manually for chosen products. 
                    Specific prices will be used only if they have appropriate availability dates.'),
                'default' => 1,
            ),
            array(
                'type' => $this->getPSVersion() == 1.5 ? 'radio' : 'switch',
                'name' => 'SHOW_WEEKS',
                'label' => $this->l('Show weeks:'),
                'class' => 't',
                'values' => array(
                    array(
                        'id' => 'show_weeks_on',
                        'value' => 1,
                        'label' => $this->l('Yes'),
                    ),
                    array(
                        'id' => 'show_weeks_off',
                        'value' => 0,
                        'label' => $this->l('No'),
                    ),
                ),
                'hint' => $this->l('Total remaining time will be shown as weeks+days or just total days.'),
                'default' => 0,
            ),
            array(
                'type' => $this->getPSVersion() == 1.5 ? 'radio' : 'switch',
                'name' => 'HIDE_ZERO_WEEKS',
                'label' => $this->l('Hide zero weeks:'),
                'class' => 't',
                'values' => array(
                    array(
                        'id' => 'hide_zero_weeks_on',
                        'value' => 1,
                        'label' => $this->l('Yes'),
                    ),
                    array(
                        'id' => 'hide_zero_weeks_off',
                        'value' => 0,
                        'label' => $this->l('No'),
                    ),
                ),
                'hint' => $this->l('Hide weeks when they are 00.'),
                'default' => 0,
            ),
            array(
                'type' => $this->getPSVersion() == 1.5 ? 'radio' : 'switch',
                'name' => 'CLEAR_CACHE_MOD_SAVE',
                'label' => $this->l('Clear cache on saving module settings:'),
                'class' => 't',
                'values' => array(
                    array(
                        'id' => 'clear_cache_mod_on',
                        'value' => 1,
                        'label' => $this->l('Yes'),
                    ),
                    array(
                        'id' => 'clear_cache_mod_off',
                        'value' => 0,
                        'label' => $this->l('No'),
                    ),
                ),
                'hint' => $this->l('Enable auto-clearing Smarty cache after saving settings. 
                    Also you can do it manually at the Performance tab as usually.'),
                'default' => 1,
                'validate' => 'isInt',
            ),
            array(
                'type' => $this->getPSVersion() == 1.5 ? 'radio' : 'switch',
                'name' => 'CLEAR_CACHE_PROD_SAVE',
                'label' => $this->l('Clear cache on saving product:'),
                'class' => 't',
                'values' => array(
                    array(
                        'id' => 'clear_cache_product_on',
                        'value' => 1,
                        'label' => $this->l('Yes'),
                    ),
                    array(
                        'id' => 'clear_cache_product_off',
                        'value' => 0,
                        'label' => $this->l('No'),
                    ),
                ),
                'hint' => $this->l('Enable auto-clearing Smarty cache after saving products. 
                    Also you can do it manually at the Performance tab as usually.'),
                'default' => 1,
                'validate' => 'isInt',
            ),
            array(
                'type' => 'theme',
                'name' => 'THEME',
                'label' => $this->l('Theme:'),
                'class' => 't',
                'values' => $this->getThemesOptions(),
                'default' => 'simple.css',
                'col' => 6,
            ),
            array(
                'type' => 'textarea',
                'name' => 'CUSTOM_CSS',
                'label' => $this->l('Custom CSS:'),
                'hint' => $this->l('Add your styles directly in this field without editing files'),
                'validate' => 'isCleanHtml',
                'resize' => true,
            ),
        );

        if ($this->getPSVersion() < 1.6) {
            foreach ($settings as &$item) {
                $desc = isset($item['desc']) ? $item['desc'] : '';
                $hint = isset($item['hint']) ? $item['hint'] . '<br/>' : '';
                $item['desc'] = $hint . $desc;
                $item['hint'] = '';
            }
        }

        return $settings;
    }

    protected function getThemesOptions()
    {
        $options = array();

        foreach ($this->getThemes() as $theme) {
            $options[] = array(
                'id' => $theme['file'],
                'value' => $theme['file'],
                'label' => $theme['name'],
                'img' => $this->_path.'views/img/themes/'.$this->getPSVersion().'/'.$theme['name'].'.png',
            );
        }

        return $options;
    }

    protected function getThemes()
    {
        $themes = array();

        if (file_exists(_PS_MODULE_DIR_ . $this->name . '/views/css/themes/' . $this->getPSVersion() . '/')) {
            $themes_files = scandir(_PS_MODULE_DIR_ . $this->name . '/views/css/themes/' . $this->getPSVersion() . '/');
            foreach ($themes_files as $file) {
                if (strpos($file, '.css') !== false) {
                    $pos = strpos($file, '.css');
                    $themes[] = array('file' => $file, 'name' => Tools::substr($file, 0, $pos),);
                }
            }
        }

        return $themes;
    }

    protected function getThemesSimple()
    {
        $themes = $this->getThemes();

        $return = array();
        foreach ($themes as $theme) {
            $return[] = $theme['file'];
        }

        return $return;
    }

    protected function loadSettings()
    {
        foreach ($this->getSettings() as $item) {
            if ($item['type'] == 'html') {
                continue;
            }
            $name = Tools::strtolower($item['name']);
            $this->$name = Configuration::get($this->settings_prefix . $item['name']);
        }
    }

    protected function getPSVersion($without_dots = false)
    {
        $ps_version = _PS_VERSION_;
        $ps_version = Tools::substr($ps_version, 0, 3);

        if ($without_dots) {
            $ps_version = str_replace('.', '', $ps_version);
        }

        return (float)$ps_version;
    }

    /**
     * @param $id_product
     * @return array
     * returns specific prices where 'from' and 'to' dates are set
     */
    public function getProductSpecificPrices($id_product)
    {
        $prices = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            'SELECT `id_specific_price`,
            `id_shop`,
            `id_currency`,
            `id_country`,
            `id_group`,
            `from_quantity`,
            `from`,
            `to`
            FROM `' . _DB_PREFIX_ . 'specific_price`
            WHERE `id_product` = ' . (int)$id_product . ' AND 
            `from` > 0 AND `to` > 0 AND
            (`id_shop` = ' . $this->context->shop->id . ' OR `id_shop` = 0)'
        );

        return $prices;
    }

    /**
     * @param $id_product
     * @return array
     * For Back Office
     */
    public function getCountdownBOData($id_product)
    {
        $countdown = Db::getInstance()->getRow(
            'SELECT *
            FROM `' . _DB_PREFIX_ . 'wbproductcountdown` wbpc
            WHERE `id_shop` = ' . (int)$this->context->shop->id . ' AND `id_product` = ' . (int)$id_product
        );

        $names = array();
        foreach (Language::getLanguages(true, false, true) as $id_lang) {
            if (is_array($id_lang) && isset($id_lang['id_lang'])) {
                $id_lang = $id_lang['id_lang'];
            }
            $names[$id_lang] = Db::getInstance()->getValue(
                'SELECT `name`
                FROM `' . _DB_PREFIX_ . 'wbproductcountdown_lang` wbpcl
                WHERE `id_countdown` = ' . (int)$countdown['id_countdown'] . ' AND `id_lang` = ' . (int)$id_lang
            );
        }

        if (!$countdown || !is_array($countdown)) {
            $countdown = array();
        } else {
            if ($countdown['from'] == '0000-00-00 00:00:00') {
                $countdown['from'] = '';
            }
            if ($countdown['to'] == '0000-00-00 00:00:00') {
                $countdown['to'] = '';
            }
        }

        $countdown['name'] = $names;

        // Show as active if countdown doesn't exists but activate_all_special is active
        if ($this->activate_all_special && !isset($countdown['id_countdown'])) {
            $countdown['active'] = 1;
        }

        return $countdown;
    }

    /**
     * @param $id_product
     * @return array
     * For Front Office
     * Get a pre-configured countdown or generate a countdown from specific prices
     */
    public function getCountdown($id_product)
    {
        $countdown = Db::getInstance()->getRow(
            'SELECT *
            FROM `' . _DB_PREFIX_ . 'wbproductcountdown` wbpc
            LEFT JOIN  `' . _DB_PREFIX_ . 'wbproductcountdown_lang` wbpcl ON wbpc.`id_countdown` = wbpcl.`id_countdown`
            WHERE `id_shop` = ' . (int)$this->context->shop->id . ' AND
            `id_product` = ' . (int)$id_product . ' AND
            `id_lang` = ' . (int)$this->context->language->id
        );
        $countdown_found = ($countdown && is_array($countdown) && sizeof($countdown));

        // if countdown is disabled then return false and don't generate countdown from specific prices
        if ($countdown_found && !$countdown['active']) {
            return false;
        }

        // If countdown not found and countdowns activated for all products with specific prices:
        if (!$countdown_found && $this->activate_all_special) {
            $product = new Product($id_product);
            $qty = max((int)$product->minimal_quantity, 1);
            $specific_price = SpecificPrice::getSpecificPrice(
                $id_product,
                $this->context->shop->id,
                $this->context->currency->id,
                $this->context->country->id,
                $this->context->customer->id_shop_group,
                $qty,
                null,
                null,
                null,
                $qty
            );
            // todo maybe use a custom query to get specific prices not only for minimal qty
            if ($specific_price && is_array($specific_price) && isset($specific_price['to'])) {
                $countdown = array(
                    'id_countdown' => 0,
                    'id_product' => $id_product,
                    'name' => '',
                    'id_shop' => $this->context->shop->id,
                    'from' => $specific_price['from'],
                    'to' => $specific_price['to'],
                    'active' => 1,
                );
            }
        }

        if ((int)strtotime($countdown['to']) <= 0) {
            return false;
        }

        $countdown['to_time'] = 0;
        if (strtotime($countdown['to']) > 0) {
            $countdown['to_time'] = strtotime($countdown['to']) * 1000;
        }

        return $countdown;
    }

    /**
     * @return array
     * For Back Office
     */
    public function getCountdownsList()
    {
        $active_countdowns = Db::getInstance()->executeS(
            'SELECT wbpc.*, wbpcl.*, pl.`name` AS `product_name`, 0 AS `expired`
            FROM `' . _DB_PREFIX_ . 'wbproductcountdown` wbpc
            LEFT JOIN  `' . _DB_PREFIX_ . 'wbproductcountdown_lang` wbpcl ON wbpc.`id_countdown` = wbpcl.`id_countdown`
            LEFT JOIN  `' . _DB_PREFIX_ . 'product_lang` pl ON
            wbpc.`id_product` = pl.`id_product` AND
            wbpcl.`id_lang` = pl.`id_lang` AND
            wbpc.`id_shop` = pl.`id_shop`
            WHERE wbpc.`id_shop` = ' . (int)$this->context->shop->id . '  AND 
            wbpcl.`id_lang` = ' . (int)$this->context->language->id .'
            AND wbpc.`from` <= NOW() AND wbpc.`to` >= NOW()
            ORDER BY wbpc.`id_product`'
        );

        $inactive_countdowns = Db::getInstance()->executeS(
            'SELECT wbpc.*, wbpcl.*, pl.`name` AS `product_name`, 1 AS `expired`
            FROM `' . _DB_PREFIX_ . 'wbproductcountdown` wbpc
            LEFT JOIN  `' . _DB_PREFIX_ . 'wbproductcountdown_lang` wbpcl ON
            wbpc.`id_countdown` = wbpcl.`id_countdown`
            LEFT JOIN  `' . _DB_PREFIX_ . 'product_lang` pl ON
            wbpc.`id_product` = pl.`id_product` AND
            wbpcl.`id_lang` = pl.`id_lang` AND
            wbpc.`id_shop` = pl.`id_shop`
            WHERE wbpc.`id_shop` = ' . (int)$this->context->shop->id . '  AND 
            wbpcl.`id_lang` = ' . (int)$this->context->language->id .'
            AND (wbpc.`from` > NOW() OR wbpc.`to` < NOW())
            ORDER BY wbpc.`id_product`'
        );

        return array_merge($active_countdowns, $inactive_countdowns);
    }

    protected function renderCountdownsList()
    {
        $countdowns = $this->getCountdownsList();

        if (!sizeof($countdowns)) {
            return null;
        }

        $token = Tools::getAdminTokenLite('AdminModules');
        $ajax_url = 'index.php?tab=AdminModules&configure=' . $this->name . '&token=' . $token;

        $this->context->smarty->assign(array(
            'countdowns' => $countdowns,
            'key_tab' => 'Module'.Tools::ucfirst(Tools::strtolower($this->name)),
            'ajax_url' => $ajax_url,
            'wbv' => $this->getPSVersion(),
            'link' => $this->context->link,
        ));

        return $this->context->smarty->fetch($this->local_path . 'views/templates/admin/countdowns_list.tpl');
    }

    public function ajaxProcessRemoveCountdown()
    {
        $id_countdown = Tools::getValue('id_countdown');

        if ($id_countdown) {
            Db::getInstance()->execute(
                'DELETE FROM `' . _DB_PREFIX_ . 'wbproductcountdown` WHERE `id_countdown` = '.(int)$id_countdown
            );
            die('1');
        }
    }

    protected function clearSmartyCache()
    {
        if (method_exists($this, '_clearCache')) {
            $this->_clearCache('header');
            $this->_clearCache('wbproductcountdown');
        }
    }

    protected function getCacheId($name = null, $to_time = null)
    {
        $cache_array = array();
        $cache_array[] = $name !== null ? $name : $this->name;
        $cache_array[] = $to_time !== null ? $to_time : '';
        if (Configuration::get('PS_SSL_ENABLED')) {
            $cache_array[] = (int)Tools::usingSecureMode();
        }
        if (Shop::isFeatureActive()) {
            $cache_array[] = (int)$this->context->shop->id;
        }
        if (Group::isFeatureActive() && isset($this->context->customer)) {
            $cache_array[] = (int)Group::getCurrent()->id;
            $cache_array[] = implode('_', Customer::getGroupsStatic($this->context->customer->id));
        }
        if (Language::isMultiLanguageActivated()) {
            $cache_array[] = (int)$this->context->language->id;
        }
        if (Currency::isMultiCurrencyActivated()) {
            $cache_array[] = (int)$this->context->currency->id;
        }
        $cache_array[] = (int)$this->context->country->id;
        return implode('|', $cache_array);
    }
}
