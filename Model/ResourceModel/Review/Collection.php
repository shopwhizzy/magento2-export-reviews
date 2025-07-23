<?php

/**
 * Export Reviews Extension by ShopWhizzy
 *
 * @category  ShopWhizzy
 * @package   ShopWhizzy_ExportReviews
 * @author    ShopWhizzy <info@shopwhizzy.com>
 * @copyright Copyright (c) 2025 ShopWhizzy (https://github.com/shopwhizzy)
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace ShopWhizzy\ExportReviews\Model\ResourceModel\Review;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'review_id';
    protected $_eventPrefix = 'shopwhizzy_export_reviews_collection';
    protected $_eventObject = 'review_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ShopWhizzy\ExportReviews\Model\Review', 'ShopWhizzy\ExportReviews\Model\ResourceModel\Review');
    }
}
