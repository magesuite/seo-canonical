<?php

namespace MageSuite\SeoCanonical\Observer\Category;

class AddPrevNextTags implements \Magento\Framework\Event\ObserverInterface
{
    const FULL_ACTION_NAME = 'catalog_category_view';

    /**
     * @var \MageSuite\SeoCanonical\Helper\HeaderTag
     */
    protected $headerTag;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;
    /**
     * @var \MageSuite\SeoCanonical\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \MageSuite\SeoCanonical\Helper\HeaderTag $headerTag,
        \Magento\Framework\Registry $registry,
        \MageSuite\SeoCanonical\Helper\Configuration $configuration
    ) {
        $this->headerTag = $headerTag;
        $this->registry = $registry;
        $this->configuration = $configuration;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $request = $observer->getEvent()->getData('request');

        $fullActionName = $request->getFullActionName();

        if ($fullActionName != self::FULL_ACTION_NAME) {
            return $this;
        }

        if (!$this->configuration->isPrevAndNextLinkEnabled()) {
            return $this;
        }

        $response = $observer->getEvent()->getData('response');

        if (!$response) {
            return $this;
        }

        $html = $response->getBody();

        if ($html == '') {
            return $this;
        }

        $nextUrl = $this->registry->registry(\MageSuite\SeoCanonical\Helper\HeaderTag::NEXT_TAG_REGISTRY_KEY);

        if (!empty($nextUrl)) {
            $html = $this->headerTag->insert($nextUrl, $html, 'next');

            $this->registry->unregister(\MageSuite\SeoCanonical\Helper\HeaderTag::NEXT_TAG_REGISTRY_KEY);
        }

        $prevUrl = $this->registry->registry(\MageSuite\SeoCanonical\Helper\HeaderTag::PREV_TAG_REGISTRY_KEY);

        if (!empty($prevUrl)) {
            $html = $this->headerTag->insert($prevUrl, $html, 'prev');

            $this->registry->unregister(\MageSuite\SeoCanonical\Helper\HeaderTag::PREV_TAG_REGISTRY_KEY);
        }

        $response->setBody($html);

        return $this;
    }
}
