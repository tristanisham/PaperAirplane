<?php

namespace PaperAirplane;

use GuzzleHttp\Exception\GuzzleException;
use PaperAirplane\Exceptions\PaperAirplaneException;

require_once __DIR__ . '/../vendor/autoload.php';

// https://core.telegram.org/bots/api#authorizing-your-bot

class Api
{
    protected string $api_url;
    private \GuzzleHttp\Client $g;
    public array $data;
    public function __construct(protected string $bot_token)
    {
        $this->api_url = "https://api.telegram.org/bot" . $this->bot_token . "/";
        $this->g = new \GuzzleHttp\Client();
    }

    /**
     * This function registers your webhook api with Telegram. It only needs to be ran once at the beginning of building your app and can be run from your local machine or server.
     * @param string $target The URL Telegram should target webhooks at.
     * 
     * **Example:**
     * ```https://example.com/api/webhooks```
     * 
     * @return void
     * R@throws PaperAirplaneException 
     */
    public function set_up_web_hooks(string $target): bool
    {
        try {
            $response = $this->g->request('GET', $this->api_url . 'setwebhook?url=' . $target);
            $r_body = json_decode($response->getBody(), true);

            if ($r_body['ok'] == true && $r_body['result'] == true) {
                echo $r_body['description'];
                return true;
            }
        } catch (GuzzleException $e) {
            die($e);
        }
    }
    /**
     * ## Sets up the page handle incoming webhooks from Telegram.
     * Sets the page up to only **accpet**:
     * * POST Requests
     * * JSON content
     */
    public function handle_webhooks(): void
    {
        $headers = getallheaders();
        if ($headers['Content-Type'] == 'application/json' && $_SERVER['REQUEST_METHOD'] == "POST") {
            $input = file_get_contents("php://input");
            echo $input;
            //     $data = json_decode($input, true);
            //     // Finally where good code goes to fly!
            //     if ($data['ok']) {
            //         $this->data = $data;
            //     } else {
            //         echo $data['description'];
            die();
            //     }
        } else {
            http_response_code(400);
            echo "Unsupported Content or Method";
            die();
        }
    }
    /**
     * @return string JSON string value for Telegram's Bot Info *getMe()* function.
     */
    public function get_bot_info(): string
    {
        try {
            $response = $this->g->request("GET", $this->api_url . 'getMe');
            return $response->getBody();
        } catch (GuzzleException $e) {
            die($e);
        }
    }
}
