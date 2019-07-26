<?php

namespace FondOfSpryker\Zed\CompanyApi\Business\Model\Validator;

use Generated\Shared\Transfer\ApiDataTransfer;

class CompanyApiValidator implements CompanyApiValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return array
     */
    public function validate(ApiDataTransfer $apiDataTransfer): array
    {
        $data = $apiDataTransfer->getData();

        return $this->assertRequiredField($data, 'name', []);
    }

    /**
     * @param array $data
     * @param string $field
     * @param array $errors
     *
     * @return array
     */
    protected function assertRequiredField(array $data, $field, array $errors)
    {
        if (!isset($data[$field]) || (array_key_exists($field, $data) && !$data[$field])) {
            $message = sprintf('Missing value for required field "%s"', $field);
            $errors[$field][] = $message;
        }

        return $errors;
    }
}
