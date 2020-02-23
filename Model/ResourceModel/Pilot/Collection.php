<?php

namespace Xvrmallafre\StarshipPilots\Model\ResourceModel\Pilot;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Xvrmallafre\StarshipPilots\Model\ResourceModel\Pilot;
use Xvrmallafre\StarshipPilots\Model\Pilot as PilotModel;

/**
 * Class Collection
 *
 * @package Xvrmallafre\StarshipPilots\Model\ResourceModel\Pilot
 */
class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'pilot_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            PilotModel::class,
            Pilot::class
        );
    }
}
