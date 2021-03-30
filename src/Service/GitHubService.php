<?php
namespace MVF\Service;

use Github\Client;
use Exception;
use MVF\Exception\GitHubUserNotFound;
use MVF\Model\GitHubRepository;

class GitHubService
{
    const NOT_FOUND_EXCEPTION_CODE = 404;

    /** @var Client */
    protected Client $gitHubClient;

    public function __construct(Client $gitHubClient)
    {
        $this->gitHubClient = $gitHubClient;
    }

    /**
     * @param string $userName
     * @return array
     *
     * @throws GitHubUserNotFound
     */
    public function getUserRepositories(string $userName) : array
    {
        try {
            $repositoriesData = $this->gitHubClient->user()->repositories($userName);
            $repositories = [];

            foreach ($repositoriesData as $data) {
                $repositories[] = new GitHubRepository($data);
            }

            return $repositories;
        } catch (Exception $e) {
            if ($e->getCode() == self::NOT_FOUND_EXCEPTION_CODE) {
                throw new GitHubUserNotFound($userName);
            }

            throw $e;
        }
    }
}