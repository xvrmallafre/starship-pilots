<?php

namespace Xvrmallafre\StarshipPilots\Model;

use Xvrmallafre\StarshipPilots\Api\PilotInterface;

class Pilot implements PilotInterface
{
    public function getPilot(int $pimId)
    {
        return 'PIMID: ' . $pimId;
    }
}
