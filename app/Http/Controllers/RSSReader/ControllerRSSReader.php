<?php

namespace App\Http\Controllers\RSSReader;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\Models\RSSReader\ModelRSSReader;
use App\Models\RSSReader\CronRssReaderReadAllRss;

class ControllerRSSReader extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index(Request $request)
  {
    date_default_timezone_set("UTC");
    $startTime = strtotime("today");
    $endTime = strtotime("now");
    $dateRange = [$startTime, $endTime];

    $category = "-1";
    $group = "-1";
    $title = "-1";
    if($request->session()->has('rssOffset'))
    {
      $offset = (int)session('rssOffset');
    }
    else
    {
      session(['rssOffset' => 0]);
      $offset = (int)session('rssOffset');
    }

    $model = new ModelRSSReader();

    $readerCategories = $model->GetCategoryNames();
    $readerChannels = $model->GetChannelNames();
    $readerGroups = $model->GetGroupNames();

    $items = $model->GetItems($dateRange, $category, $group, $title, $offset);
    $items = json_decode(json_encode($items), true);

    $now = time();

    return view('RSSReader.rssreaderReader', [
      'items' => $items,
      'readercategories' => $readerCategories,
      'readerchannels' => $readerChannels,
      'readergroups' => $readerGroups,
      'now' => $now
    ]);
  }

  public function profile(Request $request)
  {
    date_default_timezone_set("Europe/London");
    $model = new ModelRSSReader();
    $userID = Auth::id();

    if($request->session()->has('rssOffset'))
    {
      $offset = (int)session('rssOffset');
    }
    else
    {
      session(['rssOffset' => 0]);
      $offset = (int)session('rssOffset');
    }

    $items = $model->GetSaved($userID, $offset);
    $items = json_decode(json_encode($items), true);

    return view('RSSReader.rssreaderProfile', [
      'items' => $items
    ]);
  }

  public function GetRss(Request $request)
  { 
    $readerModel = new ModelRSSReader();
    date_default_timezone_set("UTC");

    $startDate = (string)$request->data[0] . " 00:00:00";
    $startTime = strtotime($startDate);
  
    $endDate = (string)$request->data[1] . " 23:59:59";
    $endTime = strtotime($endDate);
  
    $dateRange = [$startTime, $endTime];
  
    $category = (string)$request->data[2];
    $group = (string)$request->data[3];
    $title = (string)$request->data[4];

    if($request->session()->has('rssOffset'))
    {
      $offset = (int)session('rssOffset');
    }
    else
    {
      session(['rssOffset' => 0]);
      $offset = (int)session('rssOffset');
    }

    $items = $readerModel->GetItems($dateRange, $category, $group, $title, $offset);
    $items = json_decode(json_encode($items), true);

    return view('components.RSSReader.readerList', [
      'items' => $items,
    ]);
  }

  public function OffsetPlus(Request $request)
  {
    if($request->session()->has('rssOffset'))
    {
      $offset = (int)session('rssOffset');
      $offset += 100;
      session(['rssOffset' => $offset]);
    }
    else
    {
      session(['rssOffset' => 0]);
    }

    return $this->GetRss($request);
  }

  public function OffsetMinus(Request $request)
  {
    if($request->session()->has('rssOffset'))
    {
      $offset = (int)session('rssOffset');
      if($offset > 0) $offset -= 100;
      session(['rssOffset' => $offset]);
    }
    else
    {
      session(['rssOffset' => 0]);
    }

    return $this->GetRss($request);
  }

  public function Words(Request $request)
  { 
    date_default_timezone_set("UTC");

    $startDate = (string)$request->data[0] . " 00:00:00";
    $startTime = strtotime($startDate);
  
    $endDate = (string)$request->data[1] . " 23:59:59";
    $endTime = strtotime($endDate);
  
    $dateRange = [$startTime, $endTime];
  
    $category = (string)$request->data[2];
    $group = (string)$request->data[3];
    $title = (string)$request->data[4];

    $readerModel = new ModelRSSReader();
    $wordData = $readerModel->GetWords($dateRange, $category, $group, $title);
    $wordData = json_decode(json_encode($wordData), true);
    $processedWords = $readerModel->ProcessWords($wordData);
  
    return view('components.RSSReader.readerWords', [
      'items' => $processedWords,
    ]);
  }

  public function SearchWord(Request $request)
  {
    // set offset to 0?

    date_default_timezone_set("UTC");

    $startDate = (string)$request->data[0] . " 00:00:00";
    $startTime = strtotime($startDate);
  
    $endDate = (string)$request->data[1] . " 23:59:59";
    $endTime = strtotime($endDate);
  
    $dateRange = [$startTime, $endTime];
  
    $category = (string)$request->data[2];
    $group = (string)$request->data[3];
    $title = (string)$request->data[4];

    $searchWord = (string)$request->data[5];

    $readerModel = new ModelRSSReader();

    $readerData = $readerModel->GetItemsWithSearchWord($dateRange, $category, $group, $title, $searchWord);
    $readerData = json_decode(json_encode($readerData), true);
    return view('components.RSSReader.readerList', [
      'items' => $readerData,
    ]);
  }

  public function SaveItem(Request $request)
  {
    $index = (int)$request->data[0];
    $readerModel = new ModelRSSReader();
    $returnResponse = $readerModel->SaveItem($index);
    return $returnResponse;
  }

  public function sources()
  {
    date_default_timezone_set("Europe/London");
    $model = new ModelRSSReader();
    $sourcesData = $model->GetSources();

    return view('RSSReader.rssreaderSources', [
      'sources' => $sourcesData
    ]);
  }

  public function EditSource(Request $request)
  {
    $index = (int)$request->data[0];
    $title = (string)trim($request->data[1]);
    $link = (string)trim($request->data[2]);
    $group = (string)trim($request->data[3]);
    $category = (string)trim($request->data[4]);
    $country = (string)trim($request->data[5]);

    $model = new ModelRSSReader();
    if($index === -1) $debug = $model->AddSource($title, $link, $group, $category, $country);
    else $debug = $model->UpdateSource($index, $title, $link, $group, $category, $country);

    $sourcesData = $model->GetSources();
    return view('components.RSSReader.sourceList', [
      'sources' => $sourcesData,
    ]);
  }

  public function DeleteSource(Request $request)
  {
    $index = (int)$request->data[0];

    $model = new ModelRSSReader();
    $debug = $model->DeleteSource($index);
  
    $sourcesData = $model->GetSources();
    return view('components.RSSReader.sourceList', [
      'sources' => $sourcesData,
    ]);
  }

  public function ForceUpdate(Request $request)
  {
    $cron = new CronRssReaderReadAllRss();
    $debug = $cron->ReadAllRSS();
    return $debug;
  }

  public function GetTick(Request $request)
  {
    $readerModel = new ModelRSSReader();
    date_default_timezone_set("UTC");

    $startDate = (string)$request->data[0] . " 00:00:00";
    $startTime = strtotime($startDate);
  
    $endDate = (string)$request->data[1] . " 23:59:59";
    $endTime = strtotime($endDate);
  
    $dateRange = [$startTime, $endTime];
  
    $category = (string)$request->data[2];
    $group = (string)$request->data[3];
    $title = (string)$request->data[4];

    $toggleItems = (int)$request->data[5];

    $items = $readerModel->GetRandomTick($dateRange, $category, $group, $title, $toggleItems);
    $items = json_decode(json_encode($items), true);

    return view('components.RSSReader.readerList', [
      'items' => $items,
    ]);
  }

  public function GetSaved(Request $request)
  {
    date_default_timezone_set("Europe/London");
    $model = new ModelRSSReader();
    $userID = Auth::id();

    if($request->session()->has('rssOffset'))
    {
      $offset = (int)session('rssOffset');
    }
    else
    {
      session(['rssOffset' => 0]);
      $offset = (int)session('rssOffset');
    }

    $items = $model->GetSaved($userID, $offset);
    $items = json_decode(json_encode($items), true);

    return view('components.RSSReader.profileList', [
      'items' => $items
    ]);
  }

  public function DeleteSaved(Request $request)
  {
    $index = (int)$request->data[0];
    $userID = Auth::id();

    if($request->session()->has('rssOffset'))
    {
      $offset = (int)session('rssOffset');
    }
    else
    {
      session(['rssOffset' => 0]);
      $offset = (int)session('rssOffset');
    }

    $model = new ModelRSSReader();
    $debug = $model->DeleteSaved($index);
  
    $items = $model->GetSaved($userID, $offset);
    $items = json_decode(json_encode($items), true);
    return view('components.RSSReader.profileList', [
      'items' => $items,
    ]);
  }
}