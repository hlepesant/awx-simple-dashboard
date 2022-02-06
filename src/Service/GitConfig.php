<?php

namespace App\Service;

# use Symfony\Component\HttpClient\HttpClient;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

use Symfony\Component\Finder\Finder;

Class GitConfig
{
    private $git_url;
    private $git_repo;
    private $srcPath;

    public function __construct(string $git_url, string $git_repo, string $rootPath)
    {
	      $this->git_url = $git_url;
	      $this->git_repo = $git_repo;
	      $this->srcPath = sprintf("%s/sources", $rootPath);
    }

    public function getRepo(): int
    {
        $pwd = sprintf('%s/%s', $this->srcPath, $this->git_repo);

        $filesystem = new Filesystem();

        if ( $filesystem->exists($pwd) ) {
          $process = new Process(['git', 'pull'], $pwd);
        } else {
          $process = new Process(['git', 'clone', $this->git_url, $pwd]);
        }

        $process->run();

        if (!$process->isSuccessful()) {
          throw new ProcessFailedException($process);
        }

        return $process->getExitCode();
    }

    private function getDirectories($path): array
    {
        $dirs = array();
        $finder = new Finder();
        $finder->directories()->depth(0)->in($path)->sortByName();

        if ($finder->hasResults()) {
            foreach($finder as $d) {
                $dirs[$d->getRelativePathname()] = $d->getRelativePathname();
            }
        }

        return $dirs;
    }

    public function getEnvironments(): array
    {
        $pwd = sprintf('%s/%s', $this->srcPath, $this->git_repo);
        return $this->getDirectories($pwd);
    }

    public function getApplications(string $environment=null): array
    {
        if (is_null($environment)) return array();

        $pwd = sprintf('%s/%s/%s', $this->srcPath, $this->git_repo, $environment);
        return $this->getDirectories($pwd);
    }

    public function getStacks(string $environment=null, string $app=null): array
    {
        if (
            is_null($environment) ||
            is_null($app)
        ) return array();

        $pwd = sprintf('%s/%s/%s/%s', $this->srcPath, $this->git_repo, $environment, $app);
        return $this->getDirectories($pwd);
    }

    public function getClients(string $environment=null, string $app=null, string $stack=null): array
    {
        if (
            is_null($environment) ||
            is_null($app) ||
            is_null($stack)
        ) return array();

        $pwd = sprintf('%s/%s/%s/%s', $this->srcPath, $this->git_repo, $environment, $app);
        return $this->getDirectories($pwd);
    }
}

