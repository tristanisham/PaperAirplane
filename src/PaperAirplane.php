<?php
namespace PaperAirplane;

use GuzzleHttp\Exception\GuzzleException;;

require_once __DIR__ . '/../vendor/autoload.php';

class Api
{
    protected string $api_url;
    private \GuzzleHttp\Client $g;
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

            if ($r_body['ok'] == 1 && $r_body['result'] == 1) {
                echo $r_body['description'];
                return true;
            }
            
        } catch (GuzzleException $e) {
            die($e);
        }
    }
}