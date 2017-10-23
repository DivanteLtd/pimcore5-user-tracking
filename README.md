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
![Divante-logo](http://divante.co///logo_1.png "Divante")

We are a Software House from Europe, headquartered in Poland and employing about 150 people. Our core competencies are built around Magento, Pimcore and bespoke software projects (we love Symfony3, Node.js, Angular, React, Vue.js). We specialize in sophisticated integration projects trying to connect hardcore IT with good product design and UX.

Visit our website [Divante.co](https://divante.co/ "Divante.co") for more information.
