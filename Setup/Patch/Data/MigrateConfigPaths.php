<?php

declare(strict_types=1);

namespace MageSuite\SeoCanonical\Setup\Patch\Data;

class MigrateConfigPaths implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    protected const PATH_MAP = [
        'seo/configuration/canonical_tag_enabled'       => 'seo/canonical/canonical_tag_enabled',
        'seo/configuration/canonical_pagination_enabled' => 'seo/canonical/canonical_pagination_enabled',
        'seo/configuration/prev_next_link_enabled'       => 'seo/category/prev_next_link_enabled',
    ];

    public function __construct(
        protected \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    ) {
    }

    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $table = $this->moduleDataSetup->getTable('core_config_data');

        foreach (self::PATH_MAP as $oldPath => $newPath) {
            $connection->update(
                $table,
                ['path' => $newPath],
                ['path = ?' => $oldPath]
            );
        }

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
