<?php

namespace MageSuite\SeoCanonical\Plugin\Theme\Block\Html\Pager;

class AddToPrevAndNextUrlToRegistry
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(\Magento\Framework\Registry $registry)
    {
        $this->registry = $registry;
    }

    public function afterGetNextPageUrl(\Magento\Theme\Block\Html\Pager $subject, $result)
    {
        if (!$subject->isLastPage()) {
            $this->registry->register(\MageSuite\SeoCanonical\Helper\HeaderTag::NEXT_TAG_REGISTRY_KEY, $result);
        }

        return $result;
    }

    public function afterGetPreviousPageUrl(\Magento\Theme\Block\Html\Pager $subject, $result)
    {
        $currentPage = $subject->getCurrentPage();

        if ($currentPage > 1) {
            $this->registry->register(\MageSuite\SeoCanonical\Helper\HeaderTag::PREV_TAG_REGISTRY_KEY, $result);
        }

        return $result;
    }
}