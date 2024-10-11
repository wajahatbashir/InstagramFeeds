<?php
namespace WB\InstagramFeeds\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use WB\InstagramFeeds\Model\InstagramApi;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Feeds extends Action
{
    protected $instagramApi;
    protected $scopeConfig;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        InstagramApi $instagramApi,
        ScopeConfigInterface $scopeConfig,
        JsonFactory $resultJsonFactory
    ) {
        $this->instagramApi = $instagramApi;
        $this->scopeConfig = $scopeConfig;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $accessToken = $this->scopeConfig->getValue('instagram_feeds/general/access_token');
        $limit = $this->scopeConfig->getValue('instagram_feeds/general/feeds_limit') ?: 10;

        $feeds = $this->instagramApi->getInstagramFeeds($accessToken, $limit);
        return $result->setData($feeds);
    }
}
