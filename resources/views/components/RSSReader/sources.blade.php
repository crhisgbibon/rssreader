<div id="sView">

  <div id="sOptions">
    {{-- <button class="sControlClass" id="sForce"><img id="sForce" src="{{ asset('storage/Assets/undoLight.svg') }}"></button> --}}
    <button class="sControlClass" id="sSort"><img id="sSort" src="{{ asset('storage/Assets/sortAZLight.svg') }}"></button>
    <input class="sControlClass" type="text" id="sFind" placeholder="Search...">
    <button class="sControlClass" id="sNewSource"><img id="i_sNewSource" src="{{ asset('storage/Assets/plusLight.svg') }}"></button>
  </div>
  
  <div id="sContents">

    <div id="sDisplay">
      <x-RSSReader.sourceList :sources="$sources" />
    </div>

    <div id="sEditSource">
      
      <input type="number" id="sEditSourceIndex" value="-1" disabled hidden>

      <label for="sEditSource" id="sEditSourceLabel">Edit Source</label>

      <label for="sEditSourceTitle">Title:</label>
      <input type="text" class="sEditSourceDiv" id="sEditSourceTitle">

      <label for="sEditCardSource">Link:</label>
      <input type="text" class="sEditSourceDiv" id="sEditCardSource">

      <label for="sEditCardGroup">Group:</label>
      <input type="text" class="sEditSourceDiv" id="sEditCardGroup">

      <label for="sEditCardCategory">Category:</label>
      <input type="text" class="sEditSourceDiv" id="sEditCardCategory">

      <label for="sEditCardCountry">Country:</label>
      <input type="text" class="sEditSourceDiv" id="sEditCardCountry">

      <button id="sEditSourceAdd">Submit</button>
      <button id="sEditSourceClose">Close</button>
    
    </div>

    <div id="sDeleteSource">

      <input type="number" id="sDeleteSourceIndex" value="-1" disabled hidden>

      <label for="dEditSource">Delete Source</label>

      <label for="sDeleteSourceTitle">Title:</label>
      <input type="text" class="sEditSourceDiv" id="sDeleteSourceTitle" disabled>

      <label for="sDeleteSourceLink">Link:</label>
      <input type="text" class="sEditSourceDiv" id="sDeleteSourceLink" disabled>

      <label for="sDeleteSourceGroup">Group:</label>
      <input type="text" class="sEditSourceDiv" id="sDeleteSourceGroup" disabled>

      <label for="sDeleteSourceCategory">Category:</label>
      <input type="text" class="sEditSourceDiv" id="sDeleteSourceCategory" disabled>

      <label for="sDeleteSourceCountry">Country:</label>
      <input type="text" class="sEditSourceDiv" id="sDeleteSourceCountry" disabled>

      <button id="sDeleteSourceDelete">Delete</button>

      <button id="sDeleteSourceClose">Close</button>
    
    </div>

  </div>

</div>