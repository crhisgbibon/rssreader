<nav x-data="{ open: false }" class="bg-white">
  <!-- Primary Navigation Menu -->
  <div class="mx-auto w-full">

    <div class="flex flex-row items-center align-center w-full bg-white border-b border-gray-100 justify-between sm:justify-center " style="min-height:calc(var(--vh) * 7.5)">

      <!-- Navigation Links -->
      <div class="hidden sm:flex min-w-40 w-1/3 ml-2 h-full justify-center items-center">
        <x-nav-link :href="url('/')" class="h-full" :active="request()->routeIs('/')" style="min-height:calc(var(--vh) * 7.5)">
          {{ __('RSSReader') }} 
        </x-nav-link>
      </div>

      <div class="flex w-full max-w-6xl flex-row justify-center align-center mx-auto" style="height:calc(var(--vh) * 7.5);max-height:calc(var(--vh) * 7.5)">
        <x-nav-link :href="route('rssreaderreader')" class="flex justify-center items-center mx-4" :active="request()->routeIs('rssreaderreader')">
          <img class="w-11/12 h-11/12" src="{{ asset('storage/Assets/listLight.svg') }}">
        </x-nav-link>
        <x-nav-link :href="route('rssreaderprofile')" class="flex justify-center items-center mx-4" :active="request()->routeIs('rssreaderprofile')">
          <img class="w-11/12 h-11/12" src="{{ asset('storage/Assets/saveLight.svg') }}">
        </x-nav-link>

        @if (request()->routeIs('rssreaderreader'))

          <x-nav-link class="flex justify-center items-center mx-4 cursor-pointer" id='HIDE_FILTERS'>
            <img class="w-11/12 h-11/12" src="{{ asset('storage/Assets/eyeLight.svg') }}">
          </x-nav-link>

        @endif

        @can('access_admin')
          <x-nav-link :href="route('rssreadersources')" class="flex justify-center items-center mx-4" :active="request()->routeIs('rssreadersources')">
            <img class="w-11/12 h-11/12" src="{{ asset('storage/Assets/databaseLight.svg') }}">
          </x-nav-link>
        @endcan

      </div>

      <!-- Settings Dropdown -->
      <div class="hidden sm:flex sm:items-center sm:h-full justify-center items-center mr-2 w-1/3">
        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
              
              @auth
                <div class="truncate">{{ Auth::user()->name }}</div>
              @else
                <div>{{ __('Account') }}</div>
              @endauth

              <div class="ml-1">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </div>
            </button>
          </x-slot>

          @auth

          <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">
              {{ __('Profile') }}
            </x-dropdown-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
              @csrf

              <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
              </x-dropdown-link>
            </form>
          </x-slot>

          @else

          <x-slot name="content">
            <x-dropdown-link :href="route('login')">
                {{ __('Log In') }}
            </x-dropdown-link>
            @if (Route::has('register'))
              <x-dropdown-link :href="route('register')">
                {{ __('Register') }}
              </x-dropdown-link>
            @endif
            @if (Route::has('password.request'))
              <x-dropdown-link :href="route('password.request')">
                {{ __('Reset Password') }}
              </x-dropdown-link>
            @endif
          </x-slot>

          @endauth

        </x-dropdown>
      </div>

      <!-- Hamburger -->
      <div class="mr-2 flex items-center justify-end sm:hidden">
        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Responsive Navigation Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden absolute z-10 bg-white w-full">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link :href="url('/')" :active="request()->routeIs('/')">
        {{ __('Home') }}
      </x-responsive-nav-link>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-y border-gray-200">


      @auth

      <div class="px-4">
        <div class="font-medium text-base text-gray-800 truncate">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
      </div>

      <div class="mt-3 space-y-1">
        <x-responsive-nav-link :href="route('profile.edit')">
          {{ __('Profile') }}
        </x-response-nav-link>

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
            {{ __('Log Out') }}
          </x-responsive-nav-link>
        </form>
      </div>

      @else

        <x-responsive-nav-link :href="route('login')">
          {{ __('Log In') }}
        </x-responsive-nav-link>
        @if (Route::has('register'))
          <x-responsive-nav-link :href="route('register')">
            {{ __('Register') }}
          </x-responsive-nav-link>
        @endif
        @if (Route::has('password.request'))
          <x-responsive-nav-link :href="route('password.request')">
            {{ __('Reset Password') }}
          </x-responsive-nav-link>
        @endif

      @endauth


    </div>
  </div>
</nav>
