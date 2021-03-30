<?php
namespace MVF\Tests;

use Github\Client;
use MVF\Command;
use MVF\Exception\GitHubUserNotFound;
use MVF\Exception\UsernameIsNotSetException;
use MVF\Model\GitHubRepository;
use MVF\Service\GitHubService;
use MVF\Service\GitHubUserAnalyzer;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function testUsernameIsNotSet()
    {
        $this->expectException(UsernameIsNotSetException::class);

        $command = new Command([], $gitHubServiceMock = $this->createMock(GitHubService::class));
        $command->run();
    }

    public function testSuccessfulRun()
    {
        $gitHubServiceMock = $this->createMock(GitHubService::class);
        $gitHubServiceMock->method('getUserRepositories')->willReturn([
            new GitHubRepository(['language' => 'PHP']),
            new GitHubRepository(['language' => 'Go']),
            new GitHubRepository(['language' => 'Python']),
        ]);
        $command = new Command(['index.php', 'username'], $gitHubServiceMock);

        $this->assertEquals(
            sprintf(GitHubUserAnalyzer::MOST_USED_LANGUAGES_MESSAGE, "PHP, Go, Python") . PHP_EOL,
            $command->run()
        );

    }

    public function testGitHubServiceThrowsAnException()
    {
        $gitHubServiceMock = $this->createMock(GitHubService::class);
        $gitHubServiceMock
            ->expects($this->once())
            ->method('getUserRepositories')
            ->with($this->equalTo('username'))
            ->will($this->throwException(new GitHubUserNotFound('username')));

        $command = new Command(['index.php', 'username'], $gitHubServiceMock);

        $this->assertEquals(
            sprintf(GitHubUserNotFound::MESSAGE, 'username'),
            $command->run()
        );
    }
}