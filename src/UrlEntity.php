<?php

namespace Justly;


class UrlEntity
{
    /**
     * @var string
     */
    private $targetUrl;

    /**
     * @var string
     */
    private $shortenedUrl;

    /**
     * @var int
     */
    private $redirectCount;

    /**
     * UrlEntity constructor.
     *
     * @param string $targetUrl
     * @param null $shortenedUrl
     */
    public function __construct($targetUrl, $shortenedUrl = null)
    {
        $this->targetUrl = $targetUrl;
        $this->redirectCount = 0;
        if (empty($shortenedUrl)) {
            $this->shortenedUrl = $this->generateRandomToken();
        } else {
            $this->shortenedUrl = $shortenedUrl;
        }

    }

    /**
     * Creates a new URL Entity using an associative array.
     *
     * This is commonly used to create an entity from a database row.
     *
     * @param array $row
     * @return UrlEntity
     */
    public static function createFromArray($row)
    {
        $url = new UrlEntity($row['targetUrl'], $row['shortenedUrl']);
        $url->redirectCount = $row['redirects'];

        return $url;
    }

    /**
     * Generate a random 8 character string for a shortened url
     *
     * @return string
     */
    private function generateRandomToken()
    {
        $characters = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $token = '';
        for ($i = 0; $i < 8; $i++) {
            $token .= $characters[array_rand($characters)];
        }

        return $token;

    }

    /**
     * @return string
     */
    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }

    /**
     * @return string
     */
    public function getShortenedUrl(): string
    {
        return $this->shortenedUrl;
    }

    public function getRedirectCount(): int
    {
        return $this->redirectCount;
    }

    public function isValid()
    {
        $validUrl = filter_var($this->targetUrl, FILTER_VALIDATE_URL);

        if ($validUrl !== false) {
            $protocol = parse_url($validUrl, PHP_URL_SCHEME);
            if ($protocol === 'http' || $protocol === 'https') {
                return true;
            }
        }

        return false;
    }


}