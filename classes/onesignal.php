<?php
/**
 * OneSignal FuelPHP Package
 * An open source package for FuelPHP that integrate the OneSignal platform into your project using Curl.
 *
 * @package    Onesignal
 * @version    1.0
 * @author     Luan Rodrigues
 * @license    MIT License
 * @link       https://github.com/luoldrigues/onesignal-fuelphp-package
 */

namespace Onesignal;

class Exception extends \FuelException {}
class OneSignalApiException extends \FuelException {}

class Onesignal
{
    /**
     * OneSignal App Id
     * @var string
     */
    protected $app_id;

    /**
     * Rest api key at One Signal Credentials Panel
     * @var string
     */
    protected $rest_api_key = null;

    /**
     * Enable/disable Debug on the config file
     * @var boolean
     */
    protected $debug = false;


    /**
     * Load config file and setup the package
     */
    public function __construct()
    {
        // Load config
        \Config::load('onesignal', true);

        // Setup variables
        $this->app_id = \Config::get('onesignal.onesignal_app_id');
        $this->rest_api_key = \Config::get('onesignal.onesignal_rest_api_key');
        $this->debug = \Config::get('onesignal.debug', false);
    }


    /**
     * Setup configs. Optional method if you have already setup the config file (config/onesignal.php)
     * This method allow you to use multiple settings for different platforms (for eg: android / ios)
     *
     * @param string  $app_id       OneSignal App Id
     * @param string  $rest_api_key Rest api key at One Signal Credentials Panel
     * @param boolean $debug        optional debug field
     */
    public function set_configs($app_id, $rest_api_key, $debug = false)
    {
        $this->app_id = $app_id;
        $this->rest_api_key = $rest_api_key;
    }


    /**
     * Set debug mode
     *
     * @param boolean $boolean
     */
    public function set_debug($boolean)
    {
        $this->debug = (boolean) $boolean;
    }


    /**
     * Send Push Notification Message to specific users
     *
     * @param  array  $content            Eg: $content = array("en" => 'English Message');
     * @param  array  $include_player_ids Optional param. Default value: All segments
     * @param  array  $data               Optional param to send extra data. Eg: $data = array("foo" => "bar");
     * @return boolean or array if debug
     */
    public function send_message_users($content, $include_player_ids, $data = [])
    {
        try
        {
            $this->validate_settings();

            if(!is_array($content))
            {
                if($this->debug)
                {
                    throw new Exception("The content must be an array with the language as key. Eg: \$content = array(\"en\" => 'English Message');");
                }

                return false;
            }

            if(!is_array($include_player_ids))
            {
                if($this->debug)
                {
                    throw new Exception("The include_player_ids must be an array of player_ids. Eg: \$include_player_ids = array(\"6392d91a-b206-4b7b-a620-cd68e32c3a76\",\"76ece62b-bcfe-468c-8a78-839aeaa8c5fa\",\"8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86\");");
                }

                return false;
            }

            if(!is_array($data))
            {
                if($this->debug)
                {
                    throw new Exception("The data must be an array");
                }

                return false;
            }

            $response = $this->make_request([
                'app_id' => $this->app_id,
                'include_player_ids' => $include_player_ids,
                'data' => $data,
                'contents' => $content
            ]);

            if($response && array_key_exists('error', $response))
            {
                if($this->debug)
                {
                    throw new OneSignalApiException($response['error']);
                }

                return false;
            }

            if($this->debug)
            {
                return [
                    'success' => true,
                    'fields_sent' => $fields,
                    'response' => $response
                ];
            }

            return true;
        }
        catch (Exception $e)
        {
            if($this->debug)
            {
                return $e->getMessage();
            }
        }

        return false;
    }


    /**
     * Make Request
     *
     * @param  array $fields Fields to be send
     * @return array
     */
    protected function make_request($fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $this->rest_api_key
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields, true));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $json = curl_exec($ch);
        curl_close($ch);

        return $json ? json_decode($json, true) : [];
    }


    /**
     * Validate Settings
     */
    protected function validate_settings()
    {
        if(!$this->app_id)
        {
            if($this->debug)
            {
                throw new Exception("Invalid App Id");
            }

            return false;
        }

        if(!$this->rest_api_key)
        {
            if($this->debug)
            {
                throw new Exception("Invalid Api Key");
            }

            return false;
        }
    }
}