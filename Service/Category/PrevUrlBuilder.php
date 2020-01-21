<?php

namespace MageSuite\SeoCanonical\Service\Category;

class PrevUrlBuilder
{
    const PAGINATION_PARAM = 'p';

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
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    /**
     * @var \MageSuite\SeoCanonical\Helper\Configuration
     */
    protected $configuration;


    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\App\Request\Http $request,
        \MageSuite\SeoCanonical\Helper\Configuration $configuration
    )
    {
        $this->registry = $registry;
        $this->scopeConfig = $scopeConfig;
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->configuration = $configuration;
    }

    public function getPrevUrl()
    {
        if (!$this->configuration->isPrevAndNextLinkEnabled()) {
            return null;
        }

        $nextUrl = $this->urlBuilder->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);

        return $this->decrementPageParameter($nextUrl);
    }

    public function decrementPageParameter($nextUrl)
    {
        $params = $this->request->getParams();
        unset($params['id']);

        if(empty($params) || !isset($params[self::PAGINATION_PARAM]) || $params[self::PAGINATION_PARAM] == 2){
            return null;
        }

        $nextUrl = strtok($nextUrl, '?');

        $params[self::PAGINATION_PARAM] = $params[self::PAGINATION_PARAM] - 1;

        $query = http_build_query($params);

        return $nextUrl . '?' . $query;
    }
}
