<?php

/**
 * @see       https://github.com/laminas/laminas-component-installer for the canonical source repository
 * @copyright https://github.com/laminas/laminas-component-installer/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-component-installer/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ComponentInstaller;

class ConfigDiscovery
{
    /**
     * Map of known configuration files and their locators.
     *
     * @var string[]
     */
    private $discovery = [
        'config/application.config.php' => ConfigDiscovery\ApplicationConfig::class,
        'config/modules.config.php' => ConfigDiscovery\ModulesConfig::class,
        'config/development.config.php' => ConfigDiscovery\DevelopmentConfig::class,
        'config/config.php' => ConfigDiscovery\MezzioConfig::class,
    ];

    /**
     * Map of config files to injectors
     *
     * @var string[]
     */
    private $injectors = [
        'config/application.config.php' => Injector\ApplicationConfigInjector::class,
        'config/modules.config.php' => Injector\ModulesConfigInjector::class,
        'config/development.config.php' => Injector\DevelopmentConfigInjector::class,
        'config/config.php' => Injector\MezzioConfigInjector::class,
    ];

    /**
     * Return a list of available configuration options.
     *
     * @param array $availableTypes List of Injector\InjectorInterface::TYPE_*
     *     constants indicating valid package types that could be injected.
     * @param string $projectRoot Path to the project root; assumes PWD by
     *     default.
     * @return ConfigOption[]
     */
    public function getAvailableConfigOptions(array $availableTypes, $projectRoot = '')
    {
        $discovered = [
            new ConfigOption('Do not inject', new Injector\NoopInjector()),
        ];

        foreach ($this->discovery as $file => $discoveryClass) {
            $discovery = new $discoveryClass($projectRoot);
            if (! $discovery->locate()) {
                continue;
            }

            $injectorClass = $this->injectors[$file];
            $injector = new $injectorClass($projectRoot);

            if (! $this->injectorCanRegisterAvailableType($injector, $availableTypes)) {
                continue;
            }

            $discovered[] = new ConfigOption($file, $injector);
        }

        return (count($discovered) === 1)
            ? []
            : $discovered;
    }

    /**
     * Determine if the given injector can handle any of the types exposed by the package.
     *
     * @param Injector\InjectorInterface $injector
     * @param int[] $availableTypes
     * @return bool
     */
    private function injectorCanRegisterAvailableType(Injector\InjectorInterface $injector, array $availableTypes)
    {
        foreach ($availableTypes as $type) {
            if ($injector->registersType($type)) {
                return true;
            }
        }
        return false;
    }
}
