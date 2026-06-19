<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Service;

class CanonicalUrl
{
    public function __construct(
        protected \Magento\Framework\App\RequestInterface $request,
        protected \MageSuite\SeoCanonical\Helper\Configuration $configuration,
        protected \Magento\Framework\UrlInterface $urlBuilder,
        protected \Magento\Catalog\Helper\Category $categoryHelper
    ) {
    }

    public function getCanonicalUrl(): string
    {
        return $this->formatCanonicalUrl($this->getCurrentUrl(), $this->isCategoryPage());
    }

    public function getCanonicalUrlForOtherPages(): ?string
    {
        if (!$this->isEnabledForOtherPages()) {
            return null;
        }

        return $this->formatCanonicalUrl($this->getCurrentUrl());
    }

    protected function getCurrentUrl(): string
    {
        return $this->urlBuilder->getUrl('*/*/*', [
            '_current' => true,
            '_use_rewrite' => true
        ]);
    }

    public function isEnabledForOtherPages(): bool
    {
        return $this->configuration->isEnabledForOtherPages()
            && !$this->isCategoryOrSearchOrProductPage();
    }

    public function isCanonicalPage(): bool
    {
        if (!$this->areParamsForCanonicalPageValid()) {
            return false;
        }

        return $this->request->getUriString() === $this->getCanonicalUrl();
    }

    protected function formatCanonicalUrl(string $url, bool $isCategory = false): string
    {
        $url = $this->stripGetParams($url);

        if ($isCategory) {
            return $this->categoryHelper->getCanonicalUrl($url);
        }

        if ($this->isHomepageWithStoreCodeInPath($url)) {
            return $url;
        }

        return rtrim($url, '/');
    }

    protected function stripGetParams(string $url): string
    {
        return strtok($url, '?');
    }

    protected function isCategoryOrSearchOrProductPage(): bool
    {
        $action = $this->request->getFullActionName();

        return in_array($action, [
            'catalog_category_view',
            'catalogsearch_result_index',
            'catalog_product_view'
        ], true);
    }

    protected function isCategoryPage(): bool
    {
        return $this->request->getFullActionName() === 'catalog_category_view';
    }

    protected function isHomepageWithStoreCodeInPath(string $url): bool
    {
        if ($this->urlBuilder->getUrl('', ['_current' => true]) === $url) {
            return !empty(parse_url($url, PHP_URL_PATH));
        }

        return false;
    }

    protected function areParamsForCanonicalPageValid(): bool
    {
        $params = $this->request->getQuery()->toArray();
        $paginationEnabled = $this->configuration->isCanonicalForPaginatedPagesEnabled();

        if (!$paginationEnabled) {
            return empty($params);
        }

        if (!isset($params[\MageSuite\SeoCanonical\Plugin\Catalog\Helper\Category\RemoveCanonicalForPagination::PAGINATION_PARAM])) {
            return empty($params);
        }

        return count($params) === 1;
    }
}
