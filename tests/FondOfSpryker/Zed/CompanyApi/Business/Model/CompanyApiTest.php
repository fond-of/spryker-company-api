<?php


namespace FondOfSpryker\Zed\CompanyApi\Business\Model;

use ArrayObject;
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
use Generated\Shared\Transfer\ResponseMessageTransfer;
use Iterator;

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
     * @var \FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApi
     */
    protected $companyApi;

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
     * @var array
     */
    protected $transferData;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTransferMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @var $this
     */
    protected $companyTransfer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

    /**
     * @var \ArrayObject
     */
    protected $responseMessages;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $responseMessageTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $iteratorMock;

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

        $this->responseMessageTransferMock = $this->getMockBuilder(ResponseMessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder(Iterator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->responseMessages = new ArrayObject(
            [$this->responseMessageTransferMock]
        );
        $this->transferData = [['idCompany' => 1]];

        $this->companyTransfer = (new CompanyTransfer());

        $this->idCompany = 1;

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
        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($this->transferData[0]);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->apiQueryContainerMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApi->add($this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testAddEntityNotSavedException(): void
    {
        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($this->transferData[0]);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getMessages')
            ->willReturn($this->iteratorMock);

        $this->iteratorMock->expects($this->once())
            ->method('rewind');

        $this->iteratorMock->expects($this->exactly(1))
            ->method('next');

        $this->iteratorMock->expects($this->exactly(2))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true);

        $this->iteratorMock->expects($this->exactly(1))
            ->method('current')
            ->willReturn($this->responseMessageTransferMock);

        try {
            $this->companyApi->add($this->apiDataTransferMock);
            $this->fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->with($this->idCompany)
            ->willReturn($this->companyTransferMock);

        $this->apiQueryContainerMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->with($this->companyTransferMock, $this->idCompany)
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApi->get($this->idCompany));
    }

    /**
     * @return void
     */
    public function testGetWithEntityNotFoundException(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->with($this->idCompany)
            ->willReturn(null);

        $this->apiQueryContainerMock->expects($this->never())
            ->method('createApiItem')
            ->with($this->companyTransferMock, $this->idCompany)
            ->willReturn($this->apiItemTransferMock);

        try {
            $this->companyApi->get($this->idCompany);
            $this->fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->with($this->idCompany)
            ->willReturn($this->companyTransferMock);

        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($this->transferData);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('update')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->apiQueryContainerMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApi->update($this->idCompany, $this->apiDataTransferMock));
    }

    /**
     * @return void
     */
    public function testUpdateEntityNotSavedException(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->with($this->idCompany)
            ->willReturn($this->companyTransferMock);

        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($this->transferData);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('update')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getMessages')
            ->willReturn($this->iteratorMock);

        $this->iteratorMock->expects($this->once())
            ->method('rewind');

        $this->iteratorMock->expects($this->exactly(1))
            ->method('next');

        $this->iteratorMock->expects($this->exactly(2))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true);

        $this->iteratorMock->expects($this->exactly(1))
            ->method('current')
            ->willReturn($this->responseMessageTransferMock);

        try {
            $this->companyApi->update($this->idCompany, $this->apiDataTransferMock);
            $this->fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testUpdateEntityNotFoundException(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->with($this->idCompany)
            ->willReturn(null);

        try {
            $this->companyApi->update($this->idCompany, $this->apiDataTransferMock);
            $this->fail();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function testRemove(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('delete')
            ->willReturn(true);

        $this->apiQueryContainerMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->with([], $this->idCompany);

        $this->assertInstanceOf(ApiItemTransfer::class, $this->companyApi->remove($this->idCompany));
    }
}
