<?php

namespace Xvrmallafre\StarshipPilots\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Xvrmallafre\StarshipPilots\Api\Data\PilotInterface;
use Xvrmallafre\StarshipPilots\Api\Data\PilotSearchResultsInterface;

interface PilotRepositoryInterface
{
    /**
     * Save Pilot
     * @param PilotInterface $pilot
     * @return PilotInterface
     * @throws LocalizedException
     */
    public function save(
        PilotInterface $pilot
    );

    /**
     * Retrieve Pilot
     * @param string $pimId
     * @return PilotInterface
     * @throws LocalizedException
     */
    public function get($pimId);

    /**
     * Retrieve Pilot matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return PilotSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Pilot
     * @param PilotInterface $pilot
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(PilotInterface $pilot);

    /**
     * Delete Pilot by ID
     * @param string $pimId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteByPimId($pimId);
}
