<?php

namespace Xvrmallafre\StarshipPilots\Api;

/**
 * Interface PilotInterface
 * @package Xvrmallafre\StarshipPilots\Api
 */
interface PilotInterface
{
    /**
     * @param int $pimId
     * @return mixed
     */
    public function getPilot(int $pimId);
}
