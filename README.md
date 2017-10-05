# Pimcore 5 user tracking

This is a plugin that captures all requests on the admin panel side and writes to the MongoDB database. Plugin adds a sub-menu item ("User Tracking") under "Tools" in the main menu, on click it opens new tab with all requests.

## Compatibility
This module is compatible with Pimcore ^5.0.

## Requirements
This plugin requires php >= 7.0 and php-mongodb extension (ext-mongodb).

## Installing/Getting started
### First step
```
composer require divante-ltd/pimcore5-user-tracking
```
### Second step
Open Extension tab in admin panel and install plugin. Then, in the same tab, configure access data to MongoDB. After this, installation is finished.

## Contributing
If you'd like to contribute, please fork the repository and use a feature branch. Pull requests are warmly welcome.

## Standards & Code Quality
This module respects our own PHPCS and PHPMD rulesets.

## About Authors
![Divante-logo](http://divante.co/wp-content/uploads/2017/07/divante-logo.png "Divante")

Founded in 2008 in Poland, Divante delivers high-quality e-business solutions. They support their clients in creating customized Omnichannel and eCommerce platforms, with expertise in CRM, ERP, PIM, custom web applications, and Big Data solutions. With 180 employees on board, Divante provides software expertise and user-experience design. Their team assists companies in their development and optimization of new sales channels by implementing eCommerce solutions, integrating systems, and designing and launching marketing campaigns.

Visit our website [Divante.co](https://divante.co/ "Divante.co") for more information.
