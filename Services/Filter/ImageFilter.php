<?php

namespace doitArticleImages\Services\Filter;


use Shopware\Bundle\StoreFrontBundle\Struct\Media;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class ImageFilter
{

    /**
     * @var \Enlight_Components_Db_Adapter_Pdo_Mysql
     */
    private $db;

    /**
     * ImageFilter constructor.
     * @param \Enlight_Components_Db_Adapter_Pdo_Mysql $db
     */
    public function __construct(\Enlight_Components_Db_Adapter_Pdo_Mysql $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $ordernumber
     * @param array $images
     * @param ShopContextInterface $context
     * @return mixed
     */
    public function filterImagesForContext(string $ordernumber, array $images, ShopContextInterface $context)
    {
        $shopID = $context->getShop()->getId();

        foreach ($images as $key1 => $image) {
            $remove = false;

            if ($image instanceof Media) {
                $remove = $this->hideImageForProduct($ordernumber, $image, $shopID);
            }

            if ($remove) {
                unset($images[$key1]);
            }
        }

        return \reset($images);
    }

    /**
     * @param $ordernumber
     * @param Media $media
     * @param $shopid
     * @return bool
     */
    private function hideImageForProduct($ordernumber, Media $media, $shopid)
    {
        $articleID = $this->db->fetchOne(
            'SELECT articleID FROM s_articles_details WHERE ordernumber = :ordernumber',
            ['ordernumber' => $ordernumber]
        );

        $articleImage = $this->db->fetchRow(
            'SELECT * FROM s_articles_img sai 
                  lEFT JOIN s_articles_img_attributes saia ON sai.id = saia.imageID 
                  WHERE sai.articleID = :articleid AND sai.media_id = :mediaid',
            ['articleid' => $articleID, 'mediaid' => $media->getId()]
        );

        $hide = false;
        if ($articleImage && isset($articleImage['doit_subshops']) && '' !== $articleImage['doit_subshops']) {
            $hide = !\in_array($shopid,
                \array_filter(explode('|', $articleImage['doit_subshops']))
            );
        }

        return $hide;
    }

}