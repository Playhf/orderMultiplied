<?php

namespace Playhf\OrderMultiply\Observer;

use Braintree\Exception;
use Playhf\OrderMultiply\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Config\ScopeInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\Data\OrderInterface as OrigOrder;
use Magento\Framework\Message\ManagerInterface;
use Magento\Sales\Model\Order;


class SaveOrderMultiplied implements ObserverInterface
{
    const XML_PATH_IS_ENABLED = 'multiply/general/isactive';

    const XML_PATH_DECIMAL    = 'multiply/general/decimal';

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @var ScopeInterface
     */
    private $scopeConfig;
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * SaveOrderMultiplied constructor.
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param ManagerInterface $messageManager
     * @param ScopeConfigInterface|ScopeInterface $scopeConfig
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        \Psr\Log\LoggerInterface $logger,
        ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->scopeConfig = $scopeConfig;
        $this->messageManager = $messageManager;
    }

    /**
     * Save new multiplied total of order if needed
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        if ($this->getConfig(static::XML_PATH_IS_ENABLED)) {
            $order = $observer->getOrder();
            if ($order instanceof OrigOrder
                && $order->getState() == Order::STATE_COMPLETE
                && $order->getBaseTotalDue() == 0
            ) {
                $decimalFactor = str_replace(',', '.', $this->getConfig(static::XML_PATH_DECIMAL));
                $grantMultiplied = $order->getBaseGrandTotal() * $decimalFactor;

                $multipliedOrder = $this->orderRepository->get();
                $multipliedOrder->setStoreId($order->getStoreId())
                    ->setIncrementId($order->getIncrementId())
                    ->setDecimalFactor($decimalFactor)
                    ->setGrandTotalMultiplied($grantMultiplied);

                try {
                    $this->orderRepository->save($multipliedOrder);
                    $this->messageManager->addSuccessMessage(__("Multiplied order has been saved"));
                } catch (Exception $e) {
                    $this->logger->critical(__("Sorry, order with increment id %1 wasn't saved", $multipliedOrder->getIncrementId()));
                    $this->messageManager->addErrorMessage(__("Multiplied order hasn't been saved"));
                }
            }
        }
        return $this;
    }

    /**
     * Get scope config by path
     *
     * @param $path
     * @return string
     */
    private function getConfig($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}