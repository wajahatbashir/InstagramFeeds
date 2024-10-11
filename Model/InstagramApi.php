<?php
namespace WB\InstagramFeeds\Model;

class InstagramApi
{
    protected $curl;

    /**
     * Constructor to inject Magento's Curl HTTP client dependency.
     * 
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     */
    public function __construct(
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        $this->curl = $curl; // Assign Curl client to a class property
    }

    /**
     * Fetch Instagram Feeds using the Instagram Graph API.
     * 
     * @param string $accessToken  Instagram API access token.
     * @param int $limit  The number of feeds to fetch.
     * @return array  Returns an array of filtered Instagram image feeds.
     */
    public function getInstagramFeeds($accessToken, $limit)
    {
        // Build the API URL with access token and limit
        $url = 'https://graph.instagram.com/me/media?fields=id,caption,media_url,media_type,permalink&access_token=' . $accessToken . '&limit=' . $limit;
        
        // Perform the GET request to Instagram API
        $this->curl->get($url);
        
        // Get the response body from the API request
        $response = $this->curl->getBody();
        
        // Decode the JSON response into an associative array
        $feeds = json_decode($response, true);

        /**
         * Filter out only image media types from the Instagram feeds.
         * The Instagram API may return videos and carousels as well, but
         * this filter ensures only images are included.
         */
        $imageFeeds = array_filter($feeds['data'], function($feed) {
            return $feed['media_type'] === 'IMAGE'; // Only include 'IMAGE' media types
        });

        /* Debugging code (commented out):
         * To print the filtered image feeds for debugging:
         * echo '<pre>';
         * print_r($imageFeeds);
         * echo '</pre>';
         */

        // Return the filtered array of image feeds
        return $imageFeeds;
    }
}
