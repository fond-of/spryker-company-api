<?php

namespace FondOfSpryker\Zed\CompanyApi\Business\Model;

use FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapperInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface;
use FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiPaginationTransfer;
use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Map\TableMap;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\EntityNotFoundException;
use Spryker\Zed\Api\Business\Exception\EntityNotSavedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyApi implements CompanyApiInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface
     */
    protected $apiQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface
     */
    protected $apiQueryBuilderQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface
     */
    protected $companyApiQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapperInterface
     */
    protected $transferMapper;

    /**
     * @param \FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryContainerInterface $apiQueryContainer
     * @param \FondOfSpryker\Zed\CompanyApi\Dependency\QueryContainer\CompanyApiToApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer
     * @param \FondOfSpryker\Zed\CompanyApi\Persistence\CompanyApiQueryContainerInterface $companyApiQueryContainer
     * @param \FondOfSpryker\Zed\CompanyApi\Dependency\Facade\CompanyApiToCompanyFacadeInterface $companyFacade
     * @param \FondOfSpryker\Zed\CompanyApi\Business\Mapper\TransferMapperInterface $transferMapper
     */
    public function __construct(
        CompanyApiToApiQueryContainerInterface $apiQueryContainer,
        CompanyApiToApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer,
        CompanyApiQueryContainerInterface $companyApiQueryContainer,
        CompanyApiToCompanyFacadeInterface $companyFacade,
        TransferMapperInterface $transferMapper
    ) {
        $this->apiQueryContainer = $apiQueryContainer;
        $this->apiQueryBuilderQueryContainer = $apiQueryBuilderQueryContainer;
        $this->companyApiQueryContainer = $companyApiQueryContainer;
        $this->companyFacade = $companyFacade;
        $this->transferMapper = $transferMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function add(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $data = (array)$apiDataTransfer->getData();
        $companyTransfer = (new CompanyTransfer())->fromArray($data, true);
        $companyResponseTransfer = $this->companyFacade->create($companyTransfer);

        if (!$companyResponseTransfer->getIsSuccessful()) {
            $errors = [];

            foreach ($companyResponseTransfer->getMessages() as $error) {
                $errors[] = $error->getText();
            }

            throw new EntityNotSavedException('Could not add company: ' . implode(',', $errors));
        }

        $companyTransfer = $this->companyFacade->findCompanyById($companyTransfer->getIdCompany());

        return $this->apiQueryContainer->createApiItem($companyTransfer, $companyTransfer->getIdCompany());
    }

    /**
     * @param int $idCompany
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get(int $idCompany): ApiItemTransfer
    {
        $companyTransfer = $this->companyFacade->findCompanyById($idCompany);

        if ($companyTransfer === null) {
            throw new EntityNotFoundException(sprintf('Company not found for id %s', $idCompany));
        }

        return $this->apiQueryContainer->createApiItem($companyTransfer, $idCompany);
    }

    /**
     * @param int $idCompany
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update(int $idCompany, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $companyTransfer = $this->companyFacade->findCompanyById($idCompany);

        if ($companyTransfer === null) {
            throw new EntityNotFoundException(sprintf('Company not found: %s', $idCompany));
        }

        $data = (array)$apiDataTransfer->getData();
        $companyTransfer = (new CompanyTransfer())
            ->fromArray($data, true)
            ->setIdCompany($idCompany);

        $companyResponseTransfer = $this->companyFacade->update($companyTransfer);

        if (!$companyResponseTransfer->getIsSuccessful()) {
            $errors = [];

            foreach ($companyResponseTransfer->getMessages() as $message) {
                $errors[] = $message->getText();
            }

            throw new EntityNotSavedException('Could not update company: ' . implode(',', $errors));
        }

        $companyTransfer = $this->companyFacade->findCompanyById($companyTransfer->getIdCompany());

        return $this->apiQueryContainer->createApiItem($companyTransfer, $companyTransfer->getIdCompany());
    }

    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function remove(int $idCompany): ApiItemTransfer
    {
        $companyTransfer = (new CompanyTransfer())->setIdCompany($idCompany);

        $this->companyFacade->delete($companyTransfer);

        return $this->apiQueryContainer->createApiItem([], $idCompany);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        $query = $this->buildQuery($apiRequestTransfer);
        $collection = $this->transferMapper->toTransferCollection($query->find()->toArray());

        foreach ($collection as $k => $companyApiTransfer) {
            $collection[$k] = $this->get($companyApiTransfer->getIdCompany())->getData();
        }

        $apiCollectionTransfer = $this->apiQueryContainer->createApiCollection($collection);
        $apiCollectionTransfer = $this->addPagination($query, $apiCollectionTransfer, $apiRequestTransfer);

        return $apiCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function buildQuery(ApiRequestTransfer $apiRequestTransfer): ModelCriteria
    {
        $apiQueryBuilderQueryTransfer = $this->buildApiQueryBuilderQuery($apiRequestTransfer);
        $query = $this->companyApiQueryContainer->queryFind();
        $query = $this->apiQueryBuilderQueryContainer->buildQueryFromRequest($query, $apiQueryBuilderQueryTransfer);

        return $query;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer
     */
    protected function buildApiQueryBuilderQuery(ApiRequestTransfer $apiRequestTransfer): ApiQueryBuilderQueryTransfer
    {
        $columnSelectionTransfer = $this->buildColumnSelection();

        $apiQueryBuilderQueryTransfer = (new ApiQueryBuilderQueryTransfer())
            ->setApiRequest($apiRequestTransfer)
            ->setColumnSelection($columnSelectionTransfer);

        return $apiQueryBuilderQueryTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer
     */
    protected function buildColumnSelection(): PropelQueryBuilderColumnSelectionTransfer
    {
        $columnSelectionTransfer = new PropelQueryBuilderColumnSelectionTransfer();
        $tableColumns = SpyCompanyTableMap::getFieldNames(TableMap::TYPE_FIELDNAME);

        foreach ($tableColumns as $columnAlias) {
            $columnTransfer = (new PropelQueryBuilderColumnTransfer())
                ->setName(SpyCompanyTableMap::TABLE_NAME . '.' . $columnAlias)
                ->setAlias($columnAlias);

            $columnSelectionTransfer->addTableColumn($columnTransfer);
        }

        return $columnSelectionTransfer;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiCollectionTransfer $apiCollectionTransfer
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected function addPagination(
        ModelCriteria $query,
        ApiCollectionTransfer $apiCollectionTransfer,
        ApiRequestTransfer $apiRequestTransfer
    ): ApiCollectionTransfer {
        $query->setOffset(0)
            ->setLimit(-1);

        $total = $query->count();
        $page = $apiRequestTransfer->getFilter()->getLimit() ? ($apiRequestTransfer->getFilter()->getOffset() / $apiRequestTransfer->getFilter()->getLimit() + 1) : 1;
        $pageTotal = ($total && $apiRequestTransfer->getFilter()->getLimit()) ? (int)ceil($total / $apiRequestTransfer->getFilter()->getLimit()) : 1;

        if ($page > $pageTotal) {
            throw new NotFoundHttpException('Out of bounds.', null, ApiConfig::HTTP_CODE_NOT_FOUND);
        }

        $apiPaginationTransfer = (new ApiPaginationTransfer())
            ->setItemsPerPage($apiRequestTransfer->getFilter()->getLimit())
            ->setPage($page)
            ->setTotal($total)
            ->setPageTotal($pageTotal);

        $apiCollectionTransfer->setPagination($apiPaginationTransfer);

        return $apiCollectionTransfer;
    }
}
