<?php
namespace MVF;

use MVF\Exception\UsernameIsNotSetException;
use MVF\Service\GitHubUserAnalyzer;
use Github\Client;
use MVF\Service\GitHubService;
use Exception;

class Command
{
    protected string $userName;
    protected GitHubService $service;

    public function __construct(array $argv, GitHubService $service)
    {
        if (!isset($argv[1])) {
            throw new UsernameIsNotSetException();
        }
        $this->userName = $argv[1];
        $this->service = $service;
    }

    public function run()
    {
        try {
            $analyzer = new GitHubUserAnalyzer();
            $userRepositories = $this->service->getUserRepositories($this->userName);
            $analyzer->analyze($userRepositories);
            return $analyzer->verbose();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}