-- phpMyAdmin SQL Dump
-- version 2.11.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2010 at 03:15 AM
-- Server version: 5.0.91
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL auto_increment,
  `banner_type` varchar(255) NOT NULL,
  `banner_group` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `clicks` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `banner_group` (`banner_group`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `banners_lang`
--

CREATE TABLE IF NOT EXISTS `banners_lang` (
  `id` int(11) NOT NULL auto_increment,
  `banner_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `banner_id` (`banner_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `order` int(11) NOT NULL,
  `img` blob,
  `appear_on_site` enum('n','y') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`,`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories_lang`
--

CREATE TABLE IF NOT EXISTS `categories_lang` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `category_id` (`category_id`,`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL auto_increment,
  `date_added` date NOT NULL,
  `type` enum('person','company') NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `fiscal_code` varchar(255) NOT NULL,
  `nr_ord_reg_com` varchar(255) NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `cnp` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `county` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `client_orders`
--

CREATE TABLE IF NOT EXISTS `client_orders` (
  `id` int(11) NOT NULL auto_increment,
  `order_nr` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `client_id` int(11) NOT NULL,
  `status` enum('n','c','o','f') NOT NULL default 'n',
  `pay_type` int(11) NOT NULL,
  `transport_type` int(11) NOT NULL,
  `pay_type_price` double NOT NULL,
  `transport_price` double NOT NULL,
  `total` double NOT NULL,
  `client_obs` longtext NOT NULL,
  `obs` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `client_id` (`client_id`),
  KEY `pay_type` (`pay_type`),
  KEY `transport_type` (`transport_type`),
  KEY `status` (`status`),
  KEY `date_added` (`date_added`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `client_orders_re_products`
--

CREATE TABLE IF NOT EXISTS `client_orders_re_products` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `client_order_product_re_property_values`
--

CREATE TABLE IF NOT EXISTS `client_order_product_re_property_values` (
  `id` int(11) NOT NULL auto_increment,
  `order_product_id` int(11) NOT NULL,
  `property_value_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE IF NOT EXISTS `counties` (
  `id` tinyint(2) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `short_name` char(2) NOT NULL default '',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE IF NOT EXISTS `general_settings` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL auto_increment,
  `code` char(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` enum('n','y') NOT NULL,
  `admin_default` enum('n','y') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL auto_increment,
  `lang_id` int(11) NOT NULL,
  `date_added` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE IF NOT EXISTS `payment_type` (
  `id` int(11) NOT NULL auto_increment,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `producers`
--

CREATE TABLE IF NOT EXISTS `producers` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `web` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `producer_id` int(11) default NULL,
  `price` double NOT NULL,
  `in_stock` enum('n','y') NOT NULL default 'y',
  `available_online` enum('n','y') NOT NULL default 'y',
  `appear_on_site` enum('n','y') NOT NULL default 'n',
  `featured` enum('n','y') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `products_discount`
--

CREATE TABLE IF NOT EXISTS `products_discount` (
  `id` int(11) NOT NULL auto_increment,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `value` double NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `start_date` (`start_date`,`end_date`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `products_lang`
--

CREATE TABLE IF NOT EXISTS `products_lang` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `short_desc` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `un` (`product_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `products_re_categories`
--

CREATE TABLE IF NOT EXISTS `products_re_categories` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `product_id_2` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_pictures`
--

CREATE TABLE IF NOT EXISTS `product_pictures` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `main` enum('n','y') NOT NULL default 'n',
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `product_pictures_product` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_pictures_lang`
--

CREATE TABLE IF NOT EXISTS `product_pictures_lang` (
  `id` int(11) NOT NULL auto_increment,
  `picture_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `picture_id` (`picture_id`,`lang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property`
--

CREATE TABLE IF NOT EXISTS `product_property` (
  `id` int(11) NOT NULL auto_increment,
  `property_category_id` int(11) NOT NULL,
  `type` enum('numeric','fixed','yes_no') NOT NULL,
  `um` char(30) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_category`
--

CREATE TABLE IF NOT EXISTS `product_property_category` (
  `id` int(11) NOT NULL auto_increment,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_category_lang`
--

CREATE TABLE IF NOT EXISTS `product_property_category_lang` (
  `id` int(11) NOT NULL auto_increment,
  `property_category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `property_category_id` (`property_category_id`,`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_lang`
--

CREATE TABLE IF NOT EXISTS `product_property_lang` (
  `id` int(11) NOT NULL auto_increment,
  `property_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `property_id` (`property_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_re_category`
--

CREATE TABLE IF NOT EXISTS `product_property_re_category` (
  `id` int(11) NOT NULL auto_increment,
  `property_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `property_id` (`property_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_values`
--

CREATE TABLE IF NOT EXISTS `product_property_values` (
  `id` int(11) NOT NULL auto_increment,
  `property_id` int(11) NOT NULL,
  `numeric_value` double NOT NULL,
  `yes_no_value` enum('y','n') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_values_lang`
--

CREATE TABLE IF NOT EXISTS `product_property_values_lang` (
  `id` int(11) NOT NULL auto_increment,
  `property_value_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `property_value_id` (`property_value_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_property_values_re_product`
--

CREATE TABLE IF NOT EXISTS `product_property_values_re_product` (
  `id` int(11) NOT NULL auto_increment,
  `property_values_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `change_price` enum('no','add','replace','add_percent') NOT NULL,
  `change_price_value` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL auto_increment,
  `lang_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `description` text NOT NULL,
  `approved` enum('n','y') NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `transport_type`
--

CREATE TABLE IF NOT EXISTS `transport_type` (
  `id` int(11) NOT NULL auto_increment,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `whishlist`
--

CREATE TABLE IF NOT EXISTS `whishlist` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_added` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `whishlist_product_id` (`product_id`),
  KEY `whishlist_client_id` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `products_re_categories`
--
ALTER TABLE `products_re_categories`
  ADD CONSTRAINT `products_re_categories_cat` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_re_categories_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_pictures`
--
ALTER TABLE `product_pictures`
  ADD CONSTRAINT `product_pictures_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `whishlist`
--
ALTER TABLE `whishlist`
  ADD CONSTRAINT `whishlist_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `whishlist_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);



CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `code` char(3) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `default` enum('n','y') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;