<?php 
  $count = count($items);
  for($i = 0; $i < $count; $i++)
  {
    $index = $items[$i]["uniqueIndex"];
    $sourceID = $items[$i]["sourceID"];
    $itemTitle = $items[$i]["itemTitle"];
    $itemLink = $items[$i]["itemLink"];
    $itemDescription = $items[$i]["itemDescription"];

    $saveDate = $items[$i]["saveDate"];

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

      <div class='pCard' id='{$index}pCard' data-search='{$itemTitle}' data-index='{$index}' data-date='{$itemDate}' data-source='{$sourceID}'>

        <div id='{$index}pCardHeader' class='pCardHeader'>

          <div id='{$index}pCardChannel' class='pCardChannel'>
            {$channelTitle}
          </div>

          <div id='{$index}pCardDelete' class='pCardDelete'>
            <button class='pCardDeleteButton deleteitembutton' data-i={$index}><img src=' " . asset('storage/Assets/eraseLight.svg') . " '></button>
          </div>

        </div>

        <div id='{$index}rCardDate'>
          {$itemDate}
        </div>

        <div id='{$index}pCardTitle' class='pCardTitle'>
          <a href={$itemLink} target='_blank' rel='noopener'>{$itemTitle}</a>
        </div>

        $itemDescriptionElement

      </div>

    ";
  }
?>