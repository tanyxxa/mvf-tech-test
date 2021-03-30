<?php
namespace MVF\Tests;

use Github\Api\User;
use Github\Client;
use PHPUnit\Framework\MockObject\MockObject;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getMockedGithubClient(array $returnedRepositoriesData, int $exceptionCode = null) : MockObject
    {
        $apiUserMock = $this->createMock(User::class);
        if (!is_null($exceptionCode)) {
            $apiUserMock
                ->method('repositories')
                ->will($this->throwException(new \Exception('Exception message', $exceptionCode)));
        } else {
            $apiUserMock
                ->method('repositories')
                ->willReturn($returnedRepositoriesData);
        }

        $gitHubClientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->addMethods(['user'])
            ->getMock();
        $gitHubClientMock->method('user')->willReturn($apiUserMock);

        return $gitHubClientMock;
    }
}