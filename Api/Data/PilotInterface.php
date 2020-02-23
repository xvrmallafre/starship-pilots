<?php

namespace Xvrmallafre\StarshipPilots\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface PilotInterface
 * @package Xvrmallafre\StarshipPilots\Api\Data
 */
interface PilotInterface extends ExtensibleDataInterface
{
    const NAME = 'name';
    const GENDER = 'gender';
    const PIM_ID = 'pim_id';

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return PilotInterface
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getGender();

    /**
     * @param string $gender
     * @return PilotInterface
     */
    public function setGender(string $gender);

    /**
     * @return int
     */
    public function getPimId();

    /**
     * @param int $pimId
     * @return PilotInterface
     */
    public function setPimId(int $pimId);
}
