<?php

namespace MageSuite\SeoCanonical\DataProviders;

class CanonicalUrl extends \MageSuite\Opengraph\DataProviders\TagProvider implements \MageSuite\Opengraph\DataProviders\TagProviderInterface
{
    /**
     * @var MageSuite\SeoCanonical\Service\CanonicalUrl
     */
    protected $canonicalUrl;

    /**
     * @var \MageSuite\Opengraph\Factory\TagFactoryInterface
     */
    protected $tagFactory;

    public function __construct(
        \MageSuite\SeoCanonical\Service\CanonicalUrl $canonicalUrl,
        \MageSuite\Opengraph\Factory\TagFactoryInterface $tagFactory
    )
    {
        $this->canonicalUrl = $canonicalUrl;
        $this->tagFactory = $tagFactory;
    }

    public function getTags()
    {
        $canonicalUrl = $this->canonicalUrl->getCanonicalUrl();

        if(!$canonicalUrl){
            return [];
        }

        $tag = $this->tagFactory->getTag('url', $canonicalUrl);
        return [$tag->getOpengraphName() => $tag->getValue()];
    }

}