<?php

namespace FondOfSpryker\Zed\CompanyApi\Persistence;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiPersistenceFactory getFactory()
 */
class CompanyApiQueryContainer extends AbstractQueryContainer implements CompanyApiQueryContainerInterface
{
    /**
     * @api
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function queryFind(): SpyCompanyQuery
    {
        return $this->getFactory()->getCompanyQuery();
    }
}
