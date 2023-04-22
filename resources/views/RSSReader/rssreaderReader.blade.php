@vite(['resources/js/RSSReader/reader.js'])

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
      border-radius: 6px;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    #rView{
      position: fixed;
      display: flex;
      justify-content: start;
      flex-direction: column;
      width: 100%;
      height: calc(var(--vh) * 92.5);
      max-height: calc(var(--vh) * 92.5);
      margin: 0;
      padding: 0;
    }

    #rTickOptions{
      height: calc(var(--vh) * 77.5);
    }

    /* R OPTIONS */

    #rOptions{
      width: 100%;
      height: calc(var(--vh) * 7.5);
      max-height: calc(var(--vh) * 7.5);
      max-width: 1200px;
      margin: 0;
      padding: 0;
      margin-right: auto;
      margin-left: auto;
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      align-items: center;
    }

    #rOptionsTop{
      width: 100%;
      max-width: 600px;
      height: calc(var(--vh) * 7.5);
      max-height: calc(var(--vh) * 7.5);
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      align-items: center;
    }

    #rOptionsBot{
      width: 100%;
      max-width: 600px;
      height: calc(var(--vh) * 7.5);
      max-height: calc(var(--vh) * 7.5);
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      align-items: center;
    }

    #rRefresh:hover{
      background-color: var(--backgroundLight);
    }

    .rControlClass{
      width: calc(100% / 3);
      max-width: calc(100% / 3);
      height: 100%;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .rControlClass>*{
      width: 95%;
      height: 75%;
      margin: 0;
      padding: 4px;
      box-sizing: border-box;
      border: 1px solid var(--grey);
      border-radius: 6px;
    }

    .rControlClass button{
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .rControlClass button:active{
      transform: scale(90%, 90%);
    }

    /* R CONTENTS */

    #rContents{
      width: 100%;
      max-width: 1250px;
      height: calc(var(--vh) * 80);
      max-height: calc(var(--vh) * 80);
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

    .rCard{
      background-color: var(--background);
      width: 80%;
      max-width: 300px;
      border-radius: 6px;
      box-sizing: border-box;
      border: 1px solid var(--grey);
      display: flex;
      justify-content: start;
      align-items: center;
      flex-direction: column;
      float: left;
      object-fit: contain;
      margin: 4px;
      padding: 4px;
    }

    .rCardHeader{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: row;
      width: 90%;
      min-height: calc(var(--vh) * 5);
      margin: 4px;
      padding: 4px;
    }

    .rCardChannel{
      display: flex;
      justify-content: start;
      align-items: center;
      width: 100%;
      padding: 4px;
      min-height: calc(var(--vh) * 5);
      overflow: hidden;
    }

    .rCardSave{
      width: 100%;
      min-height: calc(var(--vh) * 5);
      max-width: 50px;
      max-height: 50px;
      border-radius: 6px;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 4px;
      padding: 4px;
    }

    .rCardSave button{
      width: 90%;
      height: 90%;
      max-width: 300px;
      border-radius: 6px;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .rCardSave button:hover{
      transform: scale(120%, 120%);
    }

    .rCardSave button:active{
      transform: scale(90%, 90%);
    }

    .rCardSaveButton img{
      height: 75%;
      width: 75%;
      max-height: 30px;
      max-width: 30px;
      padding: 4px;
    }

    .rCardTitle{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: row;
      width: 100%;
      min-height: calc(var(--vh) * 5);
      margin: 4px;
      padding: 4px;
    }

    .rCardTitle a{
      background-color: var(--backgroundLight);
      border-radius: 6px;
      padding: 8px;
      cursor: pointer;
    }

    .rCardTitle a:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    .rCardTitle a:active{
      transform: scale(90%, 90%);
    }

    .rCardDescription{
      width: 100%;
      min-height: calc(var(--vh) * 5);
      margin: 4px;
      padding: 4px;
    }

    .rCardDescription a{
      background-color: var(--backgroundLight);
      border-radius: 6px;
      padding: 2px;
      margin: 2px;
    }

    .rCardSummary{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      font-size: 16px;
      margin: 4px;
      padding: 4px;
      width: 80%;
      max-width: 300px;
    }

    .rCardSummary a{
      background-color: var(--backgroundLight);
      border-radius: 6px;
      padding: 8px;
      cursor: pointer;

      display: flex;
      justify-content: center;
      height: 100%;
      width: 100%;
      align-items: stretch;
      background-color: var(--backgroundLight);
      margin: 2px;
      padding: 6px;
      border-radius: 6px;
    }

    .rCardSummary a:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    .rCardSummary a:active{
      transform: scale(90%, 90%);
    }

    .rCardSummary div{
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 10px;
      margin: 2px;
      padding: 2px;
    }

    #rControls{
      height: calc(var(--vh) * 7.5);
      max-height: calc(var(--vh) * 7.5);
      width: 100%;
      margin: 0;
      padding: 0;
      margin-right: auto;
      margin-left: auto;
      display: flex;
      justify-content: space-around;
      align-items: center;
      flex-direction: row;
      box-sizing: border-box;
      border-top: 1px solid var(--grey);
    }

    #rControlsBox{
      height: calc(var(--vh) * 7.5);
      max-height: calc(var(--vh) * 7.5);
      width: 100%;
      margin: 0;
      padding: 0;
      max-width: 600px;
      margin-right: auto;
      margin-left: auto;
      display: flex;
      justify-content: space-around;
      align-items: center;
      flex-direction: row;
    }

    #rControlsBox>*{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90%;
      width: 100%;
    }

    #rControlsBox button:hover{
      background-color: var(--backgroundLight);
    }

    #rControlsBox button:active{
      transform: scale(90%, 90%);
    }

    .rWord{
      background-color: var(--backgroundLight);
      width: 80%;
      max-width: 100px;
      margin: 1%;
      padding: 1%;
      border-radius: 6px;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      float: left;
      object-fit: contain;
      cursor: pointer;
      overflow: hidden;
    }

    .rWord:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    .rWord:active{
      transform: scale(90%, 90%);
    }

    @media screen and (max-width: 640px)
    {

      #rOptions{
        flex-direction: column;
        height: calc(var(--vh) * 15);
        max-height: calc(var(--vh) * 15);
        max-width: 600px;
      }

      #rContents{
        height: calc(var(--vh) * 72.5);
        max-height: calc(var(--vh) * 72.5);
        max-width: 600px;
      }

      .rCard{
        width: 92.5%;
        max-width: 100%;
      }

      .rCardSummary{
        width: 92.5%;
        max-width: 100%;
      }

    }

    @media screen and (max-width: 300px)
    {



    }
  </style>

  <x-slot name="appTitle">
    {{ __('RSS Reader')}}
  </x-slot>

  <x-slot name="appName">
    {{ __('RSS Reader') }}
  </x-slot>

  <div id="messageBoxHolder" style="display:none;"><div id="messageBox"></div></div>

  <x-RSSReader.reader :readercategories="$readercategories" :readerchannels="$readerchannels" :readergroups="$readergroups" :items="$items" :now="$now"/>

</x-app-layout>