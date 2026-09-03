<?php

namespace Tests\Feature;

use Dcat\Admin\Extend\Manager;
use Dcat\Admin\Http\Repositories\Extension;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;

class ExtensionSecurityTest extends TestCase
{
    public function testExtensionHomepageOnlyAllowsHttpAndHttps()
    {
        $repository = new class extends Extension {
            public function sanitize($homepage)
            {
                return $this->sanitizeHomepage($homepage);
            }
        };

        $this->assertSame('https://example.com/plugin', $repository->sanitize('https://example.com/plugin'));
        $this->assertSame('http://example.com/plugin', $repository->sanitize('http://example.com/plugin'));
        $this->assertNull($repository->sanitize('javascript:alert(1)'));
        $this->assertNull($repository->sanitize('data:text/html,alert(1)'));
        $this->assertNull($repository->sanitize('//example.com/plugin'));
    }

    public function testExtensionPackageNameCannotEscapeExtensionDirectory()
    {
        $files = new Filesystem();
        $container = new Container();
        $previousContainer = Container::getInstance();
        $root = sys_get_temp_dir().'/dcat-extension-'.uniqid('', true);
        $validRoot = $root.'-valid';

        $container->instance('files', $files);
        Container::setInstance($container);
        $files->makeDirectory($root.'/src', 0755, true);
        $files->put($root.'/version.php', '<?php return [];');
        $files->makeDirectory($validRoot.'/src', 0755, true);
        $files->put($validRoot.'/version.php', '<?php return [];');

        try {
            $manager = new class($container) extends Manager {
                public function check($directory)
                {
                    return $this->checkFiles($directory);
                }
            };

            $files->put($root.'/composer.json', json_encode([
                'name' => '../../escape',
                'extra' => ['dcat-admin' => 'Example\\Provider'],
            ]));
            $this->assertFalse($manager->check($root));

            $files->put($validRoot.'/composer.json', json_encode([
                'name' => 'vendor/extension',
                'extra' => ['dcat-admin' => 'Example\\Provider'],
            ]));
            $this->assertTrue($manager->check($validRoot));
        } finally {
            $files->deleteDirectory($root);
            $files->deleteDirectory($validRoot);
            Container::setInstance($previousContainer);
        }
    }
}
