<?php


namespace Justly;


class UrlController
{
    /**
     * @var UrlRepository
     */
    private $urlRepository;

    /**
     * Creates a new controller given a repository.
     *
     * @param UrlRepository $urlRepository
     */
    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * Named constructor. Use this to return standard controller.
     *
     * @return UrlController
     */
    public static function create()
    {
        return new self(new UrlRepository());
    }

    public function getIndex()
    {
        $urlRepository = $this->urlRepository;
        $mostRecentUrls = $urlRepository->getLatestUrls(10);
        include CONFIG_VIEWS_DIR.'/index.php';
    }

    /**
     * Redirects the user the url identified by $shortenedUrl.
     *
     * @param string $shortenedUrl
     */
    public function redirectUrl($shortenedUrl)
    {
        $urlRepository = $this->urlRepository;
        $url = $urlRepository->getUrl($shortenedUrl);

        if ($url instanceof UrlEntity && $url->isValid()) {
            $urlRepository->incrementRedirects($url);
            header("Location: {$url->getTargetUrl()}");
        } else {
            header('HTTP/1.1 404 Not Found');
            include CONFIG_VIEWS_DIR.'/404.php';
        }
    }


    /**
     * Handle submission of the shortener form
     */
    public function postIndex()
    {
        session_start();

        $url = new UrlEntity($_POST['url']);

        if ($url->isValid()) {

            $urlRepository = $this->urlRepository;
            $urlRepository->addUrl($url);

            $shortenedUrl = urlencode($url->getShortenedUrl());
            header("Location: /shortened.php?url={$shortenedUrl}");
        } else {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $errorMsg = 'The URL provided is invalid.';
            include CONFIG_VIEWS_DIR.'/index.php';
        }
    }


    public function getShortenedUrl()
    {
        session_start();

        $urlRepository = $this->urlRepository;
        $url = $urlRepository->getUrl($_GET['url']);

        if ($url instanceof UrlEntity && $url->isValid()) {
            include CONFIG_VIEWS_DIR.'/shortened.php';

            return;
        } else {
            header('HTTP/1.1 404 Not Found');
            include CONFIG_VIEWS_DIR.'/404.php';

        }
    }


}