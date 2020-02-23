<?php

namespace Xvrmallafre\StarshipPilots\Model;

use Exception;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Xvrmallafre\StarshipPilots\Api\Data\PilotInterface;
use Xvrmallafre\StarshipPilots\Api\Data\PilotInterfaceFactory;
use Xvrmallafre\StarshipPilots\Api\Data\PilotSearchResultsInterfaceFactory;
use Xvrmallafre\StarshipPilots\Api\PilotRepositoryInterface;
use Xvrmallafre\StarshipPilots\Model\ResourceModel\Pilot as ResourcePilot;
use Xvrmallafre\StarshipPilots\Model\ResourceModel\Pilot\CollectionFactory as PilotCollectionFactory;

class PilotRepository implements PilotRepositoryInterface
{
    /**
     * @var ResourcePilot
     */
    protected $resource;

    /**
     * @var PilotFactory
     */
    protected $pilotFactory;

    /**
     * @var PilotCollectionFactory
     */
    protected $pilotCollectionFactory;

    /**
     * @var PilotSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var PilotInterfaceFactory
     */
    protected $dataPilotFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourcePilot $resource
     * @param PilotFactory $pilotFactory
     * @param PilotInterfaceFactory $dataPilotFactory
     * @param PilotCollectionFactory $pilotCollectionFactory
     * @param PilotSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourcePilot $resource,
        PilotFactory $pilotFactory,
        PilotInterfaceFactory $dataPilotFactory,
        PilotCollectionFactory $pilotCollectionFactory,
        PilotSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->pilotFactory = $pilotFactory;
        $this->pilotCollectionFactory = $pilotCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPilotFactory = $dataPilotFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(PilotInterface $pilot)
    {
        $pilotData = $this->extensibleDataObjectConverter->toNestedArray(
            $pilot,
            [],
            PilotInterface::class
        );

        $pilotModel = $this->pilotFactory->create()->setData($pilotData);

        try {
            $this->resource->save($pilotModel);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the pilot: %1',
                $exception->getMessage()
            ));
        }
        return $pilotModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->pilotCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            PilotInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteByPimId($pimId)
    {
        return $this->delete($this->get($pimId));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PilotInterface $pilot)
    {
        try {
            $pilotModel = $this->pilotFactory->create();
            $this->resource->load($pilotModel, $pilot->getPilotId(), 'pim_id');
            $this->resource->delete($pilotModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Pilot: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get($pimId)
    {
        $pilot = $this->pilotFactory->create();
        $this->resource->load($pilot, $pimId, 'pim_id');
        if (!$pilot->getId()) {
            throw new NoSuchEntityException(__('Pilot with id "%1" does not exist.', $pimId));
        }

        return $pilot->getDataModel();
    }
}
