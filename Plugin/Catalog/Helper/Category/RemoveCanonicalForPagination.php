<?php

namespace MageSuite\SeoCanonical\Plugin\Catalog\Helper\Category;

class RemoveCanonicalForPagination
{
    const PAGINATION_PARAM = 'p';
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    public function __construct(\Magento\Framework\App\Request\Http $request)
    {
        $this->request = $request;
    }

    public function aroundCanUseCanonicalTag(\Magento\Catalog\Helper\Category $subject, callable $proceed, $store = null)
    {
        $params = $this->request->getParams();

        if(isset($params[self::PAGINATION_PARAM]) && $params[self::PAGINATION_PARAM] != 1){
            return false;
        }

        return $proceed($store);
    }
}