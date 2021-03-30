<?php declare(strict_types=1);
require_once "./vendor/autoload.php";

use MVF\Command;
use Github\Client;
use MVF\Service\GitHubService;

try {
    $service = new GitHubService(new Client());
    $command = new Command($argv, $service);
    echo $command->run();
} catch (Exception $e) {
    echo $e->getMessage();
}