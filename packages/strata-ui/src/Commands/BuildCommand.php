<?php

namespace Stratos\StrataUI\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class BuildCommand extends Command
{
    protected $signature = 'strata:build {--watch : Run Vite in watch mode}';

    protected $description = 'Build Strata UI assets using Vite';

    public function handle(): int
    {
        $packagePath = $this->getPackagePath();

        if (! file_exists($packagePath.'/package.json')) {
            $this->error('Package directory not found or package.json missing.');
            $this->info('Expected path: '.$packagePath);

            return self::FAILURE;
        }

        $this->info('Building Strata UI assets...');

        $command = $this->option('watch')
            ? ['npm', 'run', 'watch']
            : ['npm', 'run', 'build'];

        $process = new Process(
            $command,
            $packagePath,
            null,
            null,
            null
        );

        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (! $process->isSuccessful()) {
            $this->error('Failed to build Strata UI assets.');

            return self::FAILURE;
        }

        $this->info('✓ Strata UI assets built successfully!');

        if (! $this->option('watch')) {
            $this->comment('Assets are available at: packages/strata-ui/public/build/');
        }

        return self::SUCCESS;
    }

    protected function getPackagePath(): string
    {
        return base_path('packages/strata-ui');
    }
}
