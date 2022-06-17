<?php
/**
 * Copyright (c) 2022.
 * Rafiq
 */

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

/**
 * Class GoogleSheetsService
 *
 * @package App\Services
 */
class GoogleSheetsService
{
    public $client, $service, $documentId, $range;

    public function __construct() {
        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        $this->documentId = '1HSMCwvgGWHlV6BMfT7Tfr5aXCt_ailUJKm_u4RAwy-g';
        $this->range = 'Sheet2!A:E';
    }

    /**
     * Get Google Sheets Api Client
     * 
     * @return Google\Client $client
     */
    public function getClient() {
        $client = new Client();
        $client->setApplicationName('Google Sheets Demo');
        $client->setRedirectUri('http://127.0.0.1:8000/googlesheet');
        $client->setScopes(Sheets::SPREADSHEETS);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');

        return $client;
    }

    /**
     * Read Google Sheets
     * 
     * @return JSON $doc
     */
    public function readSheet() {
        $doc = $this->service->spreadsheets_values->get($this->documentId, $this->range);
        return $doc;
    }

    /**
     * Write google sheets
     * 
     */
    public function writeSheet(array $rows) {

        $body = new ValueRange([
            'values' => $rows
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];

        $result = $this->service->spreadsheets_values->update($this->documentId, $this->range,
        $body, $params);
        // return $result->getTotalUpdatedCells();
    }

    /**
     * Append Google Sheets
     */
    public function appendSheet(array $rows) {

        $body = new ValueRange([
            'values' => $rows
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        $result = $this->service->spreadsheets_values->append($this->documentId, $this->range,
        $body, $params);
        // return $result->getUpdates()->getUpdatedCells()
    }
}
