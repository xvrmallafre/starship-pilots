<?php

namespace Xvrmallafre\StarshipPilots\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface PilotSearchResultsInterface
 *
 * @package Xvrmallafre\StarshipPilots\Api\Data
 */
interface PilotSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get Review list.
     * @return PilotInterface[]
     */
    public function getItems();

    /**
     * Set review list.
     * @param PilotInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
