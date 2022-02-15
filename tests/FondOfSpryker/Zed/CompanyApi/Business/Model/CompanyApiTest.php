<?php

namespace FondOfSpryker\Zed\CompanyApi\Business\Model;

use Codeception\Test\Unit;
use Exception;
use FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapperInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface;
use FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyApiTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface
     */
    protected $apiQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface
     */
    protected $apiQueryBuilderQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface
     */
    protected $companyApiQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapperInterface
     */
    protected $transferMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApi
     */
    protected $companyApi;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiQueryContainerMock = $this->getMockBuilder(CompanyApiToApiQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiQueryBuilderQueryContainerMock = $this->getMockBuilder(CompanyApiToApiQueryBuilderQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyApiQueryContainerMock = $this->getMockBuilder(CompanyApiQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyApiToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMapperMock = $this->getMockBuilder(TransferMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyApi = new CompanyApi(
            $this->apiQueryContainerMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->companyApiQueryContainerMock,
            $this->companyFacadeMock,
            $this->transferMapperMock
        );
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $data = [];
        $idCompany = 1;

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->apiQueryContainerMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with($this->companyTransferMock, $idCompany)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->companyApi->add($this->apiDataTransferMock)
        );
    }

    /**
     * @return void
     */
    public function testAddEntityNotSavedException(): void
    {
        $data = [];

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn(null);

        $this->companyResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');


        $this->apiQueryContainerMock->expects(static::never())
            ->method('createApiItem');

        try {
            $this->companyApi->add($this->apiDataTransferMock);
            static::fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $idCompany = 1;

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyById')
            ->with($idCompany)
            ->willReturn($this->companyTransferMock);

        $this->apiQueryContainerMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with($this->companyTransferMock, $idCompany)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals($this->apiItemTransferMock, $this->companyApi->get($idCompany));
    }

    /**
     * @return void
     */
    public function testGetWithEntityNotFoundException(): void
    {
        $idCompany = 1;

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyById')
            ->with($idCompany)
            ->willReturn(null);

        $this->apiQueryContainerMock->expects($this->never())
            ->method('createApiItem')
            ->with($this->companyTransferMock, $idCompany)
            ->willReturn($this->apiItemTransferMock);

        try {
            $this->companyApi->get($idCompany);
            static::fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $idCompany = 1;
        $data = [];

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyById')
            ->with($idCompany)
            ->willReturn($this->companyTransferMock);

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->with($data, true)
            ->willReturn($this->companyTransferMock);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->apiQueryContainerMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with($this->companyTransferMock, $idCompany)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->companyApi->update($idCompany, $this->apiDataTransferMock)
        );
    }

    /**
     * @return void
     */
    public function testUpdateEntityNotSavedException(): void
    {
        $idCompany = 1;
        $data = [];

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyById')
            ->with($idCompany)
            ->willReturn($this->companyTransferMock);

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->with($data, true)
            ->willReturn($this->companyTransferMock);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn(null);

        $this->companyResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        try {
            $this->companyApi->update($idCompany, $this->apiDataTransferMock);
            static::fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testUpdateEntityNotFoundException(): void
    {
        $idCompany = 1;

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyById')
            ->with($idCompany)
            ->willReturn(null);

        $this->companyFacadeMock->expects(static::never())
            ->method('update');

        $this->apiQueryContainerMock->expects(static::never())
            ->method('createApiItem');

        try {
            $this->companyApi->update($idCompany, $this->apiDataTransferMock);
            static::fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testRemove(): void
    {
        $idCompany = 1;

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('delete')
            ->with(
                static::callback(
                    static function(CompanyTransfer $companyTransfer) use ($idCompany) {
                        return $companyTransfer->getIdCompany() === $idCompany;
                    }
                )
            );

        $this->apiQueryContainerMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->with([], $idCompany)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->companyApi->remove($idCompany)
        );
    }
}
