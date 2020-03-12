<?php


namespace App\Scraps\DuckDuckGo;


use PHPHtmlParser\Dom;
use Spatie\Url\Url;

class DuckDuckGo
{

    private $query;
    private $resultRawHTML;
    private $result;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function crawl()
    {
        $ch = curl_init("https://api.duckduckgo.com/?q=".urlencode($this->query)."&format=json&pretty=1");
        curl_setopt_array($ch,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FOLLOWLOCATION => true,
//                CURLOPT_COOKIEJAR	   => $this->cookieFile,
//                CURLOPT_COOKIEFILE	   => $this->cookieFile,
                CURLOPT_TIMEOUT		   => 300,
                CURLOPT_CONNECTTIMEOUT => 300,
//                CURLOPT_USERAGENT	   => "Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.11"
                CURLOPT_USERAGENT	   => "Opera/9.30 (Nintendo Wii; U; ; 2071; Wii Shop Channel/1.0; en)"
            ]
        );
        $out = curl_exec($ch);
        if ($ern = curl_errno($ch)) {
            throw new \Exception("Error ({$ern}): ".curl_error($ch), 1);
        }
        curl_close($ch);

        return $out;
    }

    private function parse($html)
    {
        $data = $html;

        return json_decode($data);
    }


    public function result()
    {
        $html = $this->crawl();
        return $this->parse($html);
    }
}
