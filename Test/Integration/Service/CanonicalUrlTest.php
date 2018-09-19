<?php

namespace MageSuite\SeoCanonical\Test\Block;

class CanonicalUrlTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \MageSuite\SeoCanonical\Service\CanonicalUrl
     */
    protected $canonicalUrl;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlBuilderStub;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->coreRegistry = $this->objectManager->get(\Magento\Framework\Registry::class);

        $this->urlBuilderStub = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)->getMock();

        $this->canonicalUrl = new \MageSuite\SeoCanonical\Service\CanonicalUrl(
            $this->coreRegistry,
            $this->objectManager->get(\Magento\Framework\App\Config\ScopeConfigInterface::class),
            $this->urlBuilderStub
        );
    }
    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoConfigFixture current_store seo/configuration/canonical_tag_enabled 1
     */
    public function testItReturnsCanonicalUrl()
    {
        $this->itReturnsCanonicalUrl();
        $this->itStripGetParamsFromCanonical();
        $this->itRemovesSlashFromCanonicalUrl();
        $this->itDoesntReturnCanonicalUrlOnCategory();
    }

    private function itReturnsCanonicalUrl()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home');

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrl());
    }

    private function itStripGetParamsFromCanonical()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home?a=b&test=true');

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrl());
    }

    private function itRemovesSlashFromCanonicalUrl()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home/');

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrl());

        $this->urlBuilderStub->method('getUrl')->willReturn('home/?a=b&test=true');

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrl());
    }

    private function itDoesntReturnCanonicalUrlOnCategory()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home');
        $this->coreRegistry->register('current_category', 'dummy');

        $this->assertEquals(null, $this->canonicalUrl->getCanonicalUrl());
    }

    /**
     * @magentoAppArea frontend
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoConfigFixture current_store seo/configuration/canonical_tag_enabled 0
     */
    public function testItDontReturnsCanonicalUrl()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home');
        $this->assertEquals(null, $this->canonicalUrl->getCanonicalUrl());
    }

}