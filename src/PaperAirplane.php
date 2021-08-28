<?php
namespace PaperAirplane;

use GuzzleHttp\Exception\GuzzleException;
use Telegram\Bot\HttpClients\GuzzleHttpClient;

require_once __DIR__ . '/../../vendor/autoload.php';

class Api
{
    protected string $api_url;
    private \GuzzleHttp\Client $g;
    public function __construct(protected string $bot_token)
    {
        $this->api_url = "https://api.telegram.org/bot" . $this->bot_token . "/";
        $this->g = new \GuzzleHttp\Client();
    }

    public function set_up_web_hooks(string $target): bool
    {
        try {
            $response = $this->g->request('GET', $this->api_url . 'setwebhook?url=' . $target);
            $r_body = json_decode($response->getBody(), true);

            //Need to handle variations
            return true;
        } catch (GuzzleException $e) {
            return false;
        }
    }
}