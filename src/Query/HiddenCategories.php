<?php

namespace SWinde\OxidSiteMap\Query;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class HiddenCategories
 * @package SWinde\OxidSiteMap\Query
 */
class HiddenCategories extends AbstractQuery
{
    public function getQuery(QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder->select('oxid', 'oxtitle', 'oxdesc', 'oxlongdesc','oxthumb', 'oxseo.oxstdurl', 'oxseo.oxseourl')
                     ->from('oxcategories')
                     ->join('oxcategories', 'oxseo', 'oxseo', 'oxseo.OXOBJECTID = oxcategories.OXID')
                     ->where('oxactive = :active', 'oxhidden = :hidden')
                     ->andWhere('oxlang IN (:langIds)')
                     ->orderBy('oxtitle', 'ASC')
                     ->setParameters([
                         'active'  => 1,
                         'hidden'  => 0,
                         'langIds' => implode(',', $this->config->getLangIds()),
                     ]);

        return $queryBuilder;
    }
}
