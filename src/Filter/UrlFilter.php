<?php

namespace SWinde\OxidSiteMap\Filter;

use SWinde\OxidSiteMap\Entity\Page;

/**
 * Class UrlFilter
 * @package SWinde\OxidSiteMap\Filter
 */
class UrlFilter implements FilterInterface
{
    private $shopUrl;
    private $urls;

    /**
     * UrlFilter constructor.
     * @param string $shopUrl
     * @param array $urls
     */
    public function __construct(string $shopUrl, array $urls)
    {
        $this->shopUrl = $shopUrl;
        $this->urls    = array_flip(
            array_map(
                function ($url) {
                    return $this->shopUrl . $url;
                },
                $urls
            )
        );
    }

    /**
     * @param Page $page
     * @return bool
     */
    public function filter(Page $page)
    {
        return isset($this->urls[$this->shopUrl . $page->getUrl()]);
    }
}
