<?php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2018 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

//DONGND:: install database for product review
$res = (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review` (
        `id_product_review` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_product` int(10) unsigned NOT NULL,
        `id_customer` int(10) unsigned NOT NULL,
        `id_guest` int(10) unsigned NULL,
        `title` varchar(64) NULL,
        `content` text NOT NULL,
        `customer_name` varchar(64) NULL,
        `grade` float unsigned NOT NULL,
        `validate` tinyint(1) NOT NULL,
        `deleted` tinyint(1) NOT NULL,
        `date_add` datetime NOT NULL,
        PRIMARY KEY (`id_product_review`),
        KEY `id_product` (`id_product`),
        KEY `id_customer` (`id_customer`),
        KEY `id_guest` (`id_guest`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8;
');
$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review_criterion` (
        `id_product_review_criterion` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_product_review_criterion_type` tinyint(1) NOT NULL,
        `active` tinyint(1) NOT NULL,
        PRIMARY KEY (`id_product_review_criterion`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
');

$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review_criterion_product` (
        `id_product` int(10) unsigned NOT NULL,
        `id_product_review_criterion` int(10) unsigned NOT NULL,
        PRIMARY KEY(`id_product`, `id_product_review_criterion`),
        KEY `id_product_review_criterion` (`id_product_review_criterion`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
');


$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review_criterion_lang` (
      `id_product_review_criterion` INT(11) UNSIGNED NOT NULL ,
      `id_lang` INT(11) UNSIGNED NOT NULL ,
      `name` VARCHAR(64) NOT NULL ,
      PRIMARY KEY ( `id_product_review_criterion` , `id_lang` )
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review_criterion_category` (
       `id_product_review_criterion` int(10) unsigned NOT NULL,
        `id_category` int(10) unsigned NOT NULL,
        PRIMARY KEY(`id_product_review_criterion`, `id_category`),
        KEY `id_category` (`id_category`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review_grade` (
        `id_product_review_grade` int(10) unsigned NOT NULL AUTO_INCREMENT,
       `id_product_review` int(10) unsigned NOT NULL,
        `id_product_review_criterion` int(10) unsigned NOT NULL,
        `grade` int(10) unsigned NOT NULL,
        PRIMARY KEY (`id_product_review_grade`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review_usefulness` (
       `id_product_review` int(10) unsigned NOT NULL,
        `id_customer` int(10) unsigned NOT NULL,
        `usefulness` tinyint(1) unsigned NOT NULL,
        PRIMARY KEY (`id_product_review`, `id_customer`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_product_review_report` (
       `id_product_review` int(10) unsigned NOT NULL,
        `id_customer` int(10) unsigned NOT NULL,
        PRIMARY KEY (`id_product_review`, `id_customer`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
    'SELECT id_product_review_criterion FROM `'._DB_PREFIX_.'wbfeature_product_review_criterion`'
);

if (count($rows) <= 0) {
    $res &= (bool)Db::getInstance()->execute('
        INSERT INTO `'._DB_PREFIX_.'wbfeature_product_review_criterion` VALUES (1, 1, 1)
    ');
    $languages = Language::getLanguages(false);
    foreach ($languages as $lang) {
        $res &= (bool)Db::getInstance()->execute('
            INSERT INTO `'._DB_PREFIX_.'wbfeature_product_review_criterion_lang` VALUES(1, '.(int)$lang['id_lang'].', \'Quality\')
        ');
    }
}

//DONGND:: install database for product compare
$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_compare` (
        `id_compare` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_customer` int(10) unsigned NOT NULL,
        PRIMARY KEY (`id_compare`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_compare_product` (
        `id_compare` int(10) unsigned NOT NULL,
        `id_product` int(10) unsigned NOT NULL,
        `date_add` datetime NOT NULL,
        `date_upd` datetime NOT NULL,
        PRIMARY KEY (`id_compare`, `id_product`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

//DONGND:: install database for wishlist
$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_wishlist` (
        `id_wishlist` int(10) unsigned NOT NULL auto_increment,
        `id_customer` int(10) unsigned NOT NULL,
        `token` varchar(64) character set utf8 NOT NULL,
        `name` varchar(64) character set utf8 NOT NULL,
        `counter` int(10) unsigned NULL,
        `id_shop` int(10) unsigned default 1,
        `id_shop_group` int(10) unsigned default 1,
        `date_add` datetime NOT NULL,
        `date_upd` datetime NOT NULL,
        `default` int(10) unsigned default 0,
    PRIMARY KEY (`id_wishlist`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');

$res &= (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'wbfeature_wishlist_product` (
        `id_wishlist_product` int(10) NOT NULL auto_increment,
        `id_wishlist` int(10) unsigned NOT NULL,
        `id_product` int(10) unsigned NOT NULL,
        `id_product_attribute` int(10) unsigned NOT NULL,
        `quantity` int(10) unsigned NOT NULL,
        `priority` int(10) unsigned NOT NULL,
        PRIMARY KEY (`id_wishlist_product`)
    ) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8; 
');
