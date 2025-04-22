<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Plugin\Framework\View\Page\Config;

class OverrideCategoryCanonicalUrl
{
    public const PAGINATION_PARAM = 'p';

    public function __construct(
        protected \Magento\Framework\App\Request\Http $request,
        protected \Magento\Framework\Registry $registry,
        protected \MageSuite\SeoCanonical\Helper\Configuration $configuration
    ) {
    }

    public function beforeAddRemotePageAsset(\Magento\Framework\View\Page\Config $subject, $url, $contentType, array $properties = [], $name = null): array
    {
        if ($contentType != 'canonical') {
            return [$url, $contentType, $properties, $name];
        }

        $fullActionName = $this->request->getFullActionName();

        if ($fullActionName != 'catalog_category_view' || !$this->configuration->isCanonicalPageParamEnabled()) {
            return [$url, $contentType, $properties, $name];
        }

        $pageParam = $this->getPageParam();

        if (is_numeric($pageParam) && (int)$pageParam > 1) {
            $url .= sprintf('?%s=%s', self::PAGINATION_PARAM, $pageParam);
        }

        return [$url, $contentType, $properties, $name];
    }

    protected function getPageParam(): ?string
    {
        $params = $this->request->getParams();

        return $params[self::PAGINATION_PARAM] ?? null;
    }
}
