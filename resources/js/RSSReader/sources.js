"use strict";

const messageBoxHolder = document.getElementById("messageBoxHolder");
const messageBox = document.getElementById("messageBox");
messageBoxHolder.onclick = function() { TogglePanel(messageBoxHolder); };

const sDisplay = document.getElementById("sDisplay");
const sEditSource = document.getElementById("sEditSource");
const sDeleteSource = document.getElementById("sDeleteSource");

const sSort = document.getElementById("sSort");
sSort.onclick = function(){ SortSources("-"); };

// const sForce = document.getElementById("sForce");
// sForce.onclick = function() { Post("FORCE"); };

const sFind = document.getElementById("sFind");
const sNewSource = document.getElementById("sNewSource");

const sEditSourceLabel = document.getElementById("sEditSourceLabel");
const sEditSourceIndex = document.getElementById("sEditSourceIndex");
const sEditSourceTitle = document.getElementById("sEditSourceTitle");
const sEditCardSource = document.getElementById("sEditCardSource");
const sEditCardGroup = document.getElementById("sEditCardGroup");
const sEditCardCategory = document.getElementById("sEditCardCategory");
const sEditCardCountry = document.getElementById("sEditCardCountry");
const sEditSourceAdd = document.getElementById("sEditSourceAdd");
const sEditSourceClose = document.getElementById("sEditSourceClose");

const sDeleteSourceIndex = document.getElementById("sDeleteSourceIndex");
const sDeleteSourceTitle = document.getElementById("sDeleteSourceTitle");
const sDeleteSourceLink = document.getElementById("sDeleteSourceLink");
const sDeleteSourceGroup = document.getElementById("sDeleteSourceGroup");
const sDeleteSourceCategory = document.getElementById("sDeleteSourceCategory");
const sDeleteSourceCountry = document.getElementById("sDeleteSourceCountry");
const sDeleteSourceDelete = document.getElementById("sDeleteSourceDelete");
const sDeleteSourceClose = document.getElementById("sDeleteSourceClose");

sFind.onkeyup = function(){ Filter("sCard", sFind); };
sNewSource.onclick = function() { TogglePanel(sEditSource); ClearEditSource(); };

sEditSourceClose.onclick = function() { TogglePanel(sEditSource); };
sEditSourceAdd.onclick = function() { Post("SOURCE"); };

sDeleteSourceDelete.onclick = function() { Post("DELETESOURCE"); };
sDeleteSourceClose.onclick = function() { TogglePanel(sDeleteSource); };

let sortIndex = 0;
let timeOut = undefined;

TogglePanel(sEditSource);
TogglePanel(sDeleteSource);
SortSources("AZ");

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

function AutoOff()
{
  messageBoxHolder.style.display = "none";
}

function Post(trigger)
{
  let data = [];

  if(trigger === "SOURCE")
  {
    data = [
      sEditSourceIndex.value,
      sEditSourceTitle.value,
      sEditCardSource.value,
      sEditCardGroup.value,
      sEditCardCategory.value,
      sEditCardCountry.value
    ];
  }

  if(trigger === "DELETESOURCE")
  {
    data = [
      sDeleteSourceIndex.value
    ];
  }

  $.ajax(
  {
    method: "POST",
    url: "/rssreader/" + trigger,
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
      console.log(result);
      sDisplay.innerHTML = result;
      if(trigger === "SOURCE") MessageBox("Source updated.");
      if(trigger === "DELETESOURCE") MessageBox("Source deleted.");
      if(trigger === "FORCE") MessageBox(result);
      ReAssign();
    },
    error:function()
    {
      MessageBox("Error.");
    }
  });
}

function ClearEditSource()
{
  sEditSourceLabel.innerHTML = "Add Source";
  sEditSourceIndex.value = -1;
  sEditSourceTitle.value = "";
  sEditCardSource.value = "";
  sEditCardGroup.value = "";
  sEditCardCategory.value = "";
  sEditCardCountry.value = "";
}

function ModifySource(index)
{
  sEditSourceLabel.innerHTML = "Edit Source";
  sEditSourceIndex.value = index;
  sEditSourceTitle.value = document.getElementById(index + 'sCardTitle').innerHTML.trim();
  sEditCardSource.value = document.getElementById(index + 'sCardLink').innerHTML.trim();
  sEditCardGroup.value = document.getElementById(index + 'sCardGroup').innerHTML.trim();
  sEditCardCategory.value = document.getElementById(index + 'sCardCategory').innerHTML.trim();
  sEditCardCountry.value = document.getElementById(index + 'sCardCountry').innerHTML.trim();

  TogglePanel(sEditSource);
}

function DeleteSource(index)
{
  sDeleteSourceIndex.value = index;
  sDeleteSourceTitle.value = document.getElementById(index + 'sCardTitle').innerHTML.trim();
  sDeleteSourceLink.value = document.getElementById(index + 'sCardLink').innerHTML.trim();
  sDeleteSourceGroup.value = document.getElementById(index + 'sCardGroup').innerHTML.trim();
  sDeleteSourceCategory.value = document.getElementById(index + 'sCardCategory').innerHTML.trim();
  sDeleteSourceCountry.value = document.getElementById(index + 'sCardCountry').innerHTML.trim();

  TogglePanel(sDeleteSource);
}

function Filter(dataset, inputFilter)
{
  let filter, li, len, a, i;
  filter = inputFilter.value.toUpperCase();
  if(filter === "378462SDJKFHDSDBS8743247832") filter = "";
  li = document.getElementsByClassName(dataset);
  len = li.length;
  for (i = 0; i < len; i++)
  {
    if(filter === "")
    {
      li[i].style.display = "";
      continue;
    }
    a = li[i].dataset.search.toString();
    if (a.toUpperCase().indexOf(filter) > -1)
    {
      li[i].style.display = "";
    }
    else
    {
      li[i].style.display = "none";
    }
  }
}

function SortSources(sortBy)
{
  if(sortBy === "-")
  {
    sortIndex++;
    if(sortIndex > 1) sortIndex = 0;

    if(sortIndex === 0) sortBy = "AZ";
    else if(sortIndex === 1) sortBy = "ZA";
  }
  else
  {
    if(sortBy === "AZ") sortIndex = 0;
    if(sortBy === "ZA") sortIndex = 1;
  }

  let p = document.getElementsByClassName("sCard");
  if(p.length == 0) return;
  p = Array.prototype.slice.call(p, 0);

  p.sort(function(a, b)
  {
    let f1 = undefined;
    let f2 = undefined;

    if(sortBy == "AZ") // alphabetical
    {
      f1 = a.dataset.search.toUpperCase();
      f2 = b.dataset.search.toUpperCase();
    }
    else if(sortBy == "ZA") // reverse alphabetical
    {
      f1 = b.dataset.search.toUpperCase();
      f2 = a.dataset.search.toUpperCase();
    }

    if(f1 < f2) return 1, -1;
    else return -1, 1;
  });

  sDisplay.innerHTML = "";
  let pLen = p.length;
  for(let i = 0; i < pLen; i++) sDisplay.appendChild(p[i]);
}

function ReAssign()
{
  let modifysourcebutton = document.getElementsByClassName("modifysourcebutton");
  for(let i = 0; i < modifysourcebutton.length; i++)
  {
    let id = modifysourcebutton[i].dataset.i;
    modifysourcebutton[i].onclick = function() { ModifySource(id); };
  }

  let deletesourcebutton = document.getElementsByClassName("deletesourcebutton");
  for(let i = 0; i < deletesourcebutton.length; i++)
  {
    let id = deletesourcebutton[i].dataset.i;
    deletesourcebutton[i].onclick = function() { DeleteSource(id); };
  }
}

document.addEventListener("DOMContentLoaded", ReAssign);