<?php
namespace MVF\Model;

class GitHubRepository
{
    protected string $language;

    public function __construct(array $repositoryProperties)
    {
        $this->language = isset($repositoryProperties['language'])
            ? $repositoryProperties['language']
            : "";
    }

    public function getLanguage() : string
    {
        return $this->language;
    }
}