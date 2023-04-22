<div id="rView">

  <div id="rOptions">
    <div id="rOptionsTop">
      <div class="rControlClass">
        <select id="rOptionsCategory">
          <?php 
            $count = count($readercategories);
            echo "
                <option value=-1>Show All</option>
              ";
            for($i = 0; $i < $count; $i++)
            {
              $title = $readercategories[$i]["category"];
              echo "
                <option value='{$title}'>{$title}</option>
              ";
            }
          ?>
        </select>
      </div>
      <div class="rControlClass rControlCentre">
        <select id="rOptionsGroup">
          <?php 
            $count = count($readergroups);
            echo "
                <option value='-1'>Show All</option>
              ";

            for($i = 0; $i < $count; $i++)
            {
              $title = $readergroups[$i]["groupName"];
              echo "
                <option value='{$title}'>{$title}</option>
              ";
            }
          ?>
        </select>
      </div>
      <div class="rControlClass">
        <select id="rOptionsTitle">
          <?php 
            $count = count($readerchannels);
            echo "
                <option value=-1>Show All</option>
              ";

            for($i = 0; $i < $count; $i++)
            {
              $title = $readerchannels[$i]["sourceTitle"];
              echo "
                <option value='{$title}'>{$title}</option>
              ";
            }
          ?>
        </select>
      </div>
    </div>
    <div id="rOptionsBot">
      <div class="rControlClass">
        <input type="date" id="rOptionsStart" value="<?php echo date("Y-m-d", $now); ?>">
      </div>
      <div class="rControlClass rControlCentre">
        <input type="date" id="rOptionsEnd" value="<?php echo date("Y-m-d", $now); ?>">
      </div>
      <div class="rControlClass">
        <button id="rRefresh"><img id="i_rRefresh" src="{{ asset('storage/Assets/searchLight.svg') }}"></button>
      </div>
    </div>
  </div>

  <div id="rContents">
    <x-RSSReader.readerList :items="$items" />
  </div>

  <div id="rTickOptions" class="fixed z-10 bg-white flex w-full flex-col justify-start mx-auto overflow-y-auto">
    <div class="mx-auto my-4 font-bold">
      <label for="display000" class="mr-8">Ticker options</label>
    </div>
    <div class="mx-auto my-4">
      <label for="display001" class="mr-8">Tick frequency (s):</label>
      <input type="number" id="display001" name="display001" class="text-center w-24 rounded" min=1 max=30 step=1 value=5>
    </div>
    <div class="mx-auto my-4">
      <label for="autonew" class="mr-8">Tick items:</label>
      <input type="number" id="display002" name="display002" class="text-center w-24 rounded" min=1 max=10 step=1 value=3>
    </div>
  </div>

  <div id="rControls">
    <div id="rControlsBox">
      <button id='rLast100'><img src="{{ asset('storage/Assets/chevronLeftLight.svg') }}"></button>
      <button id='rHeadline'><img id="i_rHeadline" src="{{ asset('storage/Assets/eyeLight.svg') }}"></button>
      <button id='rTicker'><img id="i_rTicker" src="{{ asset('storage/Assets/playCircledLight.svg') }}"></button>
      <button id='rTickToggle'><img id="i_rOptions" src="{{ asset('storage/Assets/optionsLight.svg') }}"></button>
      <button id='rWords'><img id="i_rWords" src="{{ asset('storage/Assets/leaderboardLight.svg') }}"></button>
      <button id='rNext100'><img src="{{ asset('storage/Assets/chevronRightLight.svg') }}"></button>
    </div>
  </div>

</div>