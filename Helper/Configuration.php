<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Helper;

class Configuration
{
    protected const SEO_PREV_NEXT_LINK_PATH = 'seo/category/prev_next_link_enabled';
    protected const SEO_CANONICAL_FOR_PAGINATED_PAGES_ENABLED = 'seo/canonical/canonical_pagination_enabled';
    protected const SEO_CANONICAL_TAG_PATH = 'seo/canonical/canonical_tag_enabled';
    protected const SEO_CANONICAL_REMOVE_STORE_CODE_FROM_HOMEPAGE = 'seo/canonical/remove_store_code_from_homepage';
    protected const SEO_OG_URL_MATCH_CANONICAL = 'seo/canonical/og_url_match_canonical_enabled';
    protected const SEO_CANONICAL_REMOVE_TRAILING_SLASH = 'seo/canonical/remove_trailing_slash';

    public function __construct(
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {}

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

    public function isRemoveStoreCodeFromHomepageEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::SEO_CANONICAL_REMOVE_STORE_CODE_FROM_HOMEPAGE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isRemovingTrailingSlashEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::SEO_CANONICAL_REMOVE_TRAILING_SLASH);
    }
}
