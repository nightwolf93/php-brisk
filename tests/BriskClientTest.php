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
}