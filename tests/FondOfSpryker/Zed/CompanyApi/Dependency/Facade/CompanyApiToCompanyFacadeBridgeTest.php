<?php

namespace FondOfSpryker\Zed\CompanyApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Company\Business\CompanyFacade;

class CompanyApiToCompanyFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeBridge
     */
    protected $companyApiToCompanyFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Company\Business\CompanyFacade
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @return void
     */
    protected function _before()
    {
        parent::_before();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompany = 1;

        $this->companyApiToCompanyFacadeBridge = new CompanyApiToCompanyFacadeBridge(
            $this->companyFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyById(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->with($this->idCompany)
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(CompanyTransfer::class, $this->companyApiToCompanyFacadeBridge->findCompanyById($this->idCompany));
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->companyApiToCompanyFacadeBridge->create($this->companyTransferMock));
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('update')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->companyApiToCompanyFacadeBridge->update($this->companyTransferMock));
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('delete')
            ->with($this->companyTransferMock);

        $this->companyApiToCompanyFacadeBridge->delete($this->companyTransferMock);

        $this->assertNull($this->companyTransferMock->getIdCompany());
    }
}
