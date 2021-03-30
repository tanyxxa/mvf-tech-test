<?php
namespace MVF\Service;

use MVF\Model\GitHubRepository;

class GitHubUserAnalyzer
{
    const MOST_USED_LANGUAGES_MESSAGE = "The most popular language(s) for user are: %s";
    const UNKNOWN_LANGUAGES_MESSAGE = "User has %d repositories with unknown language";
    const FULL_LIST_OF_USED_LANGUAGES_MESSAGE = "The full list of used languages: %s";
    const USER_DOESNT_HAVE_PUBLIC_REPOSITORIES_MESSAGE = "Unable to analyze: user doesn't have public repositories";

    /** @var array Sorted array of users used languages */
    protected array $usedLanguages = [];

    /** @var int The number of repositories with unknown language */
    protected int $unknownLanguageCount = 0;

    /** @var int Total number of users repositories */
    protected int $totalRepositoriesCount = 0;

    public function analyze(array $repositories)
    {
        $languages = [];
        $this->totalRepositoriesCount = count($repositories);

        /** @var GitHubRepository $repository */
        foreach ($repositories as $repository) {
            // ignore repositories without language, just count them
            if (empty($repository->getLanguage())) {
                $this->unknownLanguageCount++;
                continue;
            }
            if (!isset($languages[$repository->getLanguage()])) {
                $languages[$repository->getLanguage()] = 0;
            }
            $languages[$repository->getLanguage()]++;
        }
        arsort($languages);
        $this->usedLanguages = $languages;
    }

    public function getMostUsedLanguages() : array
    {
        $mostPopularLanguages = [];
//        $mostPopular = array_key_first($this->usedLanguages);
//        $mostPopularLanguages[] = $mostPopular;
//        $mostPopularCount = $this->usedLanguages[$mostPopular];

        $i = 0;
        $mostPopularCount = 0;
        foreach ($this->usedLanguages as $language => $count) {
            if ($i == 0) {
                $mostPopularLanguages[] = $language;
                $mostPopularCount = $count;
            } else {
                if ($count == $mostPopularCount) {
                    $mostPopularLanguages[] = $language;
                } else break;
            }
            $i++;
        }

        return $mostPopularLanguages;
    }

    public function verbose($full = false) : string
    {
        if ($this->totalRepositoriesCount == 0) {
            return self::USER_DOESNT_HAVE_PUBLIC_REPOSITORIES_MESSAGE . PHP_EOL;
        }

        $message = sprintf(
            self::MOST_USED_LANGUAGES_MESSAGE,
            implode(", ", $this->getMostUsedLanguages())
        ) . PHP_EOL;

        if ($full) {
            if ($this->unknownLanguageCount > 0) {
                $message .= sprintf(
                        self::UNKNOWN_LANGUAGES_MESSAGE,
                        $this->unknownLanguageCount
                    ) . PHP_EOL;
            }

            $fullList = "";
            foreach ($this->usedLanguages as $name => $count) {
                $percentage = round($count / $this->totalRepositoriesCount * 100, 2);
                $fullList .= $name . ": " . $count . " (" . $percentage . "%); ";
            }

            $message .= sprintf(
                self::FULL_LIST_OF_USED_LANGUAGES_MESSAGE,
                $fullList
            ) . PHP_EOL;
        }
        return $message;
    }
}