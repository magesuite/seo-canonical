<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\DataProviders;

class CategoryCanonicalUrl extends \MageSuite\Opengraph\DataProviders\TagProvider implements \MageSuite\Opengraph\DataProviders\TagProviderInterface
{
    public function __construct(
        protected \MageSuite\SeoCanonical\Service\CanonicalUrl $canonicalUrl,
        protected \MageSuite\SeoCanonical\Helper\Configuration $configuration,
        protected \Magento\Framework\App\RequestInterface $request,
        protected \MageSuite\Opengraph\Factory\TagFactoryInterface $tagFactory
    ) {
    }

    public function getTags(): array
    {
        if (!$this->configuration->isOgUrlMatchCanonicalEnabled()) {
            return [];
        }

        $page = $this->request->getParam('p');

        if (is_array($page) || !(int)$page) {
            return [];
        }

        $page = (int)$page;

        $canonicalUrl = $this->canonicalUrl->getCanonicalUrl();
        $isCanonicalForPaginatedPagesEnabled = $this->configuration->isCanonicalForPaginatedPagesEnabled();

        if (!$isCanonicalForPaginatedPagesEnabled && $page !== 1) {
            $canonicalUrl = strtok($canonicalUrl, '?');
        }

        $tag = $this->tagFactory->getTag('url', $canonicalUrl);

        return [$tag->getOpengraphName() => $tag->getValue()];
    }
}