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

namespace ShopWhizzy\ExportReviews\Console;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use ShopWhizzy\ExportReviews\Api\Data\ReviewInterface;
use ShopWhizzy\ExportReviews\Api\Data\ReviewInterfaceFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Export extends Command
{
    const FILE_PATH = 'approved_reviews_export.csv';
    /**
     * @var ReviewInterfaceFactory
     */
    private ReviewInterfaceFactory $reviewInterfaceFactory;

    /**
     * @var State
     */
    private State $appState;

    /**
     * @var WriteInterface
     */
    private WriteInterface $directory;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * Import constructor.
     * @param ReviewInterfaceFactory $reviewInterfaceFactory
     * @param State $appState
     * @param Filesystem $filesystem
     * @param CustomerRepositoryInterface $customerRepository
     * @throws FileSystemException
     */
    public function __construct(
        ReviewInterfaceFactory $reviewInterfaceFactory,
        State $appState,
        Filesystem $filesystem,
        CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct();
        $this->appState = $appState;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->reviewInterfaceFactory = $reviewInterfaceFactory;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Configure cli command
     */
    protected function configure()
    {
        $this->setName('shopwhizzy:export_reviews');
        $this->setDescription('Export Product Reviews.');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->areaCodeFix();
        $output->writeln("Starting the export...");

        $this->directory->create('export');
        $stream = $this->directory->openFile(self::FILE_PATH, 'w+');
        $stream->lock();
        $header = ['review_id', 'status_id', 'created_at', 'title', 'detail', 'rating_percentage', 'rating_in_5', 'nickname', 'email', 'sku'];
        $stream->writeCsv($header);

        /** @var ReviewInterface $reviews */
        $reviews = $this->reviewInterfaceFactory->create();

        foreach ($reviews->getReviews() as $review):
            $data = [];
            $data[] = $review['review_id'];
            $data[] = $review['status_id'];
            $data[] = $review['created_at'];
            $data[] = $review['title'];
            $data[] = $review['detail'];
            $data[] = $review['rating_summary'];
            $data[] = number_format(($review['rating_summary'] / 100) * 5, 1);
            $data[] = $review['nickname'];
            $email = $review['email'] ?? '';
            if (empty($email) && !empty($review['customer_id'])) {
                try {
                    $customer = $this->customerRepository->getById($review['customer_id']);
                    $email = $customer->getEmail();
                } catch (\Exception $e) {
                    $email = '';
                }
            }
            $data[] = $email;
            $data[] = $review['sku'];
            $stream->writeCsv($data);
        endforeach;

        $output->writeln("Export finished...");
        return 1;
    }

    /**
     * @throws LocalizedException
     */
    protected function areaCodeFix()
    {
        try {
            $this->appState->getAreaCode();
        } catch (\Exception $exception) {
            $this->appState->setAreaCode(Area::AREA_GLOBAL);
        }
    }
}
