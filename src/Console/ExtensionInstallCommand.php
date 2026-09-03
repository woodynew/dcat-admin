<?php

namespace Dcat\Admin\Console;

use Dcat\Admin\Admin;
use Illuminate\Console\Command;

class ExtensionInstallCommand extends Command
{
    protected $signature = 'admin:ext-install 
    {name : The name of the extension. Eg: author-name/extension-name} 
    {--path= : The path of the extension.}';

    protected $description = 'Install an extension';

    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->option('path');

        if (! $path) {
            $this->error('Remote extension installation is unavailable. Use --path with a trusted local ZIP package.');

            return 1;
        }

        $manager = Admin::extension()->setOutput($this->output);

        if (! is_file($path)) {
            $path = rtrim($path, '/').sprintf('/%s.zip', str_replace('/', '.', $name));
        }

        if (! is_file($path)) {
            $this->error(sprintf('Extension package not found: %s', $path));

            return 1;
        }

        $this->output->writeln(sprintf('<info>Unpacking extension: %s</info>', $name));

        $manager->extract($path);

        $this->output->writeln('<info>Migrating extension...</info>');

        Admin::extension()->load();

        $manager
            ->updateManager()
            ->setOutPut($this->output)
            ->update($name);

        return 0;
    }
}
