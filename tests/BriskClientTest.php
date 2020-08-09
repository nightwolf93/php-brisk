<?php

use Brisk\BriskClient;
use PHPUnit\Framework\TestCase;

final class BriskClientTest extends TestCase {
    protected static $client;

    public static function setUpBeforeClass() {
        self::$client = new BriskClient( 'http://localhost:3000', 'master', 'changeme' );
    }

    public function testCanCreateLink() {
        $link = self::$client->createLink( 'https://github.com/nightwolf93/brisk', 30000, 5 );
        $this->assertNotNull( $link );
        $this->assertEquals( 5, strlen( $link->slug ) );
    }

    public function testCanDeleteLink() {
        $link = self::$client->createLink( 'https://github.com/nightwolf93/brisk', 30000, 5 );
        $this->assertNotNull( $link );
        $success = self::$client->deleteLink( $link->slug );
        $this->assertTrue( $success );
    }

    public function testCanUpdateLink() {
        $link = self::$client->createLink( 'https://github.com/nightwolf93/brisk', 30000, 5 );
        $this->assertNotNull( $link );
        $success = self::$client->updateLink( $link->slug, 'https://github.com/nightwolf93/brisk', 60000 );
        $this->assertTrue( $success );
    }

    function generateRandomString( $length = 10 ) {
        return substr( str_shuffle( str_repeat( $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil( $length/strlen( $x ) ) ) ), 1, $length );
    }

    public function testCanCreateCredential() {
        $success = self::$client->createCredential( $this->generateRandomString( 32 ), $this->generateRandomString( 32 ) );
        $this->assertTrue( $success );
    }

    public function testCanRegisterWebhook() {
        $success = self::$client->registerWebhook( 'http://localhost:3000/test', ['new_link', 'visit_link', 'update_link'] );
        $this->assertTrue( $success );
    }
}