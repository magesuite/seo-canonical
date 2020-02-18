<?php

namespace MageSuite\SeoCanonical\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const SEO_PREV_NEXT_LINK_PATH = 'seo/configuration/prev_next_link_enabled';

    const SEO_CANONICAL_FOR_PAGINATED_PAGES_DISABLED = 'seo/configuration/canonical_pagination_disabled';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfigInterface;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    ) {
        parent::__construct($context);
        $this->scopeConfigInterface = $scopeConfigInterface;
    }

    public function isPrevAndNextLinkEnabled()
    {
        $prevNextLinkEnabled = $this->scopeConfig->getValue(self::SEO_PREV_NEXT_LINK_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $prevNextLinkEnabled;
    }

    public function isCanonicalForPaginatedPagesDisabled(){
        return $this->scopeConfig->getValue(self::SEO_CANONICAL_FOR_PAGINATED_PAGES_DISABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
