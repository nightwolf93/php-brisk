<?php

namespace Brisk;

/**
* BriskClient is a PHP library that allow you to interact with the Brisk API
*/

class BriskClient {

    private $baseUrl;
    private $clientId;
    private $clientSecret;

    public function __construct( $baseUrl, $clientId, $clientSecret ) {
        $this->baseUrl = $baseUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
    * Add default auth headers on the request
    *
    * @param [curl] $ch
    * @return void
    */

    private function addDefaultHeaders( $ch ) {
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'x-client-id: ' . $this->clientId,
            'x-client-secret: ' . $this->clientSecret,
            'Content-Type:application/json'
        ) );
    }

    /**
    * Create a new link
    *
    * @param [string] $url
    * @param [int] $ttl
    * @param [int] $slugLength
    * @return Link
    */

    public function createLink( $url, $ttl, $slugLength ) {
        $ch = curl_init( $this->baseUrl . '/api/v1/link' );
        $data = json_encode( [
            'url' => $url,
            'ttl' => $ttl,
            'slug_length' => $slugLength
        ] );

        $this->addDefaultHeaders( $ch );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $response = curl_exec( $ch );
        if ( !$response ) {
            return NULL;
        }
        if ( $response == 'Bad Request' || $response == 'Unauthorized' || $response == 'Conflict' ) {
            return false;
        }
        return json_decode( $response );
    }

    /**
    * Delete a link
    *
    * @param [string] $slug
    * @return boolean
    */

    public function deleteLink( $slug ) {
        $ch = curl_init( $this->baseUrl . '/api/v1/link' );
        $data = json_encode( [
            'slug' => $slug
        ] );

        $this->addDefaultHeaders( $ch );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $response = curl_exec( $ch );
        if ( !$response ) {
            return false;
        }
        if ( $response == 'Bad Request' || $response == 'Unauthorized' ) {
            return false;
        }
        return true;
    }

    /**
    * Update a link
    *
    * @param [string] $slug
    * @param [string] $url
    * @param [int] $ttl
    * @return boolean
    */

    public function updateLink( $slug, $url, $ttl = -1 ) {
        $ch = curl_init( $this->baseUrl . '/api/v1/link' );
        $data = json_encode( [
            'slug' => $slug,
            'ttl' => $ttl,
            'url' => $url
        ] );
        $this->addDefaultHeaders( $ch );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PATCH' );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $response = curl_exec( $ch );
        if ( !$response ) {
            return false;
        }
        if ( $response == 'Bad Request' || $response == 'Unauthorized' ) {
            return false;
        }
        return true;
    }

    /**
    * Create a new credential pair
    *
    * @param [string] $clientId
    * @param [string] $clientSecret
    * @return boolean
    */

    public function createCredential( $clientId, $clientSecret ) {
        $ch = curl_init( $this->baseUrl . '/api/v1/credential' );
        $data = json_encode( [
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        ] );
        $this->addDefaultHeaders( $ch );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $response = curl_exec( $ch );
        if ( $response == 'Bad Request' || $response == 'Unauthorized' || $response == 'Conflict' ) {
            return false;
        }

        return true;
    }

    /**
    * Registe a new webhhok
    *
    * @param [string] $url
    * @param [string[]] $bindings
    * @return void
    */

    public function registerWebhook( $url, $bindings ) {
        $ch = curl_init( $this->baseUrl . '/api/v1/webhook' );
        $data = json_encode( [
            'url' => $url,
            'bindings' => $bindings
        ] );
        $this->addDefaultHeaders( $ch );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $response = curl_exec( $ch );

        if ( $response == 'Bad Request' || $response == 'Unauthorized' || $response == 'Conflict' ) {
            return false;
        }
        return true;
    }
}