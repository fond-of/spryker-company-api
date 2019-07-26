<?php

namespace FondOfSpryker\Zed\CompanyApi\Communication\Plugin\Api;

use FondOfSpryker\Zed\CompanyApi\CompanyApiConfig;
use Generated\Shared\Transfer\ApiDataTransfer;
use Spryker\Zed\Api\Dependency\Plugin\ApiValidatorPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyApi\CompanyApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\CompanyApi\Business\CompanyApiFacadeInterface getFacade()
 */
class CompanyApiValidatorPlugin extends AbstractPlugin implements ApiValidatorPluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return CompanyApiConfig::RESOURCE_COMPANIES;
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\ApiValidationException
     *
     * @return \Generated\Shared\Transfer\ApiValidationErrorTransfer[]
     */
    public function validate(ApiDataTransfer $apiDataTransfer): array
    {
        return $this->getFacade()->validate($apiDataTransfer);
    }
}
