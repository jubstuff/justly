<?php


namespace Justly;


class UrlController
{
    public function getIndex()
    {
        include CONFIG_VIEWS_DIR . '/index.php';
    }

    /**
     * Handle submission of the shortener form
     */
    public function postIndex()
    {
        session_start();

        $url = new UrlEntity($_POST['url']);
        $_SESSION['urls'][$url->getShortenedUrl()] = $url;

        $shortenedUrl = urlencode($url->getShortenedUrl());
        header("Location: /shortened.php?url={$shortenedUrl}");
    }

    public function getShortenedUrl()
    {
        session_start();

        /** @noinspection PhpUnusedLocalVariableInspection */
        $url = $_SESSION['urls'][$_GET['url']];
        include CONFIG_VIEWS_DIR . '/shortened.php';


    }


}