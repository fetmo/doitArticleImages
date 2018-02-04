<?php

namespace doitArticleImages\Services\Decoration;


use doitArticleImages\Services\Filter\ImageFilter;
use Shopware\Bundle\StoreFrontBundle\Gateway\ProductMediaGatewayInterface;

class DecoratedProductMediaGateway implements ProductMediaGatewayInterface
{

    use ImageHandlingTrait;

    /**
     * @var ProductMediaGatewayInterface
     */
    private $coreService;

    /**
     * @var ImageFilter
     */
    private $imageFilter;

    /**
     * DecoratedProductMediaGateway constructor.
     * @param ProductMediaGatewayInterface $coreService
     * @param $imageFilter
     */
    public function __construct(ProductMediaGatewayInterface $coreService, $imageFilter)
    {
        $this->coreService = $coreService;
        $this->imageFilter = $imageFilter;
    }

}