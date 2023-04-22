"use strict";

const messageBox = document.getElementById("messageBox");

const pContents = document.getElementById("pContents");
const pRefresh = document.getElementById("pRefresh");
const pFind = document.getElementById("pFind");

messageBox.onclick = function() { TogglePanel(messageBox); };

pRefresh.onclick = function() { Post("GETSAVED"); };
pFind.onkeyup = function(){ Filter("pCard", pFind); };

let deleteIndex = 0;
let timeOut = undefined;

TogglePanel(messageBox);

function TogglePanel(panel)
{
  if(panel.style.display == "none") panel.style.display = "";
  else panel.style.display = "none";
}

function MessageBox(message)
{
  messageBox.innerHTML = message;
  if(messageBox.style.display === "none") TogglePanel(messageBox);
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
  messageBox.style.display = "none";
}

function Post(trigger)
{
  let data = [];

  if(trigger === "DELETESAVED")
  {
    data = [
      deleteIndex
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
    timeout: 10000,
    success:function(result)
    {
      pContents.innerHTML = result;
    },
    error:function(result)
    {
    }
  });
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

function DeleteItem(index)
{
  if(confirm("Delete Item?") === true)
  {
    deleteIndex = index;
    Post("DELETESAVED");
  }
}

function ReAssign()
{
  let deleteitembutton = document.getElementsByClassName("deleteitembutton");
  for(let i = 0; i < deleteitembutton.length; i++)
  {
    let id = deleteitembutton[i].dataset.i;
    deleteitembutton[i].onclick = function() { DeleteItem(id); };
  }
}

document.addEventListener("DOMContentLoaded", ReAssign);