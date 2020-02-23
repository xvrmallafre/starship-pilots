<?php

namespace Xvrmallafre\StarshipPilots\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Xvrmallafre\StarshipPilots\Api\Data\PilotInterface;

class Pilot extends AbstractExtensibleObject implements PilotInterface
{

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getGender()
    {
        return $this->_get(self::GENDER);
    }

    /**
     * @inheritDoc
     */
    public function setGender(string $gender)
    {
        return $this->setData(self::GENDER, $gender);
    }

    /**
     * @inheritDoc
     */
    public function getPimId()
    {
        return $this->_get(self::PIM_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPimId(int $pimId)
    {
        return $this->setData(self::PIM_ID, $pimId);
    }
}
