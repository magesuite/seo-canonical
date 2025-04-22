<?php

namespace MageSuite\SeoCanonical\Test\Integration\Controller;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class OverrideCanonicalUrlTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->_objectManager->create(\Magento\Catalog\Api\ProductRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoConfigFixture current_store catalog/seo/product_canonical_tag 1
     */
    public function testItReturnsDefaultCanonicalUrlWhenThereIsNoCustomOneDefined(): void
    {
        $product = $this->productRepository->get('simple');
        $this->dispatch('catalog/product/view/id/' . $product->getId());

        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString('<link rel="canonical" href="http://localhost/index.php/simple-product.html" />', $this->normalizeBody($body));
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoConfigFixture current_store catalog/seo/product_canonical_tag 1
     */
    public function testItReturnsOverriddenCanonicalUrlWhenCustomOneIsDefined(): void
    {
        $product = $this->productRepository->get('simple');
        $product->setSeoCanonicalUrl('http://example.com/canonical');
        $product->save();

        $this->dispatch('catalog/product/view/id/' . $product->getId());

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString('<link rel="canonical" href="http://example.com/canonical" />', $this->normalizeBody($body));
    }

    /**
     * Backwards compatibility with Magento <=2.4.7
     */
    protected function normalizeBody(string $body): string
    {
        return str_replace('<link  rel=', '<link rel=', $body);
    }
}
