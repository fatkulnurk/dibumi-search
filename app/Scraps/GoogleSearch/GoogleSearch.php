<?php


namespace App\Scraps\GoogleSearch;

use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\CurlException;
use PHPHtmlParser\Exceptions\StrictException;
use Spatie\Url\Url;

class GoogleSearch
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
        $ch = curl_init("https://www.google.co.id/search?q=".urlencode($this->query)."&btnG=&newwindow=1&safe=active");
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
                CURLOPT_USERAGENT	   => "Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.11"
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
        $dom = new Dom;

        $dom->setOptions([
            'removeScripts' => true
        ]);

        try {
            $dom->load($html);
        } catch (\Exception $e) {
        }

        $selector = '.ZINbbc';
        $a = $dom->find($selector)[0];
        $a->delete();
        unset($a);
        $resultDOM = $dom->find($selector);

        $data = [];
        foreach($resultDOM as $key => $div) {
            $htmlSelector = $div->innerHtml;
            $dataObj = new \stdClass();
            if (!blank($htmlSelector)) {
                $dom->loadStr($htmlSelector);
                $a = $dom->find('a');

                foreach ($a as $link) {
                    $dom->load($link->innerHtml);
                    $result = $dom->find('div');
                    foreach ($result as $keyDivAhref => $divAhref) {
                        if ($keyDivAhref == 0) {
                            $dataObj->title = strip_tags($divAhref);
                        } else if($keyDivAhref == 1) {
                            $dataObj->breadcumb = strip_tags($divAhref);
                        }
                    }
                }

                $url = Url::fromString($a->href);
                $dataObj->url = $url->getQueryParameter('q');

                $divBySelector = explode('<div class="BNeawe s3v9rd AP7Wnd">', $htmlSelector);
                $dataObj->text = strip_tags(end($divBySelector));

                // hanya memasukan 10 data, dan ketika datanya ada 10 di hasil pencarian (faktanya datanya ada 13) maka cuma di ambil 10.
                if ($key < 10) {
                    if ($key <= (count($resultDOM) - 2)) {
                        if (!blank($dataObj->title) && !blank($dataObj->url) && !blank($dataObj->text)) {
                            $data[] = $dataObj;
                        }
                    }
                }
            }
        }

        return $data;
    }


    public function result()
    {
        $html = $this->crawl();
        return $this->parse($html);
    }
}
