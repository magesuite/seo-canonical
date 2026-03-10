<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Block;

class Canonical extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'MageSuite_SeoCanonical::canonical.phtml';

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        protected \MageSuite\SeoCanonical\Service\CanonicalUrl $canonicalUrl,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getCanonicalUrlForOtherPages(): ?string
    {
        return $this->canonicalUrl->getCanonicalUrlForOtherPages();
    }
}
