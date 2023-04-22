<div id="pView">

  <div id="pOptions">
    <button class="pControlClass" id="pRefresh"><img id="i_pRefresh" src={{ asset('storage/Assets/undoLight.svg') }}></button>
    <input class="pControlClass" type="text" id="pFind" placeholder="Search...">
  </div>

  <div id="pContents">
    <x-RSSReader.profileList :items="$items" />
  </div>
  
</div>