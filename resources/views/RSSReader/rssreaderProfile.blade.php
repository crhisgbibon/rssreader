@vite(['resources/js/RSSReader/profile.js'])

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

    
    #pOptions{
      width: 100%;
      height: calc(var(--vh) * 7.5);
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      align-items: center;
      border-bottom: 1px solid var(--grey);
    }

    #pOptions>*{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90%;
      width: 90%;
    }

    #pOptions button:hover{
      background-color: var(--backgroundLight);
    }

    #pOptions button:active{
      transform: scale(90%, 90%);
    }

    #pRefresh{
      width: 18%;
      border-radius: 12px;
    }

    #pRefresh img{
      width: 50%;
      height: 50%;
    }

    #pFind{
      width: 78%;
      border-radius: 12px;
    }

    #pContents{
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

    .pCard{
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

    .pCardHeader{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: row;
      width: 90%;
      min-height: calc(var(--vh) * 5);
      margin: 4px;
      padding: 4px;
    }

    .pCardChannel{
      display: flex;
      justify-content: start;
      align-items: center;
      width: 100%;
      padding: 4px;
      min-height: calc(var(--vh) * 5);
      overflow: hidden;
    }

    .pCardDelete{
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

    .pCardDelete button{
      width: 90%;
      height: 90%;
      max-width: 300px;
      border-radius: 6px;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .pCardDelete button:hover{
      transform: scale(120%, 120%);
    }

    .pCardDelete button:active{
      transform: scale(90%, 90%);
    }

    .pCardDeleteButton img{
      height: 75%;
      width: 75%;
      max-height: 30px;
      max-width: 30px;
      padding: 4px;
    }

    .pCardTitle{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: row;
      width: 100%;
      min-height: calc(var(--vh) * 5);
      margin: 4px;
      padding: 4px;
    }

    .pCardTitle a{
      background-color: var(--backgroundLight);
      border-radius: 6px;
      padding: 8px;
      cursor: pointer;
    }

    .pCardTitle a:hover{
      background-color: var(--foreground);
      color: var(--background);
    }

    .pCardTitle a:active{
      transform: scale(90%, 90%);
    }

    .pCardDescription{
      width: 100%;
      min-height: calc(var(--vh) * 5);
      margin: 4px;
      padding: 4px;
    }

    @media screen and (max-width: 640px)
    {

      #pContents{
        height: calc(var(--vh) * 72.5);
        max-height: calc(var(--vh) * 72.5);
        max-width: 600px;
      }

      .pCard{
        width: 92.5%;
        max-width: 100%;
      }

    }

    @media screen and (max-width: 300px)
    {

    }
  </style>
  <x-slot name="appTitle">
    {{ __('RSS Profile')}}
  </x-slot>

  <x-slot name="appName">
    {{ __('RSS Profile') }}
  </x-slot>

  <div id="messageBoxHolder" style="display:none;"><div id="messageBox"></div></div>

  <x-RSSReader.profile :items="$items" />

</x-app-layout>