<?php
  $count = count($items);
  if($count === 0)
  {
    echo "No data found.";
    return;
  }
  for($i = 0; $i < $count; $i++)
  {
    $index = $items[$i]["uniqueIndex"];
    $sourceID = $items[$i]["sourceID"];
    $itemTitle = $items[$i]["itemTitle"];
    $itemLink = $items[$i]["itemLink"];
    $itemDescription = $items[$i]["itemDescription"];

    $channelTitle = $items[$i]["channelTitle"];

    if (strlen($channelTitle) > 50) $channelTitle = substr($channelTitle, 0, 50) . '...';

    date_default_timezone_set("Europe/London");

    $itemDate = date("H:i:s d/m/Y", (int)$items[$i]["itemDate"]);

    $itemDescriptionElement = "";

    if($itemDescription !== "")
    {
      $itemDescriptionElement = "<div id='{$index}rCardDescription' class='rCardDescription'>
          {$itemDescription}
        </div>";
    }

    echo "

      <div class='rCard' id='{$index}rCard' data-index='{$index}' data-date='{$itemDate}' data-source='{$sourceID}'>

        <div id='{$index}rCardHeader' class='rCardHeader'>

          <div id='{$index}rCardChannel' class='rCardChannel'>
            {$channelTitle}
          </div>

          <div id='{$index}rCardSave' class='rCardSave'>
            <button class='rCardSaveButton saveitembutton' data-i={$index}><img src=' " . asset('storage/Assets/saveLight.svg') . " '></button>
          </div>

        </div>

        <div id='{$index}rCardDate'>
          {$itemDate}
        </div>

        <div id='{$index}rCardTitle' class='rCardTitle'>
          <a href={$itemLink} target='_blank' rel='noopener'>{$itemTitle}</a>
        </div>

        $itemDescriptionElement

      </div>

      <div style='display:none;' class='rCardSummary' id='{$index}rCardSummary'>
        <a href={$itemLink} target='_blank' rel='noopener'>{$itemTitle}</a>
        <div>{$channelTitle} / {$itemDate}</div>
      </div>
    ";
  }
?>