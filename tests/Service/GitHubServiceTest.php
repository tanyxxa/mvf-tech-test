<?php
namespace MVF\Tests\Service;

use Exception;
use MVF\Exception\GitHubUserNotFound;
use MVF\Model\GitHubRepository;
use MVF\Service\GitHubService;
use MVF\Tests\TestCase;

class GitHubServiceTest extends TestCase
{
    public function userRepositoriesDataProvider()
    {
        return [
            [
                [
                    ['language' => 'PHP']
                ],
                [
                    new GitHubRepository(['language' => 'PHP'])
                ]
            ],
            [
                [
                    ['language' => null],
                    ['language' => "PHP"],
                    ['language' => "Python"],
                ],
                [
                    new GitHubRepository(['language' => '']),
                    new GitHubRepository(['language' => 'PHP']),
                    new GitHubRepository(['language' => 'Python']),
                ]
            ]
        ];
    }

    /**
     * @dataProvider userRepositoriesDataProvider
     *
     * @param array $mockRepositoriesData
     * @param array $expectedUserRepositories
     * @throws GitHubUserNotFound
     */
    public function testGetUserRepositories(array $mockRepositoriesData, array $expectedUserRepositories)
    {
        $s = new GitHubService($this->getMockedGithubClient($mockRepositoriesData));
        $this->assertEquals(
            $expectedUserRepositories,
            $s->getUserRepositories('username')
        );
    }

    /**
     * @throws GitHubUserNotFound
     */
    public function testGetUserRepositoriesUserNotFound()
    {
        $this->expectException(GitHubUserNotFound::class);

        $s = new GitHubService($this->getMockedGithubClient([], 404));
        $s->getUserRepositories('user_not_found');
    }

    public function testGetUserRepositoriesServiceThrowsSomeException()
    {
        $this->expectException(Exception::class);

        $s = new GitHubService($this->getMockedGithubClient([], 500));
        $s->getUserRepositories('user_not_found');
    }
}