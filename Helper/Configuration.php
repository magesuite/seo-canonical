<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected const SEO_PREV_NEXT_LINK_PATH = 'seo/category/prev_next_link_enabled';
    protected const SEO_CANONICAL_FOR_PAGINATED_PAGES_ENABLED = 'seo/canonical/canonical_pagination_enabled';
    protected const SEO_CANONICAL_TAG_PATH = 'seo/canonical/canonical_tag_enabled';
    protected const SEO_OG_URL_MATCH_CANONICAL = 'seo/canonical/og_url_match_canonical_enabled';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    ) {
        parent::__construct($context);
    }

    public function isPrevAndNextLinkEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::SEO_PREV_NEXT_LINK_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isCanonicalForPaginatedPagesEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::SEO_CANONICAL_FOR_PAGINATED_PAGES_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isEnabledForOtherPages(): bool
    {
        return $this->scopeConfig->isSetFlag(self::SEO_CANONICAL_TAG_PATH);
    }

    public function isOgUrlMatchCanonicalEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::SEO_OG_URL_MATCH_CANONICAL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}