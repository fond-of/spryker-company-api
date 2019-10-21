<?php


namespace FondOfSpryker\Zed\CompanyApi;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyApi\Business\CompanyApiBusinessFactory;
use FondOfSpryker\Zed\CompanyApi\Business\Model\CompanyApi;
use FondOfSpryker\Zed\CompanyApi\Business\Model\Validator\CompanyApiValidator;
use FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface;
use FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainer;
use Spryker\Zed\Kernel\Container;

class CompanyApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Business\CompanyApiBusinessFactory
     */
    protected $companyApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\CompanyApiConfig
     */
    protected $companyApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainer
     */
    protected $queryContainerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyApiConfigMock = $this->getMockBuilder(CompanyApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerMock = $this->getMockBuilder(CompanyApiQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyApiBusinessFactory = new CompanyApiBusinessFactory();

        $this->companyApiBusinessFactory->setConfig($this->companyApiConfigMock);
        $this->companyApiBusinessFactory->setQueryContainer($this->queryContainerMock);
        $this->companyApiBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyApi(): void
    {
        $apiQueryContainerMock = $this->getMockBuilder(CompanyApiToApiQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiQueryBuilderQueryContainerMock = $this->getMockBuilder(CompanyApiToApiQueryBuilderQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiToCompanyFacadeMock = $this->getMockBuilder(CompanyApiToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [CompanyApiDependencyProvider::QUERY_CONTAINER_API],
                [CompanyApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [CompanyApiDependencyProvider::FACADE_COMPANY]
            )->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyApiDependencyProvider::QUERY_CONTAINER_API],
                [CompanyApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [CompanyApiDependencyProvider::FACADE_COMPANY]
            )
            ->willReturnOnConsecutiveCalls(
                $apiQueryContainerMock,
                $apiQueryBuilderQueryContainerMock,
                $apiToCompanyFacadeMock
            );

        $company = $this->companyApiBusinessFactory->createCompanyApi();

        $this->assertInstanceOf(CompanyApi::class, $company);
    }

    /**
     * @return void
     */
    public function testCreateCompanyApiValidator(): void
    {
        $validator = $this->companyApiBusinessFactory->createCompanyApiValidator();

        $this->assertInstanceOf(CompanyApiValidator::class, $validator);
    }
}
