<?php


namespace FondOfSpryker\Zed\CompanyApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyApi\Business\CompanyApiFacade;
use FondOfSpryker\Zed\CompanyApi\CompanyApiConfig;
use Generated\Shared\Transfer\ApiDataTransfer;

class CompanyApiValidatorPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Communication\Plugin\Api\CompanyApiValidatorPlugin
     */
    protected $companyApiValidatorPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Business\CompanyApiFacade
     */
    protected $companyApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected $apiDataTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyApiFacadeMock = $this->getMockBuilder(CompanyApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyApiValidatorPlugin = new CompanyApiValidatorPlugin();

        $this->companyApiValidatorPlugin->setFacade($this->companyApiFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetResourceName(): void
    {
        $this->assertSame(CompanyApiConfig::RESOURCE_COMPANIES, $this->companyApiValidatorPlugin->getResourceName());
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->companyApiFacadeMock->expects($this->atLeastOnce())
            ->method('validate')
            ->with($this->apiDataTransferMock)
            ->willReturn([]);

        $this->assertIsArray($this->companyApiValidatorPlugin->validate($this->apiDataTransferMock));
    }
}
