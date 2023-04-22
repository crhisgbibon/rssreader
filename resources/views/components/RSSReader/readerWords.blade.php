<?php
  $count = count($items);
  if($count === 0) return "";
  $counter = 0;
  foreach($items as $entry)
  {
    $word = strtolower($entry["word"]);
    if($word === "") continue;
    $count = $entry["count"];

    echo "

    <div class='rWord searchwordbutton' id='{$counter}rWord' 
    data-index='{$counter}' 
    data-word='{$word}'
    data-count='{$count}'
    onclick='SearchWord(`{$word}`);'>

      <div id='{$counter}rWordWord'>
        {$word}
      </div>

      <div id='{$counter}rWordCount'>
        {$count}
      </div>

    </div>

    ";

    $counter++;
  }
?>