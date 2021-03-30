<?php
namespace MVF\Tests\Model;

use MVF\Model\GitHubRepository;
use PHPUnit\Framework\TestCase;

class GitHubRepositoryTest extends TestCase
{
    public function repositoryDataProvider()
    {
        return [
            [
                ['language' => 'PHP'],
                'PHP'
            ],
            [
                ['language' => null],
                ''
            ],
        ];
    }
    /**
     * @dataProvider repositoryDataProvider
     * @param array $data
     * @param string $expectedLanguage
     */
    public function testRepositoryLanguage(array $data, string $expectedLanguage)
    {
        $gitHubRepository = new GitHubRepository($data);
        $this->assertEquals($expectedLanguage, $gitHubRepository->getLanguage());
    }
}