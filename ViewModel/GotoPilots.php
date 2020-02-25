<?php

namespace Xvrmallafre\StarshipPilots\ViewModel;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\UrlInterface;

/**
 * Class GotoPilots
 * @package Xvrmallafre\StarshipPilots\ViewModel
 */
class GotoPilots implements ArgumentInterface
{
    /**
     * @var Http
     */
    protected $request;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var mixed
     */
    private $currentProduct;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Pilots constructor.
     * @param Http $request
     * @param Registry $registry
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        Http $request,
        Registry $registry,
        UrlInterface $urlBuilder
    ) {
        $this->request = $request;
        $this->registry = $registry;
        $this->urlBuilder = $urlBuilder;

        $this->currentProduct = $this->registry->registry('current_product');
    }

    public function getUrlGotoPilots()
    {
        $product = $this->currentProduct;
        $sku = $product->getSku();

        return $this->urlBuilder->getUrl('pilots/', ['_query' => ['starship' => $sku]]);
    }

    public function starshipHasPilots()
    {
        $pilots = $this->currentProduct->getPilots();

        return (!empty($pilots));
    }
}
