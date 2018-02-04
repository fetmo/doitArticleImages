<?php

namespace doitArticleImages\Services\Decoration;

use doitArticleImages\Services\Filter\ImageFilter;
use Shopware\Bundle\StoreFrontBundle\Gateway\VariantMediaGatewayInterface;

class DecoratedVariantMediaGateway implements VariantMediaGatewayInterface
{

    use ImageHandlingTrait;

    /**
     * @var VariantMediaGatewayInterface
     */
    private $coreService;

    /**
     * @var ImageFilter
     */
    private $imageFilter;

    /**
     * DecoratedVariantMediaGateway constructor.
     * @param VariantMediaGatewayInterface $variantMediaGateway
     * @param $imageFilter
     */
    public function __construct(VariantMediaGatewayInterface $variantMediaGateway, $imageFilter)
    {
        $this->coreService = $variantMediaGateway;
        $this->imageFilter = $imageFilter;
    }

}