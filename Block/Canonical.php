<?php

namespace MageSuite\SeoCanonical\Block;

class Canonical extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'MageSuite_SeoCanonical::canonical.phtml';

    /**
     * @var \MageSuite\SeoCanonical\Service\CanonicalUrl
     */
    protected $canonicalUrl;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MageSuite\SeoCanonical\Service\CanonicalUrl $canonicalUrl,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->canonicalUrl = $canonicalUrl;
    }

    public function getCanonicalUrl()
    {
        return $this->canonicalUrl->getCanonicalUrl();
    }
}
