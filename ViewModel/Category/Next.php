<?php

namespace MageSuite\SeoCanonical\ViewModel\Category;

class Next implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \MageSuite\SeoCanonical\Service\Category\NextUrlBuilder
     */
    protected $nextUrl;

    public function __construct(\MageSuite\SeoCanonical\Service\Category\NextUrlBuilder $nextUrl)
    {
        $this->nextUrl = $nextUrl;
    }

    public function getNextUrl()
    {
        return $this->nextUrl->getNextUrl();
    }
}