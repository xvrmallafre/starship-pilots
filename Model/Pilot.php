<?php

namespace Xvrmallafre\StarshipPilots\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Xvrmallafre\StarshipPilots\Api\Data\PilotInterface;
use Xvrmallafre\StarshipPilots\Api\Data\PilotInterfaceFactory;
use Xvrmallafre\StarshipPilots\Model\ResourceModel\Pilot\Collection;

/**
 * Class Pilot
 *
 * @package Xvrmallafre\StarshipPilots\Model
 */
class Pilot extends AbstractModel
{

    protected $pilotDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'xvrmallafre_starshippilots_pilot';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PilotInterfaceFactory $pilotDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\Pilot $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PilotInterfaceFactory $pilotDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\Pilot $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->pilotDataFactory = $pilotDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve pilot model with pilot data
     * @return PilotInterface
     */
    public function getDataModel()
    {
        $pilotData = $this->getData();

        $pilotDataObject = $this->pilotDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $pilotDataObject,
            $pilotData,
            PilotInterface::class
        );

        return $pilotDataObject;
    }
}
