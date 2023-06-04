<?php

namespace App\Models\RSSReader;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CronRssReaderReadAllRss extends Model
{
  use HasFactory;

  public function ReadAllRSS()
  {
    $results = DB::table('rss_table_sources')
    ->where('hiddenRow', '=', 0)
    ->get();
    $results = json_decode(json_encode($results), true);

    $count = count($results);
    $check = 0;
    $inserts = [];
    date_default_timezone_set("UTC");

    if($count > 0)
    {
      for($i = 0; $i < $count; $i++)
      {
        $sourceID = (int)$results[$i]['uniqueIndex'];

        // if($sourceID !== 177) continue;

        $link = (string)$results[$i]['sourceLink'];

        try
        {
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch,CURLOPT_URL,$link);
          curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
          curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_VERBOSE, 1);
          $content = curl_exec($ch);
          curl_close($ch);

          if($content === null || $content === ""){
            continue;
          }

          $dom = new \DOMDocument;
          libxml_use_internal_errors(true);
          $dom->loadXML($content);



          $root = $dom->documentElement->tagName;

          // RSS FEEDS
          if($root === 'rss')
          {

            $channel = $dom->getElementsByTagName("channel");

            $channelTitle = "";
            $channelLink = "";
            $channelDescription = "";
  
            foreach($channel as $data)
            {
              if(count($data->getElementsByTagName("title")) !== 0) $channelTitle = (string)$data->getElementsByTagName("title")->item(0)->nodeValue;
              if(count($data->getElementsByTagName("link")) !== 0) $channelLink = (string)$data->getElementsByTagName("link")->item(0)->nodeValue;
              if(count($data->getElementsByTagName("description")) !== 0) $channelDescription = (string)$data->getElementsByTagName("description")->item(0)->nodeValue;
            }
  
            $channelTitle = trim($channelTitle);
            $channelLink = trim($channelLink);
            $channelDescription = trim($channelDescription);
  
            $content = $dom->getElementsByTagName("item");
            
            foreach($content as $data)
            {
              $itemTitle = "";
              $itemLink = "";
              $itemDescription = "";
              $itemDate = strtotime("now");
  
              // Necessary
              if(count($data->getElementsByTagName("title")) !== 0) $itemTitle = (string)$data->getElementsByTagName("title")->item(0)->nodeValue;
              if(count($data->getElementsByTagName("link")) !== 0) $itemLink = (string)$data->getElementsByTagName("link")->item(0)->nodeValue;
              if(count($data->getElementsByTagName("description")) !== 0) $itemDescription = (string)$data->getElementsByTagName("description")->item(0)->nodeValue;
              
              // Optional
              if(count($data->getElementsByTagName("pubDate")) !== 0)
              {
                $pubDate = (string)$data->getElementsByTagName("pubDate")->item(0)->nodeValue;
                $itemDate = strtotime($pubDate);
                if($itemDate === false) $itemDate = strtotime("now");
              }
  
              $itemTitle = trim($itemTitle);
              $itemLink = trim($itemLink);
              $itemDescription = trim($itemDescription);
  
              $notHidden = 0;
  
              $newInsert = [
                "sourceID" => $sourceID,
                "itemTitle" => $itemTitle,
                "itemLink" => $itemLink,
                "itemDescription" => $itemDescription,
                "itemDate" => $itemDate,
                "channelTitle" => $channelTitle,
                "channelLink" => $channelLink,
                "channelDescription" => $channelDescription,
                "hiddenRow" => $notHidden,
              ];
  
              array_push($inserts, $newInsert);
            }
            $updatedAt = strtotime("now");
            DB::table('rss_table_sources')
            ->where('uniqueIndex', "=", $sourceID)
            ->update([ 'updated_at' => $updatedAt ]);

          }
          else if($root === 'feed') // ATOM FEEDS
          {

            $channel = $dom->getElementsByTagName("feed");

            $channelTitle = "";
            $channelLink = "";
            $channelDescription = "";

            foreach($channel as $data)
            {
              if(count($data->getElementsByTagName("title")) !== 0) $channelTitle = (string)$data->getElementsByTagName("title")->item(0)->nodeValue;
              if(count($data->getElementsByTagName("link")) !== 0) $channelLink = (string)$data->getElementsByTagName("link")->item(0)->nodeValue;
              if(count($data->getElementsByTagName("subtitle")) !== 0) $channelDescription = (string)$data->getElementsByTagName("subtitle")->item(0)->nodeValue;
            }
  
            $channelTitle = trim($channelTitle);
            $channelLink = trim($channelLink);
  
            $content = $dom->getElementsByTagName("entry");
            
            foreach($content as $data)
            {
              $itemTitle = "";
              $itemLink = "";
              $itemDescription = "";
              $itemDate = strtotime("now");
  
              // Necessary
              if(count($data->getElementsByTagName("title")) !== 0) $itemTitle = (string)$data->getElementsByTagName("title")->item(0)->nodeValue;
              if(count($data->getElementsByTagName("link")) !== 0) $itemLink = (string)$data->getElementsByTagName("link")->item(0)->getAttribute('href');
              if(count($data->getElementsByTagName("content")) !== 0) $itemDescription = (string)$data->getElementsByTagName("content")->item(0)->nodeValue;
              
              // Optional
              if(count($data->getElementsByTagName("updated")) !== 0)
              {
                $pubDate = (string)$data->getElementsByTagName("updated")->item(0)->nodeValue;
                $itemDate = strtotime($pubDate);
                if($itemDate === false) $itemDate = strtotime("now");
              }
  
              $itemTitle = trim($itemTitle);
              $itemLink = trim($itemLink);
              $itemDescription = trim($itemDescription);
  
              $notHidden = 0;
  
              $newInsert = [
                "sourceID" => $sourceID,
                "itemTitle" => $itemTitle,
                "itemLink" => $itemLink,
                "itemDescription" => $itemDescription,
                "itemDate" => $itemDate,
                "channelTitle" => $channelTitle,
                "channelLink" => $channelLink,
                "channelDescription" => $channelDescription,
                "hiddenRow" => $notHidden,
              ];
  
              array_push($inserts, $newInsert);
            }
            $updatedAt = strtotime("now");
            DB::table('rss_table_sources')
            ->where('uniqueIndex', "=", $sourceID)
            ->update([ 'updated_at' => $updatedAt ]);

          }

          
        }
        catch(Illuminate\Database\QueryException $ex)
        {

        }
      }
    }

    if(count($inserts) > 0)
    {
      try
      {
        foreach(array_chunk($inserts, 1000) as $t)
        {
          DB::table('rss_table_items')->insertOrIgnore($t);
        }
        return "Success";
      }
      catch(Illuminate\Database\QueryException $ex)
      {
        return $ex;
      }
    }
  }
}
