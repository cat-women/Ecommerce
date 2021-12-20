<style>
  .searchContainer {
    width: fit-content;
    margin-left: auto;
    float: right;
    z-index: 99;
  }

  #overlay {
    position: fixed;
    display: block;
    width: fit-content;
    height: fit-content;
    align-items: center;
    top: 10%;
    left: 70%;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    cursor: pointer;
  }
</style>


<nav class="navbar navbar-expand-md text-dark">
  <a class="navbar-brand mx-auto me-4" href="/">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
      <path d="M8 .95 14.61 4h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.379l.5 2A.5.5 0 0 1 15.5 17H.5a.5.5 0 0 1-.485-.621l.5-2A.5.5 0 0 1 1 14V7H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 4h.89L8 .95zM3.776 4h8.447L8 2.05 3.776 4zM2 7v7h1V7H2zm2 0v7h2.5V7H4zm3.5 0v7h1V7h-1zm2 0v7H12V7H9.5zM13 7v7h1V7h-1zm2-1V5H1v1h14zm-.39 9H1.39l-.25 1h13.72l-.25-1z" />
    </svg>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse w-100 collapse order-0 order-md-0 dual-collapse2">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="{{ URL::route('mainPage') }}#man">Man' Clothes</a></li>
          <li><a class="dropdown-item" href="{{URL::route('mainPage') }}#women">Women's Clothes
              {{--<li><hr class="dropdown-divider"> </li> --}}
          <li><a class="dropdown-item" href="{{URL::route('mainPage') }}#kid">kids Clothes</a></li>
          <li><a class="dropdown-item" href="{{URL::route('mainPage') }}#other">Othes</a></li>
        </ul>
      </li>
      @auth
      @if(auth()->user()->role == 1 )
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">Dashbord</a>
      </li>
      
      @endif
      @endauth
    </ul>
  </div>

  <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item ">
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" id="searchId" aria-label="Search">
          <button class="btn btn-primary" type="button" id="searchBtn" onclick="on()">Search</button>
        </form>
      </li>
      @if (Route::has('login'))
      <li class="nav-item">
        @auth
        <div class="hidden sm:flex sm:items-center sm:ml-6">
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                <div class="text-light">{{ Auth::user()->name }}</div>

                <div class="ml-1">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </button>
            </x-slot>

            <x-slot name="content">
              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                  {{ __('Log Out') }}
                </x-dropdown-link>
              </form>
              <button class="btn "><a href="{{ url('/carts') }}"><u>View Profile</u></a></button>
            </x-slot>


          </x-dropdown>
        </div>
      </li>
      @else
      <li class="nav-item">
        <a href="{{ route('login') }}" class="text-sm text-light-700 underline">Log in</a>
      </li>
      <li class="nav-item">
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="ml-md-4 text-sm text-light-700 underline">Register</a>
        @endif
      </li>
      @endauth
      @endif
    </ul>
  </div>
</nav>

<div class="searchContainer"></div>

<script>
  // products search 
  function searchFunction(query) {
    if(query==''){
      location.reload();

      //$('.overlay ol').empty();          
        }
    $.ajax({
      url: "/searchProduct",
      method: 'GET',
      data: {
        query: query
      },
      dataType: 'json',
      success: function(data) {
        if (data == null) {
          alert(data);
        }
        console.log(data);
        listBody = '';        
        jQuery.each(data, function(index, item) {
          $('.overlay ol').empty();          
          listBody += `<li class="list-group-item d-flex align-items-start" value="` + item.id + `" onclick="showDetail(` + item.id + `)">
                          <div class="ms-2 me-auto">
                            <div class="fw-bold">` + item.p_name + `</div>
                            ` + item.p_cat + `
                          </div>
                      </li>`;
        });
        html = ` <ol class="list-group" id="overlay">` + listBody + `</ol>`;
        //location.reload();

        var overlay = jQuery(html);        
        overlay.appendTo(document.body);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });

  }

  $(document).ready(function() {
    $('#searchId').on('keyup change', function() {
      var query = $(this).val();     
      searchFunction(query);
    });
  });


  //clicking on search button 
  $(document).ready(function() {
    $('#searchBtn').on('click', function() {
      var query = $('#searchId').val();
      searchFunction(query);
    });
  });


  function showDetail(id) {
    window.location = "/products/" + id;
  }
</script>