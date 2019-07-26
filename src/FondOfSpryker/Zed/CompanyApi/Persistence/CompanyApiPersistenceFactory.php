<?php

namespace FondOfSpryker\Zed\CompanyApi\Persistence;

use FondOfSpryker\Zed\CompanyApi\CompanyApiDependencyProvider;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyApi\CompanyApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface getQueryContainer()
 */
class CompanyApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(CompanyApiDependencyProvider::PROPEL_QUERY_COMPANY);
    }
}
