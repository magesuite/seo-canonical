<?php

namespace MageSuite\SeoCanonical\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const SEO_PREV_NEXT_LINK_PATH = 'seo/configuration/prev_next_link_enabled';
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
}
