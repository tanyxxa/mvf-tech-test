<?php
namespace MVF\Tests\Service;

use MVF\Model\GitHubRepository;
use MVF\Service\GitHubUserAnalyzer;
use PHPUnit\Framework\TestCase;

class GitHubAnalyzerTest extends TestCase
{
    public function repositoriesProvider()
    {
        return [
            [
                'repositories' => [
                    new GitHubRepository(['language' => 'PHP']),
                    new GitHubRepository(['language' => 'PHP']),
                    new GitHubRepository(['language' => 'Go']),
                ],
                'mostUsedLanguages' => ["PHP"]
            ],
            [
                'repositories' => [
                    new GitHubRepository(['language' => 'PHP']),
                    new GitHubRepository(['language' => 'PHP']),
                    new GitHubRepository(['language' => 'Go']),
                    new GitHubRepository(['language' => 'Go']),
                ],
                'mostUsedLanguages' => ["PHP", "Go"]
            ],
            [
                'repositories' => [
                    new GitHubRepository(['language' => 'PHP']),
                    new GitHubRepository(['language' => 'PHP']),
                    new GitHubRepository(['language' => 'Go']),
                    new GitHubRepository(['language' => 'Go']),
                    new GitHubRepository(['language' => 'Python']),
                ],
                'mostUsedLanguages' => ["PHP", "Go"]
            ],
            [
                'repositories' => [],
                'mostUsedLanguages' => []
            ],
        ];
    }

    /**
     * @dataProvider repositoriesProvider
     * @param array $repositories
     * @param array $mostUsedLanguages
     */
    public function testAnalyzer(array $repositories, array $mostUsedLanguages)
    {
        $gitHubAnalyzer = new GitHubUserAnalyzer();
        $gitHubAnalyzer->analyze($repositories);
        $this->assertEquals($mostUsedLanguages, $gitHubAnalyzer->getMostUsedLanguages());
    }
}