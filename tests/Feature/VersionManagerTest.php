<?php

namespace Tests\Feature;

use Dcat\Admin\Extend\Manager;
use Dcat\Admin\Extend\VersionManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class VersionManagerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testNewVersionsDoNotIncludeCurrentVersion()
    {
        $versionFile = tempnam(sys_get_temp_dir(), 'dcat-version-');
        file_put_contents($versionFile, <<<'PHP'
<?php

return [
    '1.0.0' => ['Initial version.'],
    '1.1.0' => ['Second version.'],
    '2.0.0' => ['Latest version.'],
];
PHP
        );

        try {
            $manager = Mockery::mock(Manager::class);
            $manager->shouldReceive('getName')->andReturn('vendor.extension');
            $manager->shouldReceive('path')
                ->with('vendor.extension', 'version.php')
                ->andReturn($versionFile);

            $versions = (new VersionManager($manager))->getNewFileVersions('vendor/extension', '1.0.0');

            $this->assertSame(['1.1.0', '2.0.0'], array_keys($versions));
        } finally {
            @unlink($versionFile);
        }
    }
}
