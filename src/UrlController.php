<?php


namespace Justly;


class UrlController
{
    public function getIndex()
    {
        include CONFIG_VIEWS_DIR.'/index.php';
    }

    /**
     * Handle submission of the shortener form
     */
    public function postIndex()
    {
        session_start();

        $url = new UrlEntity($_POST['url']);

        if ($url->isValid()) {
            $_SESSION['urls'][$url->getShortenedUrl()] = $url;
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
        if( isset($_SESSION['urls'][$_GET['url']])){
            /** @noinspection PhpUnusedLocalVariableInspection */
            $url = $_SESSION['urls'][$_GET['url']];

            if( $url instanceof UrlEntity && $url->isValid())
            {
                include CONFIG_VIEWS_DIR.'/shortened.php';
                return;
            }
        }

        header('HTTP/1.1 404 Not Found');
        include CONFIG_VIEWS_DIR . '/404.php';



    }


}