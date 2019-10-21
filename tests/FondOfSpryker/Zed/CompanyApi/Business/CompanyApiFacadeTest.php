<?php

namespace FondOfSpryker\Zed\CompanyApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApi;
use FondOfSpryker\Zed\CompanyApi\Business\Model\Validator\CompanyApiValidator;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;

class CompanyApiFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Business\CompanyApiFacade
     */
    protected $companyApiFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Business\CompanyApiBusinessFactory
     */
    protected $companyApiBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApi
     */
    protected $companyApiMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected $apiCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Business\Model\Validator\CompanyApiValidator
     */
    protected $companyApiValidatorMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyApiBusinessFactoryMock = $this->getMockBuilder(CompanyApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyApiMock = $this->getMockBuilder(CompanyApi::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyApiValidatorMock = $this->getMockBuilder(CompanyApiValidator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompany = 1;

        $this->companyApiFacade = new CompanyApiFacade();

        $this->companyApiFacade->setFactory($this->companyApiBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testAddCompany(): void
    {
        $this->companyApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyApi')
            ->willReturn($this->companyApiMock);

        $this->companyApiMock->expects($this->atLeastOnce())
            ->method('add')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApiFacade->addCompany($this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testGetCompany(): void
    {
        $this->companyApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyApi')
            ->willReturn($this->companyApiMock);

        $this->companyApiMock->expects($this->atLeastOnce())
            ->method('get')
            ->with($this->idCompany)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApiFacade->getCompany($this->idCompany));
    }

    /**
     * @return void
     */
    public function testUpdateCompany(): void
    {
        $this->companyApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyApi')
            ->willReturn($this->companyApiMock);

        $this->companyApiMock->expects($this->atLeastOnce())
            ->method('update')
            ->with($this->idCompany, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApiFacade->updateCompany($this->idCompany, $this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testRemoveUpdate(): void
    {
        $this->companyApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyApi')
            ->willReturn($this->companyApiMock);

        $this->companyApiMock->expects($this->atLeastOnce())
            ->method('remove')
            ->with($this->idCompany)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApiFacade->removeCompany($this->idCompany));
    }

    /**
     * @return void
     */
    public function testFindCompanies(): void
    {
        $this->companyApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyApi')
            ->willReturn($this->companyApiMock);

        $this->companyApiMock->expects($this->atLeastOnce())
            ->method('find')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        $this->assertInstanceOf(ApiCollectionTransfer::class, $this->companyApiFacade->findCompanies($this->apiRequestTransferMock));
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->companyApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyApiValidator')
            ->willReturn($this->companyApiValidatorMock);

        $this->companyApiValidatorMock->expects($this->atLeastOnce())
            ->method('validate')
            ->with($this->apiDataTransferMock)
            ->willReturn([]);

        $this->assertIsArray($this->companyApiFacade->validate($this->apiDataTransferMock));
    }
}
