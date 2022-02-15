<?php

namespace FondOfSpryker\Zed\CompanyApi\Business;

use FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapper;
use FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapperInterface;
use FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApi;
use FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApiInterface;
use FondOfSpryker\Zed\CompanyApi\Business\Model\Validator\CompanyApiValidator;
use FondOfSpryker\Zed\CompanyApi\Business\Model\Validator\CompanyApiValidatorInterface;
use FondOfSpryker\Zed\CompanyApi\CompanyApiDependencyProvider;
use FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyApi\CompanyApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface getQueryContainer()
 */
class CompanyApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApiInterface
     */
    public function createCompanyApi(): CompanyApiInterface
    {
        return new CompanyApi(
            $this->getApiQueryContainer(),
            $this->getApiQueryBuilderQueryContainer(),
            $this->getQueryContainer(),
            $this->getCompanyFacade(),
            $this->createTransferMapper(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface
     */
    protected function getApiQueryContainer(): CompanyApiToApiQueryContainerInterface
    {
        return $this->getProvidedDependency(CompanyApiDependencyProvider::QUERY_CONTAINER_API);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface
     */
    protected function getApiQueryBuilderQueryContainer(): CompanyApiToApiQueryBuilderQueryContainerInterface
    {
        return $this->getProvidedDependency(CompanyApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyApiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyApiDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapperInterface
     */
    protected function createTransferMapper(): TransferMapperInterface
    {
        return new TransferMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyApi\Business\Model\Validator\CompanyApiValidatorInterface
     */
    public function createCompanyApiValidator(): CompanyApiValidatorInterface
    {
        return new CompanyApiValidator();
    }
}
