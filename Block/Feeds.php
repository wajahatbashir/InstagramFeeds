<?php
namespace WB\InstagramFeeds\Block;

use Magento\Framework\View\Element\Template;
use WB\InstagramFeeds\Model\InstagramApi;
use Magento\Framework\App\CacheInterface;
use Psr\Log\LoggerInterface;

class Feeds extends Template
{
    protected $instagramApi;
    protected $scopeConfig;
    protected $cache;
    protected $logger;

    /**
     * Constructor to inject dependencies: Instagram API model, config settings, cache, and logger.
     * 
     * @param Template\Context $context
     * @param InstagramApi $instagramApi  Custom Instagram API model.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig  Magento's config scope for admin settings.
     * @param CacheInterface $cache  Magento's cache interface for caching API results.
     * @param LoggerInterface $logger  Logger to log actions and errors.
     * @param array $data  Additional data.
     */
    public function __construct(
        Template\Context $context,
        InstagramApi $instagramApi,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        CacheInterface $cache,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->instagramApi = $instagramApi;
        $this->scopeConfig = $scopeConfig;
        $this->cache = $cache;
        $this->logger = $logger;
        parent::__construct($context, $data);

        $this->logger->info('Instagram Feeds Block Initialized');  // Log initialization
    }

    /**
     * Check if the Instagram Feeds module is enabled in the admin settings.
     * 
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag('instagram_feeds/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Instagram feeds from the API or cache.
     * If cache exists, return cached data. If not, fetch from the API and cache the response.
     * 
     * @return array  List of Instagram feeds or empty array if error occurs.
     */
    public function getInstagramFeeds()
    {
        try {
            $cacheKey = 'instagram_feeds_cache';  // Cache key for storing Instagram feeds data
            $cachedData = $this->cache->load($cacheKey);

            // Check if cached data exists
            if ($cachedData) {
                $this->logger->info('Instagram feeds loaded from cache');  // Log cache usage
                return json_decode($cachedData, true);  // Return cached feeds
            }

            // Fetch access token and feed limit from configuration
            $accessToken = $this->scopeConfig->getValue('instagram_feeds/general/access_token');
            $limit = $this->scopeConfig->getValue('instagram_feeds/general/feeds_limit') ?: 10;  // Default to 10 feeds

            // If access token is missing, log error
            if (!$accessToken) {
                $this->logger->error('Instagram Access Token is missing');
                return [];
            }

            // Fetch Instagram feeds from the API
            $feeds = $this->instagramApi->getInstagramFeeds($accessToken, $limit);

            // Cache the fetched result for 1 day (86400 seconds)
            $this->cache->save(json_encode($feeds), $cacheKey, [], 86400);

            return $feeds;  // Return the fetched feeds
        } catch (\Exception $e) {
            $this->logger->error('Error fetching Instagram feeds: ' . $e->getMessage());  // Log any API or processing errors
            return [];
        }
    }

    /**
     * Check if the tooltip option for captions is enabled in the admin settings.
     * 
     * @return bool
     */
    public function isTooltipEnabled()
    {
        return $this->scopeConfig->getValue(
            'instagram_feeds/general/enable_tooltip',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Fetch slider configuration options from the admin settings.
     * 
     * @return array  Array of slider options (slidesToShow, slidesToScroll, autoplay, etc.).
     */
    public function getSliderOptions()
    {
        return [
            'slidesToShow' => (int)$this->scopeConfig->getValue('instagram_feeds/slider_options/slides_to_show'),
            'slidesToScroll' => (int)$this->scopeConfig->getValue('instagram_feeds/slider_options/slides_to_scroll'),
            'infinite' => (bool)$this->scopeConfig->getValue('instagram_feeds/slider_options/infinite'),
            'autoplay' => (bool)$this->scopeConfig->getValue('instagram_feeds/slider_options/autoplay'),
            'speed' => (int)$this->scopeConfig->getValue('instagram_feeds/slider_options/speed'),
            'autoplaySpeed' => (int)$this->scopeConfig->getValue('instagram_feeds/slider_options/autoplay_speed'),
            'arrows' => (bool)$this->scopeConfig->getValue('instagram_feeds/slider_options/arrows'),
            'dots' => (bool)$this->scopeConfig->getValue('instagram_feeds/slider_options/dots'),
        ];
    }

    /**
     * Fetch a specific configuration value based on the provided path.
     * 
     * @param string $path  Configuration path (e.g., 'instagram_feeds/general/title').
     * @return mixed  The value of the configuration.
     */
    public function getConfig($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
