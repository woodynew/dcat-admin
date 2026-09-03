<?php

namespace Tests\Feature;

use Dcat\Admin\Console\ExtensionInstallCommand;
use PHPUnit\Framework\TestCase;

class ExtensionCommandTest extends TestCase
{
    public function testRemoteInstallFailsWithActionableMessage()
    {
        $command = new class extends ExtensionInstallCommand {
            public $lastError;

            public function argument($key = null)
            {
                return $key === 'name' ? 'vendor/extension' : null;
            }

            public function option($key = null)
            {
                return null;
            }

            public function error($string, $verbosity = null)
            {
                $this->lastError = $string;
            }
        };
        $exitCode = $command->handle();

        $this->assertSame(1, $exitCode);
        $this->assertStringContainsString('Use --path with a trusted local ZIP package', $command->lastError);
    }
}
