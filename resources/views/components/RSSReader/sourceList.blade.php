<?php 
  $count = count($sources);
  date_default_timezone_set("Europe/London");
  for($i = 0; $i < $count; $i++)
  {
    $index = $sources[$i]["uniqueIndex"];
    $title = $sources[$i]["sourceTitle"];
    $link = $sources[$i]["sourceLink"];
    $group = $sources[$i]["groupName"];
    $category = $sources[$i]["category"];
    $country = $sources[$i]["country"];
    $updatedAt = $sources[$i]["updated_at"];
    $gmDate = date("d-m H:i", $updatedAt);

    echo "

      <div class='sCard'
      id='{$index}sCard'
      data-index='{$index}'
      data-search='{$title}'>

        <div id='{$index}sCardTitle' class='sCardTitle'>
          {$title}
        </div>

        <a id='{$index}sCardLink' class='sCardLink' href={$link} target='_blank' >
          {$link}
        </a>

        <div class='sCardGroupCategoryCountry'>
          <div id='{$index}sCardCategory'>
            {$category}
          </div>

          <div id='{$index}sCardGroup'>
            {$group}
          </div>
        </div>

        <div class='sCardGroupCategoryCountry'>
          <div id='{$index}sCardCountry'>
            {$country}
          </div>

          <div id='{$index}sCardUpdated'>
            {$gmDate}
          </div>
        </div>

        <div class='sButtonDiv'>

          <button class='sButton modifysourcebutton' data-i={{$index}}>Modify</button>

          <button class='sButton deletesourcebutton' data-i={{$index}}>Delete</button>

        </div>

      </div>
    ";
  }
  ?>