<?php

namespace doitArticleImages\Services\Filter;


use Shopware\Bundle\StoreFrontBundle\Struct\Media;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

interface Filter
{

    /**
     * @param array $images
     * @param ShopContextInterface $context
     * @return mixed
     */
    public function filterImagesForContext(array $images, ShopContextInterface $context);
}