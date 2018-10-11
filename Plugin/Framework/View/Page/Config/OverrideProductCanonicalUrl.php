<?php

namespace MageSuite\SeoCanonical\Plugin\Framework\View\Page\Config;

class OverrideProductCanonicalUrl
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry
    )
    {
        $this->request = $request;
        $this->registry = $registry;
    }

    public function beforeAddRemotePageAsset(\Magento\Framework\View\Page\Config $subject, $url, $contentType, array $properties = [], $name = null)
    {
        if($contentType != 'canonical') {
            return [$url, $contentType, $properties, $name];
        }

        $fullActionName = $this->request->getFullActionName();

        if($fullActionName != 'catalog_product_view') {
            return [$url, $contentType, $properties, $name];
        }

        $currentProduct = $this->registry->registry('current_product');
        $canonicalUrl = $currentProduct->getSeoCanonicalUrl();

        if(!empty($canonicalUrl)) {
            $url = $canonicalUrl;
        }

        return [$url, $contentType, $properties, $name];
    }
}
