<?php

namespace MageSuite\SeoCanonical\Service;

class CanonicalUrl
{
    const SEO_CANONICAL_TAG_PATH = 'seo/configuration/canonical_tag_enabled';

    protected \Magento\Framework\App\Request\Http $request;
    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;
    protected \Magento\Framework\UrlInterface $urlBuilder;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->request = $request;
        $this->scopeConfig = $scopeConfig;
        $this->urlBuilder = $urlBuilder;
    }

    public function isEnabled()
    {
        $canonicalTagEnabled = $this->scopeConfig->getValue(
            self::SEO_CANONICAL_TAG_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return $canonicalTagEnabled && !$this->isCategoryOrProductPage();
    }

    public function getCanonicalUrl()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        $canonicalUrl = $this->urlBuilder->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        return $this->formatCanonicalUrl($canonicalUrl);
    }

    private function formatCanonicalUrl($canonicalUrl)
    {
        $urlWithoutParams = $this->stripGetParams($canonicalUrl);
        if ($this->isHomepageWithStoreCodeInPath($urlWithoutParams)) {
            return $urlWithoutParams;
        }
        return rtrim($urlWithoutParams, '/');
    }

    private function stripGetParams($canonicalUrl)
    {
        return strtok($canonicalUrl, '?');
    }

    private function isCategoryOrProductPage()
    {
        $fullActionName = $this->request->getFullActionName();
        return in_array($fullActionName, ['catalog_category_view', 'catalog_product_view']);
    }

    protected function isHomepageWithStoreCodeInPath($urlWithoutParams)
    {
        if ($this->urlBuilder->getUrl('', ['_current' => true]) === $urlWithoutParams) {
            return !empty(parse_url($urlWithoutParams, PHP_URL_PATH));
        }
        return false;
    }
}
