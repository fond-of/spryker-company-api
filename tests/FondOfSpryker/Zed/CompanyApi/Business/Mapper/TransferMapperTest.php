<?php


namespace FondOfSpryker\Zed\CompanyApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyApiTransfer;

class TransferMapperTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapper
     */
    protected $transferMapper;

    /**
     * @var array
     */
    private $transferData;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->transferData = [['name' => 'Lorem Ipsum']];

        $this->transferMapper = new TransferMapper();
    }

    /**
     * @return void
     */
    public function testToTransfer(): void
    {
        $companyApiTransfer = $this->transferMapper->toTransfer($this->transferData[0]);
        $this->assertInstanceOf(CompanyApiTransfer::class, $companyApiTransfer);
        $this->assertEquals('Lorem Ipsum', $companyApiTransfer->getName());
    }

    /**
     * @return void
     */
    public function testToTransferCollection(): void
    {
        $this->assertIsArray($this->transferMapper->toTransferCollection($this->transferData));
        $this->assertEquals('Lorem Ipsum', $this->transferMapper->toTransferCollection($this->transferData)[0]->getName());
    }
}
