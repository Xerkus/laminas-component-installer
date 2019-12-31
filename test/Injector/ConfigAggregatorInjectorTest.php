<?php

/**
 * @see       https://github.com/laminas/laminas-component-installer for the canonical source repository
 * @copyright https://github.com/laminas/laminas-component-installer/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-component-installer/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ComponentInstaller\Injector;

use Laminas\ComponentInstaller\Injector\ConfigAggregatorInjector;

class ConfigAggregatorInjectorTest extends AbstractInjectorTestCase
{
    protected $configFile = 'config/config.php';

    protected $injectorClass = ConfigAggregatorInjector::class;

    protected $injectorTypesAllowed = [
        ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER,
    ];

    public function convertToShortArraySyntax($contents)
    {
        return preg_replace('/array\(([^)]+)\)/s', '[$1]', $contents);
    }

    public function allowedTypes()
    {
        return [
            'config-provider' => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, true],
            'component'       => [ConfigAggregatorInjector::TYPE_COMPONENT, false],
            'module'          => [ConfigAggregatorInjector::TYPE_MODULE, false],
        ];
    }

    public function injectComponentProvider()
    {
        // @codingStandardsIgnoreStart
        $baseContentsFqcnLongArray              = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-fqcn.config.php');
        $baseContentsGloballyQualifiedLongArray = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-globally-qualified.config.php');
        $baseContentsImportLongArray            = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-import.config.php');
        $baseContentsImportLongArrayAltIndent   = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-import-alt-indent.config.php');

        $baseContentsFqcnShortArray              = $this->convertToShortArraySyntax($baseContentsFqcnLongArray);
        $baseContentsGloballyQualifiedShortArray = $this->convertToShortArraySyntax($baseContentsGloballyQualifiedLongArray);
        $baseContentsImportShortArray            = $this->convertToShortArraySyntax($baseContentsImportLongArray);
        $baseContentsImportShortArrayAltIndent   = $this->convertToShortArraySyntax($baseContentsImportLongArrayAltIndent);

        $expectedContentsFqcnLongArray              = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-fqcn.config.php');
        $expectedContentsGloballyQualifiedLongArray = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-globally-qualified.config.php');
        $expectedContentsImportLongArray            = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-import.config.php');
        $expectedContentsImportLongArrayAltIndent   = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-import-alt-indent.config.php');

        $expectedContentsFqcnShortArray              = $this->convertToShortArraySyntax($expectedContentsFqcnLongArray);
        $expectedContentsGloballyQualifiedShortArray = $this->convertToShortArraySyntax($expectedContentsGloballyQualifiedLongArray);
        $expectedContentsImportShortArray            = $this->convertToShortArraySyntax($expectedContentsImportLongArray);
        $expectedContentsImportShortArrayAltIndent   = $this->convertToShortArraySyntax($expectedContentsImportLongArrayAltIndent);

        return [
            'fqcn-long-array'               => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsFqcnLongArray,               $expectedContentsFqcnLongArray],
            'global-long-array'             => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsGloballyQualifiedLongArray,  $expectedContentsGloballyQualifiedLongArray],
            'import-long-array'             => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportLongArray,             $expectedContentsImportLongArray],
            'import-long-array-alt-indent'  => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportLongArrayAltIndent,    $expectedContentsImportLongArrayAltIndent],
            'fqcn-short-array'              => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsFqcnShortArray,              $expectedContentsFqcnShortArray],
            'global-short-array'            => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsGloballyQualifiedShortArray, $expectedContentsGloballyQualifiedShortArray],
            'import-short-array'            => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportShortArray,            $expectedContentsImportShortArray],
            'import-short-array-alt-indent' => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportShortArrayAltIndent,   $expectedContentsImportShortArrayAltIndent],
        ];
        // @codingStandardsIgnoreEnd
    }

    public function packageAlreadyRegisteredProvider()
    {
        // @codingStandardsIgnoreStart
        $fqcnLongArray              = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-fqcn.config.php');
        $globallyQualifiedLongArray = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-globally-qualified.config.php');
        $importLongArray            = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-import.config.php');

        $fqcnShortArray              = $this->convertToShortArraySyntax($fqcnLongArray);
        $globallyQualifiedShortArray = $this->convertToShortArraySyntax($globallyQualifiedLongArray);
        $importShortArray            = $this->convertToShortArraySyntax($importLongArray);

        return [
            'fqcn-long-array'           => [$fqcnLongArray,               ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER],
            'global-long-array'         => [$globallyQualifiedLongArray,  ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER],
            'import-long-array'         => [$importLongArray,             ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER],
            'fqcn-short-array'          => [$fqcnShortArray,              ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER],
            'global-short-array'        => [$globallyQualifiedShortArray, ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER],
            'import-short-array'        => [$importShortArray,            ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER],
        ];
        // @codingStandardsIgnoreEnd
    }

    public function emptyConfiguration()
    {
        // @codingStandardsIgnoreStart
        $fqcnLongArray              = file_get_contents(__DIR__ . '/TestAsset/mezzio-empty-fqcn.config.php');
        $globallyQualifiedLongArray = file_get_contents(__DIR__ . '/TestAsset/mezzio-empty-globally-qualified.config.php');
        $importLongArray            = file_get_contents(__DIR__ . '/TestAsset/mezzio-empty-import.config.php');

        $fqcnShortArray              = $this->convertToShortArraySyntax($fqcnLongArray);
        $globallyQualifiedShortArray = $this->convertToShortArraySyntax($globallyQualifiedLongArray);
        $importShortArray            = $this->convertToShortArraySyntax($importLongArray);

        return [
            'fqcn-long-array'           => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $fqcnLongArray],
            'global-long-array'         => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $globallyQualifiedLongArray],
            'import-long-array'         => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $importLongArray],
            'fqcn-short-array'          => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $fqcnShortArray],
            'global-short-array'        => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $globallyQualifiedShortArray],
            'import-short-array'        => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $importShortArray],
        ];
        // @codingStandardsIgnoreEnd
    }

    public function packagePopulatedInConfiguration()
    {
        // @codingStandardsIgnoreStart
        $baseContentsFqcnLongArray              = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-fqcn.config.php');
        $baseContentsGloballyQualifiedLongArray = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-globally-qualified.config.php');
        $baseContentsImportLongArray            = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-import.config.php');
        $baseContentsImportLongArrayAltIndent   = file_get_contents(__DIR__ . '/TestAsset/mezzio-populated-import-alt-indent.config.php');

        $baseContentsFqcnShortArray              = $this->convertToShortArraySyntax($baseContentsFqcnLongArray);
        $baseContentsGloballyQualifiedShortArray = $this->convertToShortArraySyntax($baseContentsGloballyQualifiedLongArray);
        $baseContentsImportShortArray            = $this->convertToShortArraySyntax($baseContentsImportLongArray);
        $baseContentsImportShortArrayAltIndent   = $this->convertToShortArraySyntax($baseContentsImportLongArrayAltIndent);

        $expectedContentsFqcnLongArray              = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-fqcn.config.php');
        $expectedContentsGloballyQualifiedLongArray = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-globally-qualified.config.php');
        $expectedContentsImportLongArray            = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-import.config.php');
        $expectedContentsImportLongArrayAltIndent   = file_get_contents(__DIR__ . '/TestAsset/mezzio-application-import-alt-indent.config.php');

        $expectedContentsFqcnShortArray              = $this->convertToShortArraySyntax($expectedContentsFqcnLongArray);
        $expectedContentsGloballyQualifiedShortArray = $this->convertToShortArraySyntax($expectedContentsGloballyQualifiedLongArray);
        $expectedContentsImportShortArray            = $this->convertToShortArraySyntax($expectedContentsImportLongArray);
        $expectedContentsImportShortArrayAltIndent   = $this->convertToShortArraySyntax($expectedContentsImportLongArrayAltIndent);

        return [
            'fqcn-long-array'               => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsFqcnLongArray,               $expectedContentsFqcnLongArray],
            'global-long-array'             => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsGloballyQualifiedLongArray,  $expectedContentsGloballyQualifiedLongArray],
            'import-long-array'             => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportLongArray,             $expectedContentsImportLongArray],
            'import-long-array-alt-indent'  => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportLongArrayAltIndent,    $expectedContentsImportLongArrayAltIndent],
            'fqcn-short-array'              => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsFqcnShortArray,              $expectedContentsFqcnShortArray],
            'global-short-array'            => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsGloballyQualifiedShortArray, $expectedContentsGloballyQualifiedShortArray],
            'import-short-array'            => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportShortArray,            $expectedContentsImportShortArray],
            'import-short-array-alt-indent' => [ConfigAggregatorInjector::TYPE_CONFIG_PROVIDER, $baseContentsImportShortArrayAltIndent,   $expectedContentsImportShortArrayAltIndent],
        ];
        // @codingStandardsIgnoreEnd
    }
}
