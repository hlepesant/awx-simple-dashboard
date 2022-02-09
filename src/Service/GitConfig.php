<?php

namespace App\Service;

# use Symfony\Component\HttpClient\HttpClient;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;


Class GitConfig
{
    private $git_url;
    private $git_repo;
    private $srcPath;
    private $fs;

    public function __construct(string $git_url, string $git_repo, string $rootPath)
    {
	      $this->git_url = $git_url;
	      $this->git_repo = $git_repo;
	      $this->srcPath = sprintf("%s/sources", $rootPath);
        $this->fs = new Filesystem();
    }

    public function getRepo(): int
    {
        $pwd = sprintf('%s/%s', $this->srcPath, $this->git_repo);


        if ( $this->fs->exists($pwd) ) {
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

    private function getDirectories(string $path): array
    {
        $dirs = array();
        $finder = new Finder();
        $finder->directories()->depth(0)->in($path)->notName('ansistrano')->sortByName();

        if ($finder->hasResults()) {
            // $dirs[] = '-- select --';
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

        $pwd = sprintf('%s/%s/%s/%s/%s', $this->srcPath, $this->git_repo, $environment, $app, $stack);
        return $this->getDirectories($pwd);
    }

    public function getGitRepo(): string
    {
        return $this->git_repo;
    }

    private function readYaml(string $path): mixed
    {
        return Yaml::parseFile( $path);
    }

    public function getAppDefault(string $env, string $app): array
    {
        $p = sprintf("%s/%s/%s/%s/default.yml", $this->srcPath, $this->git_repo, $env, $app);

        if ( $this->fs->exists($p) )
        {
            return $this->readYaml($p);
        }
        return array();
    }

    public function getStackDefault(string $env, string $app, string $stack): array
    {
        $p = sprintf("%s/%s/%s/%s/%s/default.yml", $this->srcPath, $this->git_repo, $env, $app, $stack);

        if ( $this->fs->exists($p) )
        {
            return $this->readYaml($p);
        }
        return array();
    }

    public function getClientMain(string $env, string $app, string $stack, string $client): array
    {
        $p = sprintf("%s/%s/%s/%s/%s/%s/main.yml", $this->srcPath, $this->git_repo, $env, $app, $stack, $client);

        if ( $this->fs->exists($p) )
        {
            return $this->readYaml($p);
        }
        return array();
    }
}

