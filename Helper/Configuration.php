<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected const SEO_PREV_NEXT_LINK_PATH = 'seo/configuration/prev_next_link_enabled';

    protected const SEO_CANONICAL_FOR_PAGINATED_PAGES_ENABLED = 'seo/configuration/canonical_pagination_enabled';

    protected const SEO_CANONICAL_PAGE_PARAM_ENABLED = 'seo/configuration/canonical_pagination_param_enabled';

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

    public function isCanonicalPageParamEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::SEO_CANONICAL_PAGE_PARAM_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
