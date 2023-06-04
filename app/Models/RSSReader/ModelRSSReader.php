<?php

namespace App\Models\RSSReader;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModelRSSReader extends Model
{
  use HasFactory;

  public function GetItems(array $dateData, string $category, string $group, string $title, int $offset)
  {
    if(count($dateData) != 2) return [];

    $start = $dateData[0];
    $end = $dateData[1];

    $group = (string)trim($group);
    $category = (string)trim($category);
    $title = (string)trim($title);

    if($category === "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else if($category === "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->skip($offset)
      ->take(100)
      ->get();
    }
    else
    {
      return [];
    }
  }

  public function GetCategoryNames()
  {
    $results = DB::table('rss_table_sources')
    ->select('category')
    ->distinct()
    ->where('hiddenRow', '=', 0)
    ->get();
    $results = json_decode(json_encode($results), true);
    sort($results);
    return $results;
  }

  public function GetGroupNames() : array
  {
    $results = DB::table('rss_table_sources')
    ->select('groupName')
    ->distinct()
    ->where('hiddenRow', '=', 0)
    ->get();
    $results = json_decode(json_encode($results), true);
    sort($results);
    return $results;
  }

  public function GetChannelNames() : array
  {
    $results = DB::table('rss_table_sources')
    ->select('sourceTitle')
    ->distinct()
    ->where('hiddenRow', '=', 0)
    ->get();
    $results = json_decode(json_encode($results), true);
    sort($results);
    return $results;
  }

  public function GetWords(array $dateData, string $category, string $group, string $title)
  {
    if(count($dateData) != 2) return [];

    $start = $dateData[0];
    $end = $dateData[1];

    if($category === "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'table_sources.uniqueIndex', '=', 'table_items.sourceID')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'table_sources.uniqueIndex', '=', 'table_items.sourceID')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'table_sources.uniqueIndex', '=', 'table_items.sourceID')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'table_sources.uniqueIndex', '=', 'table_items.sourceID')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'table_sources.uniqueIndex', '=', 'table_items.sourceID')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'table_sources.uniqueIndex', '=', 'table_items.sourceID')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else if($category === "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'table_sources.uniqueIndex', '=', 'table_items.sourceID')
      ->select('rss_table_items.itemTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->get();
    }
    else
    {
      return [];
    }
  }

  public function ProcessWords($wordData)
  {
    $stopWords = Storage::get('public/rssreader/stopwords.txt');
    $stopArray = explode("\n",$stopWords);
    $text = str_replace(array("\n", "\r"), '', $stopArray);
    $stopArray = array_unique($text);

    $words = [];

    $debugArray = [];

    $count = count($wordData);

    for($i = 0; $i < $count; $i++)
    {
      $title = $wordData[$i]["itemTitle"];
      $alphaNumericOnly = preg_replace('~\P{Xan}++~u', ' ', $title);
      $wordsArray = explode(" ", $alphaNumericOnly);

      foreach($wordsArray as $word)
      {
        $shortWord = trim($word);
        if(array_key_exists($shortWord, $words))
        {
          $words[$shortWord]["count"]++;
        }
        else
        {
          if(in_array(strtolower($shortWord), $stopArray, true) === false)
          {
            $words[$shortWord]["word"] = $shortWord;
            $words[$shortWord]["count"] = 1;
            array_push($debugArray, $shortWord);
          }
        }
      }
    }

    $marks = array();
    foreach ($words as $key => $row)
    {
      $marks[$key] = $row['count'];
    }

    array_multisort($marks, SORT_DESC, $words);

    $count2 = count($words);

    if($count2 > 100) $words = array_splice($words, 0, 100);

    return $words;
  }

  public function GetItemsWithSearchWord(array $data, string $category, string $group, string $title, string $searchWord)
  {
    if(count($data) != 2) return [];

    $start = $data[0];
    $end = $data[1];
    $search = '%' . $searchWord . '%';

    if($category === "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.category', '=', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', '=', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else if($category === "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', '=', $title)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->where('rss_table_items.itemTitle', 'like', $search)
      ->orderBy('rss_table_items.itemDate', 'desc')
      ->get();
    }
    else
    {
      return [];
    }
  }

  public function SaveItem($index)
  {
    $userID = Auth::id();
    date_default_timezone_set("UTC");
    $nowDate = strtotime("now");
    
    DB::table('rss_table_saved')->insert([
      'userID' => $userID,
      'itemID' => $index,
      'saveDate' => $nowDate,
      'hiddenRow' => 0
    ]);
      
    return "Item Saved.";
  }

  public function GetSources()
  {
    $userID = Auth::id();
    $results = DB::table('rss_table_sources')
    ->where('hiddenRow', '=', 0)
    ->where('userID', '=', $userID)
    ->get();
    return $results = json_decode(json_encode($results), true);
  }

  public function AddSource($title, $link, $group, $category, $country)
  {
    $userID = Auth::id();
    $now = strtotime("now");
    DB::table('rss_table_sources')->insert([
      'userID' => $userID,
      'sourceTitle' => $title,
      'sourceLink' => $link,
      'groupName' => $group,
      'category' => $category,
      'country' => $country,
      'updated_at' => $now,
      'hiddenRow' => 0
    ]);
  }

  public function UpdateSource($index, $title, $link, $group, $category, $country)
  {
    $now = strtotime("now");
    DB::table('rss_table_sources')
    ->where('uniqueIndex', "=", $index)
    ->update(['sourceTitle' => $title,
      'sourceLink' => $link,
      'groupName' => $group,
      'category' => $category,
      'country' => $country,
      'updated_at' => $now,
    ]);
  }

  public function DeleteSource($index)
  {
    DB::table('rss_table_sources')
    ->where('uniqueIndex', "=", $index)
    ->update(['hiddenRow' => 1 ]);
  }

  public function GetRandomTick(array $dateData, string $category, string $group, string $title, int $toggleItems)
  {
    if(count($dateData) != 2) return [];

    $category = (string)trim($category);
    $group = (string)trim($group);
    $title = (string)trim($title);

    $start = $dateData[0];
    $end = $dateData[1];

    if($category === "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else if($category !== "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else if($category !== "-1" && $group === "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.category', $category)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else if($category === "-1" && $group !== "-1" && $title === "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.groupName', $group)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else if($category === "-1" && $group === "-1" && $title !== "-1")
    {
      return $results = DB::table('rss_table_items')
      ->join('rss_table_sources', 'rss_table_sources.uniqueIndex', '=', 'rss_table_items.sourceID')
      ->select('rss_table_items.uniqueIndex', 
      'rss_table_items.itemTitle', 
      'rss_table_items.sourceID',
      'rss_table_items.itemLink',
      'rss_table_items.itemDescription',
      'rss_table_items.itemDate',
      'rss_table_items.channelTitle')
      ->where('rss_table_items.hiddenRow', '=', 0)
      ->where('rss_table_sources.sourceTitle', $title)
      ->where('rss_table_items.itemDate', '>=', $start)
      ->where('rss_table_items.itemDate', '<=', $end)
      ->inRandomOrder()
      ->limit($toggleItems)
      ->get();
    }
    else
    {
      return [];
    }
  }

  public function GetSaved(int $userID, int $offset)
  {
    return $results = DB::table('rss_table_saved')
    ->join('rss_table_items', 'rss_table_saved.itemID', '=', 'rss_table_items.uniqueIndex')
    ->select('rss_table_items.uniqueIndex', 
    'rss_table_items.itemTitle', 
    'rss_table_items.sourceID',
    'rss_table_items.itemLink',
    'rss_table_items.itemDescription',
    'rss_table_items.itemDate',
    'rss_table_items.channelTitle',

    'rss_table_saved.saveDate')
    ->where('rss_table_saved.hiddenRow', '=', 0)
    ->where('rss_table_saved.userID', $userID)
    ->orderBy('rss_table_items.itemDate', 'desc')
    ->skip($offset)
    ->take(100)
    ->get();
  }

  public function DeleteSaved($index)
  {
    DB::table('rss_table_saved')
    ->where('itemID', "=", $index)
    ->update(['hiddenRow' => 1 ]);
  }
}
