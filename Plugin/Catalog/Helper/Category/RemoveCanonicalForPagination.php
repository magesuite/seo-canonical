<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Plugin\Catalog\Helper\Category;

class RemoveCanonicalForPagination
{
    public const PAGINATION_PARAM = 'p';

    public function __construct(
        protected \Magento\Framework\App\Request\Http $request,
        protected \MageSuite\SeoCanonical\Helper\Configuration $configuration
    ) {
    }

    public function aroundCanUseCanonicalTag(
        \Magento\Catalog\Helper\Category $subject,
        callable $proceed,
        $store = null
    ) {
        if ($this->configuration->isCanonicalForPaginatedPagesEnabled()) {
            return $proceed($store);
        }

        $params = $this->request->getParams();

        if (isset($params[self::PAGINATION_PARAM]) && $params[self::PAGINATION_PARAM] != 1){
            return false;
        }

        return $proceed($store);
    }
}
