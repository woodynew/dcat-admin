<?php

namespace Tests\Feature;

use Dcat\Admin\Support\Zip;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;
use ZipArchive;

class ZipSecurityTest extends TestCase
{
    public function testExtractsSafeArchive()
    {
        $files = new Filesystem();
        $root = sys_get_temp_dir().'/dcat-zip-safe-'.uniqid('', true);
        $archive = $root.'.zip';
        $zip = new ZipArchive();
        $zip->open($archive, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('plugin/file.txt', 'safe');
        $zip->close();

        try {
            $this->assertTrue(Zip::extract($archive, $root));
            $this->assertSame('safe', $files->get($root.'/plugin/file.txt'));
        } finally {
            @unlink($archive);
            $files->deleteDirectory($root);
        }
    }

    public function testRejectsPathTraversalArchive()
    {
        $files = new Filesystem();
        $root = sys_get_temp_dir().'/dcat-zip-unsafe-'.uniqid('', true);
        $archive = $root.'.zip';
        $outside = dirname($root).'/outside.txt';
        $zip = new ZipArchive();
        $zip->open($archive, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('../outside.txt', 'unsafe');
        $zip->close();

        try {
            $this->assertFalse(Zip::extract($archive, $root));
            $this->assertFileDoesNotExist($outside);
        } finally {
            @unlink($archive);
            @unlink($outside);
            $files->deleteDirectory($root);
        }
    }
}
