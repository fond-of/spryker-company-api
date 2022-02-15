<?php

namespace FondOfSpryker\Zed\CompanyApi\Business\Mapper;

use Generated\Shared\Transfer\CompanyApiTransfer;

class TransferMapper implements TransferMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\CompanyApiTransfer
     */
    public function toTransfer(array $data): CompanyApiTransfer
    {
        return (new CompanyApiTransfer())->fromArray($data, true);
    }

    /**
     * @param array $data
     *
     * @return array<\Generated\Shared\Transfer\CompanyApiTransfer>
     */
    public function toTransferCollection(array $data): array
    {
        $transferCollection = [];

        foreach ($data as $itemData) {
            $transferCollection[] = $this->toTransfer($itemData);
        }

        return $transferCollection;
    }
}
