<?php

namespace MageSuite\SeoCanonical\Test\Service;

class CanonicalUrlTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager = null;
    protected ?\MageSuite\SeoCanonical\Service\CanonicalUrl $canonicalUrl = null;
    protected ?\PHPUnit\Framework\MockObject\MockObject $urlBuilderStub = null;
    protected ?\PHPUnit\Framework\MockObject\MockObject $requestStub = null;
    protected ?\PHPUnit\Framework\MockObject\MockObject $categoryHelperStub = null;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->requestStub = $this
            ->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->urlBuilderStub = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)->getMock();
        $this->categoryHelperStub = $this
            ->getMockBuilder(\Magento\Catalog\Helper\Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->canonicalUrl = new \MageSuite\SeoCanonical\Service\CanonicalUrl(
            $this->requestStub,
            $this->objectManager->get(\MageSuite\SeoCanonical\Helper\Configuration::class),
            $this->urlBuilderStub,
            $this->categoryHelperStub
        );
    }
    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoConfigFixture default/seo/configuration/canonical_tag_enabled 1
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

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrlForOtherPages());
    }

    private function itStripGetParamsFromCanonical()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home?a=b&test=true');

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrlForOtherPages());
    }

    private function itRemovesSlashFromCanonicalUrl()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home/');

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrlForOtherPages());

        $this->urlBuilderStub->method('getUrl')->willReturn('home/?a=b&test=true');

        $this->assertEquals('home', $this->canonicalUrl->getCanonicalUrlForOtherPages());
    }

    private function itDoesntReturnCanonicalUrlOnCategory()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home');
        $this->requestStub->method('getFullActionName')->willReturn('catalog_category_view');

        $this->assertEquals(null, $this->canonicalUrl->getCanonicalUrlForOtherPages());
    }

    /**
     * @magentoAppArea frontend
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoConfigFixture default/seo/configuration/canonical_tag_enabled 0
     */
    public function testItDontReturnsCanonicalUrl()
    {
        $this->urlBuilderStub->method('getUrl')->willReturn('home');
        $this->assertEquals(null, $this->canonicalUrl->getCanonicalUrlForOtherPages());
    }

}
