<?php


namespace FondOfSpryker\Zed\CompanyApi\Business\Model\Validator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiDataTransfer;

class CompanyApiValidatorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected $apiDataTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Business\Model\Validator\CompanyApiValidator
     */
    protected $companyApiValidator;

    /**
     * @var array
     */
    protected $transferData;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferData = [['name' => 'Lorem Ipsum']];

        $this->companyApiValidator = new CompanyApiValidator();
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($this->transferData);

        $this->assertIsArray($this->companyApiValidator->validate($this->apiDataTransferMock));
    }
}
