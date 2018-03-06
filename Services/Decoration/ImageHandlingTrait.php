<?php

namespace doitArticleImages\Services\Decoration;

use doitArticleImages\Services\Filter\ImageFilter;
use Shopware\Bundle\StoreFrontBundle\Gateway\ProductMediaGatewayInterface;
use Shopware\Bundle\StoreFrontBundle\Gateway\VariantMediaGatewayInterface;
use Shopware\Bundle\StoreFrontBundle\Struct;

trait ImageHandlingTrait
{
    /**
     * @var VariantMediaGatewayInterface|ProductMediaGatewayInterface
     */
    private $coreService;

    /**
     * @var ImageFilter
     */
    private $imageFilter;

    /**
     * {@inheritdoc}
     */
    public function getList($products, Struct\ShopContextInterface $context)
    {
        $coreReturn = $this->coreService->getList($products, $context);

        foreach ($coreReturn as $ordernumber => $mediaArray) {
            $coreReturn[$ordernumber] = $this->imageFilter->filterImagesForContext($mediaArray, $context);
        }

        return $coreReturn;
    }

    /**
     * {@inheritdoc}
     */
    public function getCover(Struct\BaseProduct $product, Struct\ShopContextInterface $context)
    {
        $coreReturn = $this->coreService->getCover($product, $context);

        return $this->imageFilter->filterImagesForContext([$coreReturn], $context);
    }

    /**
     * {@inheritdoc}
     */
    public function get(Struct\BaseProduct $product, Struct\ShopContextInterface $context)
    {
        $coreReturn = $this->coreService->get($product, $context);

        return $this->imageFilter->filterImagesForContext($coreReturn, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function getCovers($products, Struct\ShopContextInterface $context)
    {
        $coreReturn = $this->coreService->getCovers($products, $context);

        /**
         * @var string $ordernumber
         * @var Struct\Media $mediaArray
         */
        foreach ($coreReturn as $ordernumber => $cover) {
            $coreReturn[$ordernumber] = $this->imageFilter->filterImagesForContext([$cover], $context);
        }

        return $coreReturn;
    }

}