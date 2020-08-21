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

    public function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->_objectManager->create(\Magento\Catalog\Api\ProductRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoConfigFixture current_store catalog/seo/product_canonical_tag 1
     */
    public function testItReturnsDefaultCanonicalUrlWhenThereIsNoCustomOneDefined()
    {
        $product = $this->productRepository->get('simple');
        $this->dispatch('catalog/product/view/id/' . $product->getId());

        $body = $this->getResponse()->getBody();

        $this->assertContains('<link  rel="canonical" href="http://localhost/index.php/simple-product.html" />', $body);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoConfigFixture current_store catalog/seo/product_canonical_tag 1
     */
    public function testItReturnsOverridenCanonicalUrlWhenCustomOneIsDefined()
    {
        $product = $this->productRepository->get('simple');
        $product->setSeoCanonicalUrl('http://example.com/canonical');
        $product->save();

        $this->dispatch('catalog/product/view/id/' . $product->getId());

        $body = $this->getResponse()->getBody();

        $this->assertContains('<link  rel="canonical" href="http://example.com/canonical" />', $body);
    }
}
