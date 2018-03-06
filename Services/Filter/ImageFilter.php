<?php

namespace doitArticleImages\Services\Filter;


use Shopware\Bundle\StoreFrontBundle\Struct\Media;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class ImageFilter
{

    /**
     * @param array $images
     * @param ShopContextInterface $context
     * @return mixed
     */
    public function filterImagesForContext(array $images, ShopContextInterface $context)
    {
        if(($shop = $context->getShop()) !== null){
            $shopID = $shop->getId();

            foreach ($images as $key1 => $image) {
                $remove = false;

                if ($image instanceof Media) {
                    $remove = $this->hideImageForProduct($image, $shopID);
                }

                if ($remove) {
                    unset($images[$key1]);
                }
            }
        }

        return \reset($images);
    }

    /**
     * @param Media $media
     * @param $shopid
     * @return bool
     */
    private function hideImageForProduct(Media $media, $shopid)
    {
        $shops = $media->getAttribute('core')->get('doit_subshops');
        $hide = true;

        if($shops !== null){
            $shops = array_filter(explode('|', $shops));
            $hide = !in_array($shopid, $shops, false);
        }

        return $hide;
    }

}