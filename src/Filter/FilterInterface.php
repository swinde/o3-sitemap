<?php

namespace SWinde\OxidSiteMap\Filter;

use SWinde\OxidSiteMap\Entity\Page;

interface FilterInterface
{
    public function filter(Page $page);
}
