<?php

namespace MageSuite\SeoCanonical\Service;

class CanonicalUrl
{
    const SEO_CANONICAL_TAG_PATH = 'seo/configuration/canonical_tag_enabled';

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;


    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->registry = $registry;
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
        return boolval($this->registry->registry('current_category'));
    }

    protected function isHomepageWithStoreCodeInPath($urlWithoutParams)
    {
        if ($this->urlBuilder->getUrl('', ['_current' => true]) === $urlWithoutParams) {
            return !empty(parse_url($urlWithoutParams, PHP_URL_PATH));
        }
        return false;
    }
}
