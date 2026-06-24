<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\PostProcessor;

class CategoryOgUrlPagination implements \MageSuite\Opengraph\DataProviders\TagsPostProcessorInterface
{
    public function __construct(
        protected \MageSuite\SeoCanonical\Helper\Configuration $configuration,
        protected \Magento\Framework\App\RequestInterface $request
    ) {
    }

    public function process(array $tags, ?string $pageType): array
    {
        if ($pageType !== 'category') {
            return $tags;
        }

        if (!$this->configuration->isOgUrlMatchCanonicalEnabled()) {
            return $tags;
        }

        $ogUrlKey = \MageSuite\Opengraph\Model\Tag::OPENGRAPH_PREFIX . 'url';

        if (!isset($tags[$ogUrlKey])) {
            return $tags;
        }

        $pageParam = $this->request->getParam('p');

        if (is_array($pageParam) || !(int)$pageParam) {
            return $tags;
        }

        $page = (int)$pageParam;

        if ($page !== 1 && !$this->configuration->isCanonicalForPaginatedPagesEnabled()) {
            return $tags;
        }

        $currentOgUrl = $tags[$ogUrlKey];

        if (str_contains($currentOgUrl, 'p=')) {
            return $tags;
        }

        $separator = str_contains($currentOgUrl, '?') ? '&' : '?';
        $tags[$ogUrlKey] = sprintf('%s%sp=%d', $currentOgUrl, $separator, $page);

        return $tags;
    }
}