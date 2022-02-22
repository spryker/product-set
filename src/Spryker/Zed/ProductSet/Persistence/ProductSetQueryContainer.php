<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSet\Persistence;

use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Spryker\Zed\ProductSet\Persistence\ProductSetPersistenceFactory getFactory()
 */
class ProductSetQueryContainer extends AbstractQueryContainer implements ProductSetQueryContainerInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductSetQuery
     */
    public function queryProductSet()
    {
        return $this->getFactory()
            ->createProductSetQuery();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductSetDataQuery
     */
    public function queryAllProductSetData()
    {
        return $this->getFactory()
            ->createProductSetDataQuery();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductAbstractSetQuery
     */
    public function queryProductAbstractSet()
    {
        return $this->getFactory()
            ->createProductAbstractSetQuery();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductSet
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductSetQuery
     */
    public function queryProductSetById($idProductSet)
    {
        return $this->queryProductSet()
            ->filterByIdProductSet($idProductSet);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $productSetIds
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductSetQuery
     */
    public function queryProductSetByIds(array $productSetIds)
    {
        return $this->getFactory()
            ->createProductSetQuery()
            ->filterByIdProductSet_In($productSetIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductSet
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductAbstractSetQuery
     */
    public function queryProductAbstractSetsById($idProductSet)
    {
        return $this->queryProductAbstractSet()
            ->filterByFkProductSet($idProductSet)
            ->orderByPosition(Criteria::ASC);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param int|null $excludedIdProductSet
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductAbstractSetQuery
     */
    public function queryProductAbstractSetsByIdProductAbstract($idProductAbstract, $excludedIdProductSet = null)
    {
        $query = $this->queryProductAbstractSet()
            ->filterByFkProductAbstract($idProductAbstract)
            ->orderByFkProductSet();

        if ($excludedIdProductSet) {
            $query->filterByFkProductSet($excludedIdProductSet, Criteria::NOT_EQUAL);
        }

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductSet
     * @param int|null $idLocale
     *
     * @return \Orm\Zed\Url\Persistence\SpyUrlQuery
     */
    public function queryUrlByIdProductSet($idProductSet, $idLocale = null)
    {
        $query = $this->getFactory()
            ->getUrlQueryContainer()
            ->queryUrls()
            ->filterByFkResourceProductSet($idProductSet);

        if ($idLocale) {
            $query->filterByFkLocale($idLocale);
        }

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductSet
     * @param int|null $idLocale
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImageSetQuery
     */
    public function queryProductImageSet($idProductSet, $idLocale = null)
    {
        $query = $this->getFactory()
            ->getProductImageQueryContainer()
            ->queryProductImageSet()
            ->filterByFkResourceProductSet($idProductSet)
            ->orderByIdProductImageSet(Criteria::ASC);

        if ($idLocale) {
            $query->filterByFkLocale($idLocale);
        }

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductSet
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImageSetQuery
     */
    public function queryDefaultProductImageSet($idProductSet)
    {
        $query = $this->getFactory()
            ->getProductImageQueryContainer()
            ->queryProductImageSet()
            ->filterByFkResourceProductSet($idProductSet)
            ->filterByFkLocale(null, Criteria::ISNULL)
            ->orderByIdProductImageSet(Criteria::ASC);

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductSet
     * @param array $excludedIdProductImageSets
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImageSetQuery
     */
    public function queryExcludedProductImageSet($idProductSet, array $excludedIdProductImageSets)
    {
        return $this->getFactory()
            ->getProductImageQueryContainer()
            ->queryProductImageSet()
            ->filterByFkResourceProductSet($idProductSet)
            ->filterByIdProductImageSet($excludedIdProductImageSets, Criteria::NOT_IN);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductSet
     * @param int|null $idLocale
     *
     * @return \Orm\Zed\ProductSet\Persistence\SpyProductSetDataQuery
     */
    public function queryProductSetDataByProductSetId($idProductSet, $idLocale = null)
    {
        $query = $this->getFactory()
            ->createProductSetDataQuery()
            ->filterByFkProductSet($idProductSet);

        if ($idLocale) {
            $query->filterByFkLocale($idLocale);
        }

        return $query;
    }
}
