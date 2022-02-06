<?php

namespace App\Entity;

class ConfOpts
{
    protected $env;
    protected $app;
    protected $stack;
    protected $client;

    public function getEnv(): string
    {
        return $this->env;
    }

    public function setEnv(string $env): void
    {
        $this->env = $env;
    }

    public function getApp(): string
    {
        return $this->app;
    }

    public function setApp(string $app): void
    {
        $this->app = $app;
    }

    public function getStack(): string
    {
        return $this->stack;
    }

    public function setStack(string $stack): void
    {
        $this->stack = $stack;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function setClient(string $client): void
    {
        $this->client = $client;
    }
}
