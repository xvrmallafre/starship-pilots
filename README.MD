# Starships and Pilots for Magento 2

    xvrmallafre/module-starship_pilots

## Requirements

 - PHP: 7.2.24~
 - Magento: 2.3.4~

`Only tested with versions shown above`

## Main Functionalities

This module will create the option to import Spaceships and Pilots from SWAPI (required a Laravel with the package https://github.com/xvrmallafre/import-products-swapi already installed). The Starships will be created as products in Magento and Pilots are a new Entity. The information is not all contained in the original SWAPI.

The Starships will be created in the default store in Magento, and assigned to the Default Category.

To be able to create Entities via API, is needed an admin user with access to the products and pilots resources.

## Installation

### Via Composer:

 - Install the module composer by running `composer require xvrmallafre/module-starship_pilots:1.0.0`
 - enable the module by running `php bin/magento module:enable Xvrmallafre_StarshipPilots`
 - apply database updates by running `php bin/magento setup:upgrade`
 - Flush the cache by running `php bin/magento cache:flush`

## Specifications

 - Controller
	- frontend > pilots/index/index
