<?php

namespace Tests\Feature;

use Dcat\Admin\Console\PublishCommand;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;

class PublishCommandTest extends TestCase
{
    public function testDirectoryPublishingSupportsInstalledFlysystemVersion()
    {
        $files = new Filesystem();
        $root = sys_get_temp_dir().'/dcat-publish-'.uniqid('', true);
        $source = $root.'/source';
        $target = $root.'/target';

        $files->makeDirectory($source.'/nested', 0755, true);
        $files->makeDirectory($target.'/nested', 0755, true);
        $files->put($source.'/nested/new.txt', 'new');
        $files->put($source.'/nested/existing.txt', 'source');
        $files->put($target.'/nested/existing.txt', 'target');

        try {
            $command = new class($files) extends PublishCommand {
                public function publishDirectoryForTest($from, $to)
                {
                    return $this->publishDirectory($from, $to);
                }

                public function option($key = null)
                {
                    return false;
                }

                protected function status($from, $to, $type)
                {
                }
            };

            $command->publishDirectoryForTest($source, $target);

            $this->assertSame('new', $files->get($target.'/nested/new.txt'));
            $this->assertSame('target', $files->get($target.'/nested/existing.txt'));
        } finally {
            $files->deleteDirectory($root);
        }
    }
}
