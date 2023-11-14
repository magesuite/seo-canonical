<?php

namespace MageSuite\SeoCanonical\Plugin\Catalog\Helper\Category;

class RemoveCanonicalForPagination
{
    const PAGINATION_PARAM = 'p';
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \MageSuite\SeoCanonical\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \MageSuite\SeoCanonical\Helper\Configuration $configuration)
    {
        $this->request = $request;
        $this->configuration = $configuration;
    }

    public function aroundCanUseCanonicalTag(\Magento\Catalog\Helper\Category $subject, callable $proceed, $store = null)
    {
        if($this->configuration->isCanonicalForPaginatedPagesEnabled()) {
            return $proceed($store);
        }

        $params = $this->request->getParams();

        if(isset($params[self::PAGINATION_PARAM]) && $params[self::PAGINATION_PARAM] != 1){
            return false;
        }

        return $proceed($store);
    }
}
