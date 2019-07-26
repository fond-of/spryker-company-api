<?php

namespace FondOfSpryker\Zed\CompanyApi\Business\Mapper;

use Generated\Shared\Transfer\CompanyApiTransfer;

interface TransferMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\CompanyApiTransfer
     */
    public function toTransfer(array $data): CompanyApiTransfer;

    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\CompanyApiTransfer[]
     */
    public function toTransferCollection(array $data): array;
}
