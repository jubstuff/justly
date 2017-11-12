<?php

namespace Justly;


use PHPUnit\Framework\TestCase;

class UrlControllerTest extends TestCase
{
    /**
     * @var UrlController
     */
    private $urlController;

    /**
     * @var UrlRepository
     */
    private $urlRepository;

    public function setUp()
    {
        $this->urlRepository = \Phake::mock(UrlRepository::class);
        $this->urlController = new UrlController($this->urlRepository);
    }

    public function testGetIndex()
    {
        $_SERVER['HTTP_HOST'] = 'justly.local';
        $urlEntity = new UrlEntity('http://google.com');
        \Phake::when($this->urlRepository)->getLatestUrls->thenReturn([$urlEntity]);
        $this->expectOutputRegex('/Most Recent URLs/');
        $this->urlController->getIndex();

        \Phake::verify($this->urlRepository)->getLatestUrls(10);
    }
}