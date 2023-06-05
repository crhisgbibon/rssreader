"use strict";

const messageBoxHolder = document.getElementById("messageBoxHolder");
const messageBox = document.getElementById("messageBox");
messageBoxHolder.onclick = function() { TogglePanel(messageBoxHolder); };

const HIDE_FILTERS = document.getElementById('HIDE_FILTERS');
HIDE_FILTERS.onclick = function(){

  if(rOptions.style.display === '')
  {
    rOptions.style.display = 'none';
    rContents.style.height = 'calc(var(--vh) * 87.5';
    rContents.style.maxHeight = 'calc(var(--vh) * 87.5';
  }
  else
  {
    rOptions.style.display = '';
    rContents.style.height = 'calc(var(--vh) * 80';
    rContents.style.maxHeight = 'calc(var(--vh) * 80';
  }

};

const rOptions = document.getElementById('rOptions');
const rOptionsCategory = document.getElementById("rOptionsCategory");
const rOptionsGroup = document.getElementById("rOptionsGroup");
const rOptionsTitle = document.getElementById("rOptionsTitle");

const rOptionsStart = document.getElementById("rOptionsStart");
const rOptionsEnd = document.getElementById("rOptionsEnd");
const rRefresh = document.getElementById("rRefresh");

const rContents = document.getElementById("rContents");

const rItemCount = document.getElementById('rItemCount');

const rTickOptions = document.getElementById("rTickOptions");

const display001 = document.getElementById("display001");
display001.onchange = function()
{
  toggleTime = display001.value;
  if(toggleTime < 1)
  {
    toggleTime = 1;
    display001.value = 1;
  }
};
const display002 = document.getElementById("display002");
display002.onchange = function()
{
  toggleItems = display002.value;
  if(toggleItems < 1)
  {
    toggleItems = 1;
    display002.value = 1;
  }
};

const rHeadline = document.getElementById("rHeadline");
const rTicker = document.getElementById("rTicker");
const rTickToggle = document.getElementById("rTickToggle");
const rWords = document.getElementById("rWords");
const i_rTicker = document.getElementById("i_rTicker");

const rLast100 = document.getElementById("rLast100");
const rNext100 = document.getElementById("rNext100");

let rCards = document.getElementsByClassName("rCard");
const rSummaries = document.getElementsByClassName("rCardSummary");

rRefresh.onclick = function() { if(ticker) { EndTicker(true); } else Post("GETRSS"); };

rHeadline.onclick = function() { if(ticker) { EndTicker(true); headlines = false; Headlines(); } else ToggleHeadlines(); };
rTicker.onclick = function() { ToggleTicker(); };
rTickToggle.onclick = function() { ToggleSettings(); };
rWords.onclick = function() { if(ticker) { EndTicker(false); Post("WORDS"); } else Post("WORDS"); };

rLast100.onclick = function() { if(ticker) { EndTicker(false); Post("OFFSETMINUS"); } else Post("OFFSETMINUS"); };
rNext100.onclick = function() { if(ticker) { EndTicker(false); Post("OFFSETPLUS"); } else Post("OFFSETPLUS"); };

TogglePanel(rTickOptions);

let showIndex = -1;
let updateIndex = -1;
let searchWord = "";
let saveIndex = -1;
let deleteIndex = -1;
let progressBar = 0;

let headlines = false;
let timeOut = undefined;

let ticker = false;
let toggleTick = false;
let tickIndex = 0;
let toggleSettings = false;
let toggleItems = 3;
let toggleTime = 5;

function AnimatePop(panel)
{
  panel.animate([
    { transform: 'scale(110%, 110%)'},
    { transform: 'scale(109%, 109%)'},
    { transform: 'scale(108%, 108%)'},
    { transform: 'scale(107%, 107%)'},
    { transform: 'scale(106%, 106%)'},
    { transform: 'scale(105%, 105%)'},
    { transform: 'scale(104%, 104%)'},
    { transform: 'scale(103%, 103%)'},
    { transform: 'scale(102%, 102%)'},
    { transform: 'scale(101%, 101%)'},
    { transform: 'scale(100%, 100%)'}],
    {
      duration: 100,
    }
  );
}

function ToggleSettings()
{
  toggleSettings = !toggleSettings;
  if(toggleSettings) rTickOptions.style.display = "";
  else rTickOptions.style.display = "none";
}

function Post(trigger)
{
  let data = [];

  if(trigger === "GETRSS" ||
  trigger === "OFFSETPLUS" ||
  trigger === "OFFSETMINUS" ||
  trigger === "WORDS")
  {
    data = [
      rOptionsStart.value,
      rOptionsEnd.value,

      rOptionsCategory.value,
      rOptionsGroup.value,
      rOptionsTitle.value
    ];
  }
  if(trigger === "SEARCHWORD")
  {
    data = [
      rOptionsStart.value,
      rOptionsEnd.value,

      rOptionsCategory.value,
      rOptionsGroup.value,
      rOptionsTitle.value,
      searchWord
    ];
  }
  if(trigger === "SAVEITEM")
  {
    data = [
      saveIndex
    ];
  }

  $.ajax(
  {
    method: "POST",
    url: trigger,
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      data:data
    },
    timeout: 10000,
    success:function(result)
    {
      if(trigger === "GETRSS" ||
      trigger === "OFFSETPLUS" ||
      trigger === "OFFSETMINUS" ||
      trigger === "WORDS"||
      trigger === "SEARCHWORD")
      {
        rContents.innerHTML = result;
        if(headlines) Headlines();
        ReAssign();
        if(trigger === "GETRSS" ||
           trigger === "OFFSETPLUS" ||
           trigger === "OFFSETMINUS")
        {
          let newOffset = document.getElementById('OFFSET_DATA').dataset.offset;
          rItemCount.innerHTML = newOffset;
        }
      }
      if(trigger === "SAVEITEM")
      {
        MessageBox(result);
      }
    },
    error:function()
    {
      if(trigger === "SAVEITEM")
      {
        MessageBox('You must be logged in to save items.');
      }
    }
  });
}

function ToggleHeadlines()
{
  headlines = !headlines;
  if(headlines) rHeadline.dataset.state = "selected";
  else rHeadline.dataset.state = "";
  Headlines();
}

function Headlines()
{
  rCards = document.getElementsByClassName("rCard");
  let count = rCards.length;
  for(let i = 0; i < count; i++)
  {
    let index = rCards[i].dataset.index;
    let card = document.getElementById(index + "rCard");
    let summary = document.getElementById(index + "rCardSummary");

    if(headlines)
    {
      card.style.display = "none";
      summary.style.display = "";
    }
    else
    {
      card.style.display = "";
      summary.style.display = "none";
    }
  }
}

function SearchWord(word)
{
  searchWord = word;
  Post("SEARCHWORD");
}

function SaveItem(index)
{
  saveIndex = index;
  Post("SAVEITEM");
}

function TogglePanel(panel)
{
  if(panel.style.display == "none") panel.style.display = "";
  else panel.style.display = "none";
}

function MessageBox(message)
{
  messageBox.innerHTML = message;
  if(messageBoxHolder.style.display === "none")
  {
    TogglePanel(messageBoxHolder);
  }
  AnimatePop(messageBox);
  if(timeOut != null) clearTimeout(timeOut);
  timeOut = setTimeout(AutoOff, 2500);
}

function AutoOff()
{
  messageBoxHolder.style.display = "none";
}

function ToggleTicker()
{
  toggleTick = !toggleTick;
  if(toggleTick)
  {
    headlines = true;
    i_rTicker.src = "storage/Assets/playPauseLight.svg";
    Tick();
    ticker = setInterval(Tick, ( toggleTime * 1000 ) );
  }
  else
  {
    headlines = false;
    EndTicker();
    Post("GETRSS");
  }
}

function EndTicker(terminate)
{
  toggleTick = false;
  i_rTicker.src = "storage/Assets/playCircledLight.svg";
  clearInterval(ticker);
  ticker = null;
  if(terminate) Post("GETRSS");
}

function Tick()
{
  let data = [
    rOptionsStart.value,
    rOptionsEnd.value,

    rOptionsCategory.value,
    rOptionsGroup.value,
    rOptionsTitle.value,
    toggleItems
  ];

  $.ajax(
  {
    method: "POST",
    url: "TICK",
    headers:
    {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:
    {
      data:data
    },
    success:function(result)
    {
      rContents.innerHTML = result;
      let newOffset = document.getElementById('OFFSET_DATA').dataset.offset;
      rItemCount.innerHTML = newOffset;
      Headlines();
      AnimateFromRight(rContents);
      ReAssign();
    },
    error:function()
    {
    }
  });
}

function AnimateFromRight(panel)
{
  panel.animate([
    { transform: 'translateX(+100%)', opacity: '0' },
    { transform: 'translateX(+90%)',  opacity: '0' },
    { transform: 'translateX(+80%)',  opacity: '0' },
    { transform: 'translateX(+70%)',  opacity: '0' },
    { transform: 'translateX(+60%)',  opacity: '0' },
    { transform: 'translateX(+50%)',  opacity: '0' },
    { transform: 'translateX(+40%)',  opacity: '0' },
    { transform: 'translateX(+30%)',  opacity: '0.2' },
    { transform: 'translateX(+20%)',  opacity: '0.5' },
    { transform: 'translateX(+10%)',  opacity: '0.8' },
    { transform: 'translateX(0)', opacity: '1' }
      ], { 
    duration: 500,
 });
}

function ReAssign()
{
  let saveitembutton = document.getElementsByClassName("saveitembutton");
  for(let i = 0; i < saveitembutton.length; i++)
  {
    let id = saveitembutton[i].dataset.i;
    saveitembutton[i].onclick = function() { SaveItem(id); };
  }

  let searchwordbutton = document.getElementsByClassName("searchwordbutton");
  for(let i = 0; i < searchwordbutton.length; i++)
  {
    let word = searchwordbutton[i].dataset.word;
    searchwordbutton[i].onclick = function() { SearchWord(word); };
  }
}

document.addEventListener("DOMContentLoaded", ReAssign);