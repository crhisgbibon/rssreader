<?php

namespace App\Http\Controllers\RSSReader;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\RSSReader\ModelRSSReader;
use App\Models\RSSReader\CronRssReaderReadAllRss;

use Illuminate\Support\Facades\Session;

class ControllerRSSReader extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function constructor()
  {
    if(!session()->has('rssOffset'))
    {
      session(['rssOffset' => 0]);
    }
  }

  public function index(Request $request)
  {
    date_default_timezone_set("UTC");
    $startTime = strtotime('-1 week');
    $endTime = strtotime('today');
    $dateRange = [$startTime, $endTime];

    $category = "-1";
    $group = "-1";
    $title = "-1";
    $offset = (int)session('rssOffset');

    $model = new ModelRSSReader();

    $readerCategories = $model->GetCategoryNames();
    $readerChannels = $model->GetChannelNames();
    $readerGroups = $model->GetGroupNames();

    $items = $model->GetItems($dateRange, $category, $group, $title, $offset);
    $items = json_decode(json_encode($items), true);
    $count = count($items);
    $itemRange = json_encode([
      'offset' =>$offset, 
      'count' => $count
    ]);

    $now = time();

    return view('RSSReader.rssreaderReader', [
      'items' => $items,
      'readercategories' => $readerCategories,
      'readerchannels' => $readerChannels,
      'readergroups' => $readerGroups,
      'now' => $now,
      'weekago' => $startTime,
      'range' => $itemRange,
    ]);
  }

  public function profile(Request $request)
  {
    date_default_timezone_set("Europe/London");
    $model = new ModelRSSReader();
    $userID = Auth::id();

    $offset = (int)session('rssOffset');

    $items = $model->GetSaved($userID, $offset);
    $items = json_decode(json_encode($items), true);
    $count = count($items);
    $itemRange = json_encode([
      'offset' =>$offset, 
      'count' => $count
    ]);

    return view('RSSReader.rssreaderProfile', [
      'items' => $items,
      'range' => $itemRange,
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

    $offset = (int)session('rssOffset');

    $items = $readerModel->GetItems($dateRange, $category, $group, $title, $offset);
    $items = json_decode(json_encode($items), true);
    $count = count($items);
    $itemRange = json_encode([
      'offset' =>$offset, 
      'count' => $count
    ]);

    return view('components.RSSReader.readerList', [
      'items' => $items,
      'range' => $itemRange,
    ]);
  }

  public function OffsetPlus(Request $request)
  {
    $offset = (int)session('rssOffset');
    $offset += 100;
    session(['rssOffset' => $offset]);

    return $this->GetRss($request);
  }

  public function OffsetMinus(Request $request)
  {
    $offset = (int)session('rssOffset');
    if($offset > 0) $offset -= 100;
    if($offset < 0) $offset = 0;
    session(['rssOffset' => $offset]);

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
    $count = count($items);
    $offset = (int)session('rssOffset');
    $itemRange = json_encode([
      'offset' =>$offset, 
      'count' => $count
    ]);

    return view('components.RSSReader.readerList', [
      'items' => $readerData,
      'range' => $itemRange,
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
    if(!Gate::allows('access_admin')) abort(403);
    date_default_timezone_set("Europe/London");
    $model = new ModelRSSReader();
    $sourcesData = $model->GetSources();

    return view('RSSReader.rssreaderSources', [
      'sources' => $sourcesData
    ]);
  }

  public function EditSource(Request $request)
  {
    if(!Gate::allows('access_admin')) abort(403);
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
    if(!Gate::allows('access_admin')) abort(403);
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
    if(!Gate::allows('access_admin')) abort(403);
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
    $count = count($items);
    $offset = (int)session('rssOffset');
    $itemRange = json_encode([
      'offset' =>$offset, 
      'count' => $count
    ]);

    return view('components.RSSReader.readerList', [
      'items' => $items,
      'range' => $itemRange,
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

  public function TEST()
  {
    if(!Gate::allows('access_admin')) abort(403);
    $job = new CronRssReaderReadAllRss();
    $debug = $job->ReadAllRSS();
    return $debug;
  }
}