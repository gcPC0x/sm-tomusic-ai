<?php

namespace smtomusicai;

/**
 * Class MusicAiClient
 *
 * A client for interacting with the ToMusic AI platform.
 *
 * @package smtomusicai
 */
class MusicAiClient
{
    /**
     * @var string The API key used for authentication.
     */
    private string $apiKey;

    /**
     * MusicAiClient constructor.
     *
     * @param string $apiKey The API key to use for authentication.
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Generates music based on a text prompt.
     *
     * @param string $prompt The text prompt describing the desired music.
     * @param array $options  Optional parameters for music generation.  See the API documentation for available options.
     *
     * @return array|null An array containing the generated music data, or null on failure.
     * @throws \Exception If the API request fails.
     * @see https://tomusic.ai/ for API specification
     */
    public function generateMusic(string $prompt, array $options = []): ?array
    {
        $endpoint = $this->buildApiUrl('/generate');
        $data = array_merge(['prompt' => $prompt], $options);

        return $this->makeApiRequest($endpoint, 'POST', $data);
    }

    /**
     * Retrieves information about a specific music track.
     *
     * @param string $trackId The ID of the track to retrieve.
     *
     * @return array|null An array containing the track information, or null on failure.
     * @throws \Exception If the API request fails.
     */
    public function getTrackInfo(string $trackId): ?array
    {
        $endpoint = $this->buildApiUrl('/tracks/' . $trackId);

        return $this->makeApiRequest($endpoint, 'GET');
    }

    /**
     * Uploads a music sample for analysis.
     *
     * @param string $filePath The path to the music file to upload.
     *
     * @return array|null An array containing the analysis results, or null on failure.
     * @throws \Exception If the API request fails or the file does not exist.
     */
    public function uploadSample(string $filePath): ?array
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: " . $filePath);
        }

        $endpoint = $this->buildApiUrl('/upload');

        $file = curl_file_create($filePath, mime_content_type($filePath), basename($filePath));
        $data = ['file' => $file];

        return $this->makeApiRequest($endpoint, 'POST', $data, true);
    }

    /**
     * Builds the full API URL from an endpoint.
     *
     * @param string $endpoint The API endpoint.
     *
     * @return string The full API URL.
     */
    private function buildApiUrl(string $endpoint): string
    {
        return "https://tomusic.ai" . $endpoint;
    }

    /**
     * Makes a request to the ToMusic AI API.
     *
     * @param string $url The URL to request.
     * @param string $method The HTTP method to use.
     * @param array $data The data to send in the request body.
     * @param bool $isFileUpload Whether the request is a file upload.
     *
     * @return array|null An array containing the API response data, or null on failure.
     * @throws \Exception If the API request fails.
     */
    private function makeApiRequest(string $url, string $method, array $data = [], bool $isFileUpload = false): ?array
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);

        if (!empty($data)) {
            if ($isFileUpload) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(curl_getinfo($ch, CURLINFO_HTTP_HEADER), ['Content-Type: application/json']));

            }
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            $responseData = json_decode($response, true);
            return $responseData;
        } else {
            error_log("API Request Failed: HTTP Code " . $httpCode . ", Response: " . $response); // Log the error
            return null;
        }
    }
}