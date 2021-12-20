<!DOCTYPE html>
<html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

    @include('front.common.header')
    <style>
        /*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/

        .vertical-nav {
            min-width: 17rem;
            width: 17rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.4s;
        }

        .page-content {
            width: calc(100% - 17rem);
            margin-left: 17rem;
            transition: all 0.4s;
        }

        /* for toggle behavior */

        #sidebar.active {
            margin-left: -17rem;
        }

        #content.active {
            width: 100%;
            margin: 0;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -17rem;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                width: 100%;
                margin: 0;
            }

            #content.active {
                margin-left: 17rem;
                width: calc(100% - 17rem);
            }
        }

        /*
*
* ==========================================
* FOR DEMO PURPOSE
* ==========================================
*
*/



        body {
            background: #599fd9;
            background: -webkit-linear-gradient(to right, #599fd9, #c2e59c);
            background: linear-gradient(to right, #599fd9, #c2e59c);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .separator {
            margin: 3rem 0;
            border-bottom: 1px dashed #fff;
        }

        .text-uppercase {
            letter-spacing: 0.1em;
        }

        .text-gray {
            color:cornsilk;
        }
    </style>
    <title>Dashbord</title>
</head>

<body>
    <!-- Vertical navbar -->
    <div class="vertical-nav body-content" id="sidebar">
        <div class="py-4 px-3 mb-4 ">
            <div class="media d-flex align-items-center text-light"><img src="https://res.cloudinary.com/mhmd/image/upload/v1556074849/avatar-1_tcnd60.png" alt="..." width="65" class="mr-3 rounded-circle img-thumbnail shadow-sm">
                <div class="media-body">
                    <h4 class="m-0">{{ Auth::user()->name }}</h4>
                    <p class="font-weight-light text-muted mb-0 ">
                        @if(Auth::user()->role == 1)
                        Super Admin
                        @else   Admin  @endif
                    </p>
                    <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                  {{ __('Log Out') }}
                </x-dropdown-link>
              </form>
                </div>
            </div>
        </div>

        <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Main</p>

        <ul class="nav flex-column  mb-0">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link text-light font-italic ">
                    <i class="fa fa-th-large mr-3 text-primary fa-fw"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/product" class="nav-link text-light font-italic">
                    <i class="fa fa-address-card mr-3 text-primary fa-fw"></i>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/order" class="nav-link text-light font-italic">
                    <i class="fa fa-cubes mr-3 text-primary fa-fw"></i>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/user" class="nav-link text-light font-italic">
                    <i class="fa fa-picture-o mr-3 text-primary fa-fw"></i>
                    Users
                </a>
            </li>
        </ul>

        <p class="text-gray font-weight-bold text-uppercase px-3 small py-4 mb-0">Charts</p>

        <ul class="nav flex-column  mb-0">
            <li class="nav-item">
                <a href="{{ url('products/create') }}" class="nav-link text-light font-italic">
                    Add Product
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('register') }}" class="nav-link text-light font-italic">
                    Add User
                </a>
            </li>

            <li class="nav-item">
                <a href="/" class="nav-link text-light font-italic">
                    Main Page
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-light font-italic">
                    <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
                    Area charts
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-light font-italic">
                    <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
                    Bar charts
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-light font-italic">
                    <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
                    Pie charts
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-light font-italic">
                    <i class="fa fa-line-chart mr-3 text-primary fa-fw"></i>
                    Line charts
                </a>
            </li>
        </ul>
    </div>
    <!-- End vertical navbar -->
    <!-- Page content holder -->
    <div class="page-content p-5" id="content">
        <!-- Toggle button -->
        <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4" style="z-index: 99; position:absolute;"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Toggle</small></button>

        <!-- Demo content -->
        <h1 style="z-index: 99;position:absolute; top: 15% ; color:white;">Dashboard</h1>

        <img src=" {{ asset('images/logo1.png') }}" alt="backgrounf" style="z-index: -12; width:auto; height:auto; border-radius: 30%;">

        <div class="separator"></div>
        @yield('content')
    </div>
</body>
<script>
    $(function() {
        // Sidebar toggle behavior
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar, #content').toggleClass('active');
        });
    });
</script>

</html>