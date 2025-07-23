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

namespace ShopWhizzy\ExportReviews\Api\Data;

/**
 * Interface ReviewInterface
 * @api
 */
interface ReviewInterface
{
    /**
     * @return array
     */
    public function getReviews(): array;

    /**
     * @param string $sku
     * @return array
     */
    public function getReviewsBySku(string $sku): array;
}
