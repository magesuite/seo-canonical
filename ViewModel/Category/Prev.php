<?php

namespace MageSuite\SeoCanonical\ViewModel\Category;

class Prev implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \MageSuite\SeoCanonical\Service\Category\PrevUrlBuilder
     */
    protected $prevUrl;

    public function __construct(\MageSuite\SeoCanonical\Service\Category\PrevUrlBuilder $prevUrl)
    {
        $this->prevUrl = $prevUrl;
    }

    public function getPrevUrl()
    {
        return $this->prevUrl->getPrevUrl();
    }
}