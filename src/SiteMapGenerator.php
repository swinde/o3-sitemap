<?php

namespace SWinde\OxidSiteMap;

use OxidEsales\Eshop\Core\Registry;
use SWinde\OxidSiteMap\Entity\Config;
use SWinde\OxidSiteMap\Filter\FilterInterface;
use SWinde\OxidSiteMap\Query\QueryInterface;

/**
 * Class SiteMapGenerator
 * @package SWinde\OxidSiteMap
 */
class SiteMapGenerator
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var array[QueryInterface]
     */
    private $queries;
    /**
     * @var bool
     */
    private $lowerUrls;
    /**
     * @var array[FilterInterface]
     */
    private $filters;

    /**
     * @param Config $config
     * @param array [QueryInterface] $queries
     * @param bool $lowerUrls
     * @param array [FilterInterface] $filters
     */
    public function __construct(Config $config, array $queries, $lowerUrls = false, array $filters = [])
    {
        $this->config = $config;
        foreach ($queries as $query) {
            $this->addQuery($query);
        }
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
        $this->lowerUrls = $lowerUrls;
    }

    /**
     * @param QueryInterface $query
     */
    public function addQuery(QueryInterface $query)
    {
        $this->queries[] = $query;
    }

    /**
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @param array [QueryInterface] $pages
     * @return string
     */
    protected function generateXml($pages)
    {
        $xmlLines   = [];
        $xmlLines[] = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($pages as $page) {
            foreach ($this->filters as $filter) {
                if ($filter->filter($page)) {
                    continue 2;
                }
            }

            $url = $page->getUrl();
            if ($this->lowerUrls) {
                $url = strtolower($url);
            }

            $imageXml = '';
            $image = $page->getImage();
            if ($image) {
                $imageXml = '<image:image>
                                <image:loc>' . $image['url'] . '</image:loc>
                                <image:caption>' . $image['caption'] . '</image:caption>
                            </image:image>';
            }
            $xmlLines[] =  '<url>
                            <loc>' . $url . '</loc>
                            <priority>' . $page->getPriority() . '</priority>
                            ' . $imageXml . '
                            <lastmod>' . $page->getLastmod() . '</lastmod>
                            <changefreq>' . $page->getChangefreq() . '</changefreq>
                            </url>';
        }
        $xmlLines[] = '</urlset>';

        return implode('', $xmlLines);
    }

    /**
     * @param $xml
     */
    protected function createXmlFile($xml)
    {
        $folder = Registry::getConfig()->getConfigParam('sSitemapPath') ?? '/';
        if (!is_dir($this->config->getFilepath() . $folder)) {
            mkdir($this->config->getFilepath() . $folder, 0777, true);
        }
        $file = $this->config->getFilepath() . $folder . $this->config->getFilename();
        $fp   = fopen($file, "w+");
        fwrite($fp, $xml);
        fclose($fp);
    }

    public function generate()
    {
        $pages = [];
        foreach ($this->queries as $query) {
            $pages = array_merge($pages, $query->getPages());
        }
        $this->createXmlFile($this->generateXml($pages));
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}
