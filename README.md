<h1 align="center">
  <br>
	<img alt="Adobe logo" height="50px" src="https://www.adobe.com/content/dam/cc/icons/Adobe_Corporate_Horizontal_Red_HEX.svg"/>
  <br>
  Magento 2 Export Reviews Extension
  <br>
  <a href="https://packagist.org/packages/shopwhizzy/magento2-export-reviews"><img src="https://img.shields.io/packagist/v/shopwhizzy/magento2-export-reviews.svg" alt="Magento 2 Export Reviews Stable Version"/></a>
  <a href="https://packagist.org/packages/shopwhizzy/magento2-export-reviews"><img src="https://img.shields.io/packagist/dt/shopwhizzy/magento2-export-reviews.svg" alt="Magento 2 Export Reviews Stable Version"/></a>
</h1>


## How does it works?

Export your product reviews to a CSV File

## Install

### Via Composer

Install using [Composer](https://getcomposer.org).

```
composer require shopwhizzy/magento2-export-reviews
php bin/magento module:enable ShopWhizzy_ExportReviews
php bin/magento setup:upgrade
```

## How to use

```
php bin/magento shopwhizzy:export_reviews
```
The var/approved_reviews_export.csv file will be created

## How to get Reviews Using API

Use the following endpoint to get all approved reviews:
```
/rest/all/V1/review/approved/
```

Use the following endpoint to get all approved reviews by SKU:
```
/rest/all/V1/review/approved/{sku}
```

[ShopWhizzy](https://shopwhizzy.com)
