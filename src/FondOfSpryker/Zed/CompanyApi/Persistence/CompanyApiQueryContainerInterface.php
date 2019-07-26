<?php

namespace FondOfSpryker\Zed\CompanyApi\Persistence;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;

interface CompanyApiQueryContainerInterface
{
    /**
     * @api
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function queryFind(): SpyCompanyQuery;
}
