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

namespace ShopWhizzy\ExportReviews\Model;

use Magento\Framework\Model\AbstractModel;
use ShopWhizzy\ExportReviews\Api\Data\ReviewInterface;

class Review extends AbstractModel implements ReviewInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\ShopWhizzy\ExportReviews\Model\ResourceModel\Review::class);
    }

    /**
     * Load Reviews data from resource model
     *
     * @return array
     */
    public function getReviews(): array
    {
        $this->addData($this->getResource()->loadReviews());
        return $this->getData();
    }

    /**
     * Load Reviews data from resource model by SKU
     *
     * @param string $sku
     * @return array
     */
    public function getReviewsBySku(string $sku): array
    {
        $this->addData($this->getResource()->loadReviews($sku));
        return $this->getData();
    }
}
