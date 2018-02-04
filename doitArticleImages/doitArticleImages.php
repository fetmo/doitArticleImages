<?php

namespace doitArticleImages;

use Shopware\Components\Plugin;
use Shopware\Models\Shop\Shop;

class doitArticleImages extends Plugin
{

    public function install(Plugin\Context\InstallContext $context)
    {
        parent::install($context);

        $this->addAttribute();
    }

    private function addAttribute()
    {
        $crudService = $this->container->get('shopware_attribute.crud_service');

        $crudService->update('s_articles_img_attributes', 'doit_subshops', 'multi_selection', [
            'entity' => Shop::class,
            'displayInBackend' => true,
            'label' => 'Sub-Shop',
            'custom' => true,
            'supportText' => 'Das Bild wird in den ausgewählten Sub-Shops angezeigt.'
        ]);
    }

}

