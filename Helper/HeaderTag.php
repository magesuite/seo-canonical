<?php

namespace MageSuite\SeoCanonical\Helper;

class HeaderTag extends \Magento\Framework\App\Helper\AbstractHelper
{
    const HEAD_CLOSING_TAG = '</head>';
    const PREV_TAG_REGISTRY_KEY = 'prev_tag';
    const NEXT_TAG_REGISTRY_KEY = 'next_tag';

    public function insert($url, $body, $type)
    {
        $tag = $this->prepareTag($url, $type);

        return str_replace(self::HEAD_CLOSING_TAG, $tag . self::HEAD_CLOSING_TAG, $body);
    }

    protected function prepareTag($url, $type)
    {
        return sprintf('<link rel="%s" href="%s">', $type, $url);
    }
}