<?php

namespace Xvrmallafre\StarshipPilots\ViewModel;

use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Xvrmallafre\StarshipPilots\Api\PilotRepositoryInterface;

/**
 * Class Pilots
 * @package Xvrmallafre\StarshipPilots\ViewModel
 */
class Pilots implements ArgumentInterface
{
    /**
     * @var Http
     */
    protected $request;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var PilotRepositoryInterface
     */
    protected $pilotRepository;

    /**
     * @var
     */
    protected $product;

    /**
     * Pilots constructor.
     * @param Http $request
     * @param ProductRepositoryInterface $productRepository
     * @param PilotRepositoryInterface $pilotRepository
     */
    public function __construct(
        Http $request,
        ProductRepositoryInterface $productRepository,
        PilotRepositoryInterface $pilotRepository
    ) {
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->pilotRepository = $pilotRepository;
    }

    /**
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getProductUrl()
    {
        $sku = $this->request->getParam('starship');
        $this->product = $this->productRepository->get($sku);

        return $this->product->getUrlModel()->getUrl($this->product);
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function getPilots()
    {
        $pilots = [];
        $productPilots = $this->product->getData('pilots');

        if (strpos($productPilots, ',') == 0) {
            $pilots[] = $this->pilotRepository->get($productPilots);
        } else {
            foreach (explode(',', $productPilots) as $item) {
                if (!empty($item)) {
                    try {
                        $pilots[] = $this->pilotRepository->get($item);
                    } catch (Exception $e) {
                    }
                }
            }
        }

        return $pilots;
    }
}
