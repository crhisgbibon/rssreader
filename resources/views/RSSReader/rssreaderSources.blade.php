@vite(['resources/js/RSSReader/sources.js'])

<x-app-layout>

  <style>
    :root {
      --grey: rgba(226, 232, 237, 1);
      --white: rgba(255, 255, 255, 1);

      --green: rgba(100, 175, 100, 1);
      --yellow:rgba(175, 175, 100, 1);
      
      --disabled: rgba(150, 150, 150, 1);
      --active: rgba(255, 255, 255, 1);
      --selected: rgba(225, 225, 225, 1);
      
      --seeThrough: rgba(0, 0, 0, 0);

      --background: var(--white);
      --foreground: var(--foregroundLight);

      --buttonBackground: var(--buttonBackgroundLight);
      --buttonBorder: var(--buttonBorderLight);

      --selected: rgba(150, 150, 150, 1);

      --input: rgba(240, 240, 240, 1);

      --hyperlink: var(--hyperlinkLight);

      --backgroundDark: rgba(50,50,50,1);
      --backgroundLight: rgba(226, 232, 237, 1);

      --foregroundDark: rgba(255, 255, 255, 1);
      --foregroundLight: rgba(50, 50, 50, 1);

      --buttonBackgroundDark: rgba(75,75,75,1);
      --buttonBackgroundLight: rgba(225, 225, 225, 1);

      --buttonBorderDark: rgba(225, 225, 225, 1);
      --buttonBorderLight: rgba(75,75,75,1);

      --hyperlinkDark: rgb(255, 247, 173);
      --hyperlinkLight: rgb(3, 38, 145);

      --progressBackground: rgba(255, 241, 118, 0.1);
      --progressBar: rgba(255, 241, 118, 1);
    }

    #messageBoxHolder{
      position: absolute;
      z-index: 10;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      height: calc(var(--vh) * 10);
      bottom: calc(var(--vh) * 20);
    }

    #messageBox{
      background-color: var(--foreground);
      color: var(--background);
      width: 100%;
      max-width: 300px;
      height: 100%;
      max-height: 100px;
      border-radius: 12px;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #sView{
      position: fixed;
      display: flex;
      justify-content: start;
      flex-direction: column;
      width: 100%;
      height: calc(var(--vh) * 85);
      max-height: calc(var(--vh) * 85);
      margin: 0;
      padding: 0;
    }

    #sOptions{
      width: 100%;
      height: calc(var(--vh) * 7.5);
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      align-items: center;
      border-bottom: 1px solid var(--grey);
    }

    #sOptions>*{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90%;
      width: 90%;
    }

    #sOptions button:hover{
      background-color: var(--backgroundLight);
    }

    #sOptions button:active{
      transform: scale(90%, 90%);
    }

    #sSort{
      width: 18%;
      border-radius: 12px;
    }

    #sSort img{
      width: 50%;
      height: 50%;
    }

    #sForce{
      width: 18%;
      border-radius: 12px;
    }

    #sFind{
      width: 60%;
      border-radius: 12px;
    }

    #sNewSource{
      width: 18%;
      border-radius: 12px;
    }

    #sNewSource img{
      width: 50%;
      height: 50%;
    }

    #sContents{
      width: 100%;
      height: calc(var(--vh) * 82.5);
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      align-content: center;
    }

    /* S CONTENTS */

    #sDisplay{
      width: 100%;
      max-width: 1250px;
      height: calc(var(--vh) * 82.5);
      max-height: calc(var(--vh) * 82.5);
      margin: 0;
      padding: 0;
      margin-right: auto;
      margin-left: auto;
      overflow-y: scroll;
      display: flex;
      justify-content: center;
      align-content: flex-start;
      align-items: stretch;
      flex-direction: row;
      flex-wrap: wrap;
    }

    .sCard{
      background-color: var(--background);
      min-height: calc(var(--vh) * 15);
      width: 80%;
      max-width: 300px;
      border-radius: 12px;
      box-sizing: border-box;
      border: 1px solid var(--grey);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-direction: column;
      float: left;
      object-fit: contain;
      margin: 4px;
      padding: 4px;
    }

    .sCardTitle{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: row;
      width: 90%;
      min-height: calc(var(--vh) * 5);
      margin: 4px;
      padding: 4px;
    }

    .sCardLink{
      background-color: var(--backgroundLight);
      min-height: calc(var(--vh) * 5);
      width: 90%;
      border-radius: 12px;
      margin: 4px;
      padding: 12px;
      cursor: pointer;
      overflow: hidden;
      white-space: nowrap;
      display: flex;
      justify-content: start;
      align-items: center;
    }

    .sCardLink:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    .sCardLink:active{
      transform: scale(90%, 90%);
    }

    .sCardGroupCategoryCountry{
      min-height: calc(var(--vh) * 5);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-direction: row;
      font-size: 16px;
      margin: 4px;
      padding: 4px;
      width: 90%;
      max-width: 300px;
      overflow: hidden;
    }

    .sState{
      height: 100%;
      width: 100%;
      max-width: 32px;
      max-height: 32px;
      background-color: var(--backgroundLight);
      border-radius: 12px;
    }

    .sButtonDiv{
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: space-evenly;
      align-items: center;
      flex-direction: row;
      min-height: calc(var(--vh) * 5);
      max-height: calc(var(--vh) * 7.5);
    }

    .sButton{
      background-color: var(--backgroundLight);
      width: 100%;
      height: 90%;
      max-width: 70px;
      border-radius: 12px;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .sButton:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    .sButton:active{
      transform: scale(90%, 90%);
    }

    /* S EDIT */

    #sEditSource{
      z-index: 1;
      position: fixed;
      background-color: var(--background);
      width: 100%;
      height: calc(var(--vh) * 75);
      max-height: calc(var(--vh) * 75);
      margin: 4px;
      padding: 4px;
      overflow-y: scroll;
      display: flex;
      justify-content: start;
      align-items: center;
      flex-direction: column;
    }

    #sEditSource label{
      width: 100%;
      height: calc(var(--vh) * 7.5);
      max-width: 300px;
      max-height: 50px;
      margin: 2px;
      padding: 2px;
      outline: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .sEditSourceDiv{
      width: 80%;
      height: calc(var(--vh) * 7.5);
      max-width: 300px;
      max-height: 50px;
      margin: 4px;
      padding: 4px;
      border: 1px solid var(--grey);
      border-radius: 12px;
      outline: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #sEditSource button{
      background-color: var(--backgroundLight);
      width: 100%;
      height: 90%;
      border-radius: 12px;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      align-items: center;
      max-width: 300px;
      max-height: 50px;
      margin: 8px;
      padding: 4px;
    }

    #sEditSource button:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    #sEditSource button:active{
      transform: scale(90%, 90%);
    }

    /* S DELETE */

    #sDeleteSource{
      z-index: 1;
      position: fixed;
      background-color: var(--background);
      width: 100%;
      height: calc(var(--vh) * 75);
      max-height: calc(var(--vh) * 75);
      margin: 4px;
      padding: 4px;
      overflow-y: scroll;
      display: flex;
      justify-content: start;
      align-items: center;
      flex-direction: column;
    }

    #sDeleteSource label{
      width: 100%;
      height: calc(var(--vh) * 7.5);
      max-width: 300px;
      max-height: 50px;
      margin: 2px;
      padding: 2px;
      outline: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #sDeleteSource button{
      background-color: var(--backgroundLight);
      width: 100%;
      height: 90%;
      border-radius: 12px;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      align-items: center;
      max-width: 300px;
      max-height: 50px;
      margin: 8px;
      padding: 4px;
    }

    #sDeleteSource button:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    #sDeleteSource button:active{
      transform: scale(90%, 90%);
    }

    @media screen and (max-width: 300px)
    {

      .sButtonDiv{
        flex-direction: column;
      }

    }

    @media screen and (max-width: 640px)
    {

      .sCard{
        width: 92.5%;
        max-width: 100%;
      }

    }
  </style>

  <x-slot name="appTitle">
    {{ __('RSS Sources')}}
  </x-slot>

  <x-slot name="appName">
    {{ __('RSS Sources') }}
  </x-slot>

  <div id="messageBoxHolder" style="display:none;"><div id="messageBox"></div></div>

  <x-RSSReader.sources :sources="$sources" />

</x-app-layout>