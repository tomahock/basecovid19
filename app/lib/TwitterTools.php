<?php

namespace Lib;

require_once '/var/www/html/vendor/autoload.php';
use Dotenv;



class TwitterTools
{
    private static $client = false;

    static private function getClient()
    {
        if (!self::$client) {
            $dotenv = Dotenv\Dotenv::createImmutable('/var/www/html/');
            $dotenv->load();

            $settings = array(
                'oauth_access_token' => $_ENV['twitter_oauth_access_token'],
                'oauth_access_token_secret' => $_ENV['twitter_oauth_access_token_secret'],
                'consumer_key' => $_ENV['twitter_consumer_key'],
                'consumer_secret' => $_ENV['twitter_consumer_secret'],
            );

            self::$client = new \TwitterAPIExchange($settings);
        }

        return self::$client;
    }

    static private function splitTweets($long_string, $max_length = 280, $max_sentences = 10, $encoding = 'UTF-8')
    {
        $string_length = mb_strlen($long_string, $encoding);
        if ($string_length <= $max_length) {
            return [$long_string];
        }

        $words_array = explode(' ', $long_string);
        if (count($words_array) < 2) {
            return $words_array;
        }

        $first_word = $words_array[0];
        if (mb_strlen($first_word, $encoding) > $max_length) {
            return [mb_substr($first_word, 0, $max_length, $encoding)];
        }

        $sentences_array = [];
        $ended_word = 0;

        for ($sentence = 0; $sentence < $max_sentences; $sentence++) {
            $short_string = '';

            foreach ($words_array as $word_number => $current_word) {
                $expected_length = mb_strlen($short_string . ' ' . $current_word, $encoding);
                if ($expected_length > $max_length) {
                    break;
                }

                $short_string .= $current_word . ' ';
                $ended_word = $word_number + 1;
            }

            $sentences_array[] = $short_string;
            $words_array = array_slice($words_array, $ended_word);

            if (!$words_array) {
                break;
            }
        }

        return $sentences_array;
    }

    /**
     * @return array|bool
     */
    static public function tweet($text)
    {
        $client = self::getClient();
        $url = 'https://api.twitter.com/1.1/statuses/update.json';

        $tweets = self::splitTweets($text);

        $lastId = false;
        foreach ($tweets as $t) {
            $fields = array(
                'status' => $t
            );

            if ($lastId) {
                $fields['in_reply_to_status_id'] = $lastId;
            }

            $response = $client
                ->buildOauth($url, 'POST')
                ->setPostfields($fields)
                ->performRequest();

            $r = json_decode($response);

            print_r($r);

            $lastId = $r->id;
        }


    }

}

