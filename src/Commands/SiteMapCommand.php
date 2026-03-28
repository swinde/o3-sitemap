<?php

namespace SWinde\OxidSiteMap\Commands;

use SWinde\OxidSiteMap\SiteMapGenerator;
use OxidEsales\EshopCommunity\Internal\Framework\Console\AbstractShopAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use OxidEsales\Eshop\Core\Registry;

class SiteMapCommand extends AbstractShopAwareCommand
{
    private $siteMapGenerator;

    /**
     * SiteMapCommand constructor.
     * @param SiteMapGenerator $siteMapGenerator
     * @param null $name
     */
    public function __construct(SiteMapGenerator $siteMapGenerator, $name = null)
    {
        $this->siteMapGenerator = $siteMapGenerator;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('SWinde:sitemap:generate')
            ->setDescription('Sitemap generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Generating Sitemap');
        $this->siteMapGenerator->generate();
        $folder = Registry::getConfig()->getConfigParam('sSitemapPath') ?? '/';
        $output->writeln(
            'Generated Sitemap in ' .
            $this->siteMapGenerator->getConfig()->getFilepath() .
            $folder .
            $this->siteMapGenerator->getConfig()->getFilename()
        );

        return 0;
    }
}
