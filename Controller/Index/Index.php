<?php

namespace Xvrmallafre\StarshipPilots\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package Xvrmallafre\StarshipPilots\Controller\Index
 */
class Index extends Action
{
    protected $productRepository;

    protected $resultPageFactory;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param UrlInterface $url
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        UrlInterface $url,
        ProductRepositoryInterface $productRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);

        $this->url = $url;
        $this->productRepository = $productRepository;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $noRouteUrl = $this->url->getUrl('noroute');
        $params = $this->getRequest()->getParams();
        $starshipField = 'starship';

        if (array_key_exists($starshipField, $params)) {
            $starship = $params[$starshipField];

            try {
                $starshipProduct = $this->productRepository->get($starship);
                $pilots = $starshipProduct->getData('pilots');

                if (!empty($pilots)) {
                    return $this->resultPageFactory->create();
                }
            } catch (NoSuchEntityException $e) {
            }
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setUrl($noRouteUrl);
    }
}
