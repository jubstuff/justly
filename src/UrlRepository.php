<?php


namespace Justly;

/**
 * Handles persistence and retrieval of URLs.
 *
 * Class UrlRepository
 */
class UrlRepository
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * UrlRepository constructor.
     */
    public function __construct()
    {
        $this->pdo = DatabaseService::getInstance()->getPdo();
    }

    /**
     * Retrieves a URL entity from the repository using the shortened URL.
     *
     * @param $shortenedUrl
     *
     * @return UrlEntity
     */
    public function getUrl($shortenedUrl)
    {
        $sql = 'SELECT * FROM urls WHERE shortenedUrl = :shortenedUrl';
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['shortenedUrl' => $shortenedUrl]);
        $row = $stm->fetch(\PDO::FETCH_ASSOC);

        if (!empty($row)) {
            return UrlEntity::createFromArray($row);
        } else {
            return null;
        }
    }

    public function addUrl(UrlEntity $urlEntity)
    {
        $sql = 'INSERT INTO urls(shortenedUrl, targetUrl, timestamp) VALUES (:shortenedUrl, :targetUrl, :timestamp)';
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'shortenedUrl' => $urlEntity->getShortenedUrl(),
            'targetUrl' => $urlEntity->getTargetUrl(),
            'timestamp' => time(),
        ]);
    }

    /**
     * Returns up to $maximumNumber of the most recent URLs.
     *
     * @param $maximumNumber
     *
     * @return array
     */
    public function getLatesUrls($maximumNumber)
    {
        $sql = 'SELECT * FROM urls ORDER BY timestamp DESC LIMIT :limit';
        $stm = $this->pdo->prepare($sql);
        $stm->execute([':limit' => $maximumNumber]);

        $urls = [];
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $urls[] = UrlEntity::createFromArray($row);
        }

        return $urls;
    }

    public function incrementRedirects(UrlEntity $url)
    {
        $sql = 'UPDATE urls SET redirects = redirects + 1 WHERE shortenedUrl = :shortenedUrl';
        $stm = $this->pdo->prepare($sql);

        $stm->execute(['shortenedUrl' => $url->getShortenedUrl()]);
    }

}