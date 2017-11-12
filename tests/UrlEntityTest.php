<?php

namespace Justly;

use PHPUnit\Framework\TestCase;

class UrlEntityTest extends TestCase
{
    /**
     * @var UrlEntity
     */
    private $urlEntity;

    public function setUp()
    {
        $this->urlEntity = new UrlEntity('http://google.com/');
    }

    public function testUrlEntityCreationWithGeneratedUrl()
    {
        $this->assertEquals('http://google.com/', $this->urlEntity->getTargetUrl(),
            'Target URL should be set by constructor');

        $this->assertEquals(0, $this->urlEntity->getRedirectCount(), 'Redirect count for a new URL should be zero');

        $this->assertRegExp('/^[0-9a-zA-Z]{8}$/', $this->urlEntity->getShortenedUrl(),
            'Generated URL should be 8 characters or numbers');
    }

    public function testUrlEntityCreationFromArray()
    {
        $this->urlEntity = UrlEntity::createFromArray([
            'targetUrl' => 'http://google.com/',
            'shortenedUrl' => 'abcdefgh',
            'redirects' => 10,
        ]);

        $this->assertEquals('http://google.com/', $this->urlEntity->getTargetUrl(),
            'Target URL should be equal to array targetUrl');

        $this->assertEquals(10, $this->urlEntity->getRedirectCount(), 'Redirect count should be set from array');

        $this->assertEquals('abcdefgh', $this->urlEntity->getShortenedUrl(),
            'Short URL should be set from array');
    }

    public function testValidUrl()
    {
        $this->assertTrue( $this->urlEntity->isValid(), 'http://google.com is a valid URL');
    }

    public function testInvalidUrl()
    {
        $this->urlEntity = new UrlEntity('Invalid URL');

        $this->assertFalse($this->urlEntity->isValid(), '"Invalid URL" is not a valid URL');
    }

    public function testInvalidUrlScheme()
    {
        $this->urlEntity = new UrlEntity('ftp://ftpserver.com');

        $this->assertFalse($this->urlEntity->isValid(), 'Only http and https scheme are allowed');
    }

}