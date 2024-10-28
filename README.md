# Instagram Feeds Carousel for Magento 2

**Version:** 1.0  
**Tested On:** Magento 2.4.x  
**Author:** Wajahat Bashir

## Description 

The Instagram Feeds module for Magento 2.x allows store owners to display Instagram media feeds in a beautiful, responsive carousel. The module supports fetching feeds from Instagram's API, provides customizable slider settings, and can be integrated through widgets, CMS blocks, or directly within layouts. Admin users can configure the module via the Magento admin panel and control various aspects, including the number of slides, autoplay settings, tooltip captions, and more.

## Features

- **Instagram Feed Display**: Display Instagram media feeds in a responsive, slick carousel.
- **Dynamic Slider Options**: Customize the number of slides, scrolling behavior, autoplay settings, arrows, dots, and more from the admin panel.
- **Tooltip Caption**: Enable or disable tooltips on hover that display Instagram post captions (admin configurable).
- **Cache Support**: Instagram API responses are cached for optimal performance.
- **Widget Support**: Add the Instagram Feeds slider to any CMS page or block using the built-in widget.
- **Responsive Design**: The slider is fully responsive with smooth transitions on desktop and mobile devices.
- **Admin Configuration**: Control settings like the number of slides, autoplay speed, slide transitions, and more.
- **Fully Tested**: Compatible with Magento 2.4.x and tested on live projects.


## Usage

### 1. Display Instagram Feeds via CMS Block or Page

You can easily insert the Instagram Feeds slider into any CMS page or block. To do this:
1. Create a new CMS page or block in the Magento admin.
2. Insert the following block code:
   ```
   {{block class="WB\InstagramFeeds\Block\Feeds" template="WB_InstagramFeeds::feeds.phtml"}}
   ```
3. Save the page or block, and the Instagram slider will display at the desired location.


### 2. Admin Configuration

You can configure the Instagram Feeds settings by going to **Stores > Configuration > General > Instagram Feeds**.

#### Admin Options:
- **Enable Instagram Feeds**: Enable or disable the Instagram Feeds module.
- **Instagram Feed Title**: Customize the title displayed above the carousel.
- **Instagram Feed Subheading**: Customize the subheading displayed below the title.
- **Access Token**: Enter the access token to retrieve Instagram feeds.
- **Feeds Limit**: Set the number of Instagram posts to fetch.
- **Slides to Show**: Set how many slides to show at once.
- **Slides to Scroll**: Set how many slides to scroll at once.
- **Infinite Scroll**: Enable or disable infinite scrolling of the slider.
- **Auto Play**: Enable or disable automatic scrolling of the slides.
- **Show Arrows**: Enable or disable navigation arrows.
- **Show Dots**: Enable or disable navigation dots.
- **Speed**: Set the speed of transitions.
- **Autoplay Speed**: Set the speed of autoplay transitions.
- **Tooltip Caption**: Enable or disable tooltips that display the Instagram post caption on hover.

## Screenshots

### Admin View
![Admin View](https://github.com/wajahatbashir/wajahatbashir/blob/main/images/instagram-feeds-backend.jpg)

### Frontend View
![Frontend View](https://github.com/wajahatbashir/wajahatbashir/blob/main/images/instagram-feeds-frontend.jpg)

## Installation

1. Copy the module to `app/code/WB/InstagramFeeds/`.
2. Run the following Magento CLI commands:
   ```bash
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento setup:static-content:deploy
   ```
3. Navigate to **Stores > Configuration > General > Instagram Feeds** and configure the module settings.
4. Flush the cache:
   ```bash
   php bin/magento cache:flush
   ```

## Notes

- Ensure that the **Access Token** is properly configured in the admin settings to fetch Instagram posts.
- The module supports up to 10 Instagram posts by default, but this can be configured.

## License

This module is licensed under the MIT License.