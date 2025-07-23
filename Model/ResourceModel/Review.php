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

namespace ShopWhizzy\ExportReviews\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Review extends AbstractDb
{
    /**
     * Review table
     *
     * @var string
     */
    protected string $reviewTable;

    /**
     * Review Entity Summary table
     *
     * @var string
     */
    protected string $reviewEntitySummaryTable;

    /**
     * Review Detail table
     *
     * @var string
     */
    protected string $reviewDetailTable;

    /**
     * Initialize resource model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('review', 'review_id');
        $this->reviewTable = $this->getTable('review');
        $this->reviewEntitySummaryTable = $this->getTable('review_entity_summary');
        $this->reviewDetailTable = $this->getTable('review_detail');
    }

    /**
     * Load all approved reviews from DB
     *
     * @param string|null $sku
     * @return array
     */
    public function loadReviews(string $sku = null): array
    {
        $connection = $this->getConnection();

        $approvedStatusId = 1;

        $select = $connection->select()->from(
            ['r' => $this->reviewTable],
            ['r.review_id', 'r.status_id', 'r.created_at', 'r.entity_pk_value', 'rd.title', 'rd.detail', 'res.rating_summary', 'rd.nickname', 'rd.email', 'cpe.sku']
        )->joinLeft(
            ['rd' => $this->getTable('review_detail')],
            'rd.review_id = r.review_id',
            []
        )->joinLeft(
            ['res' => $this->getTable('review_entity_summary')],
            'rd.review_id = res.primary_id',
            []
        )->joinLeft(
            ['cpe' => $this->getTable('catalog_product_entity')],
            'r.entity_pk_value = cpe.entity_id',
            []
        );

        $select->where('r.status_id = ?', $approvedStatusId);
        if ($sku)
        {
            $select->where('cpe.sku = ?', $sku);
        }

        $selectString = $select->__toString();
        $result = $connection->fetchAll($select);
        return $result;
    }
}
