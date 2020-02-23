<?php

namespace Xvrmallafre\StarshipPilots\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Pilot
 *
 * @package Xvrmallafre\StarshipPilots\Model\ResourceModel
 */
class Pilot extends AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('pilot', 'pilot_id');
    }
}
