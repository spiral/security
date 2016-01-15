<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
namespace Spiral;

use Spiral\Core\DirectoriesInterface;
use Spiral\Modules\ModuleInterface;
use Spiral\Modules\PublisherInterface;
use Spiral\Modules\RegistratorInterface;

class SecurityModule implements ModuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(RegistratorInterface $registrator)
    {
        /**
         * Let's register new view namespace 'profiler'.
         */
        $registrator->configure('views', 'namespaces', 'spiral/security', [
            "'security' => [",
            "   directory('libraries') . 'spiral/security/source/views/',",
            "]"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function publish(PublisherInterface $publisher, DirectoriesInterface $directories)
    {
        $publisher->publish(
            __DIR__ . '/config/security.php',
            $directories->directory('config') . 'modules/security.php',
            PublisherInterface::FOLLOW
        );
    }
}