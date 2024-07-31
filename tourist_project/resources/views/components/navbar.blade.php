<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="{{ route('home')}}" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-map-marker-alt me-3"></i>Tourist</h1>
            <!-- <img src="img/logo.png" alt="Logo"> -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('home')}}" class="nav-item nav-link active">Trang chủ</a>
                <a href="{{ route('tour.list')}}" class="nav-item nav-link">Tour du lịch</a>
                @foreach($categories as $categoryItems)
                <div class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $categoryItems->name}}</a>
                    <div class="dropdown-menu m-0">
                        @if(count($categoryItems->categoryChildrens) > 0)
                        @foreach($categoryItems->categoryChildrens as $categoryItem)
                        <a href="{{ route('category.header',['id' => $categoryItem->id, 'slug' => $categoryItem->slug])}}" class="dropdown-item">{{ $categoryItem->name}}</a>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
                <a href="contact.html" class="nav-item nav-link">Liên hệ</a>
            </div>

            <div class="navbar-nav ml-auto">
                @if(Auth::check())
                <div class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('personal.profile', ['id' => auth()->id()])}}" class="dropdown-item">Profile</a>
                        <a href="{{ route('manager.tour')}}" class="dropdown-item">Tour cá nhân</a>
                        <a href="{{ route('favorite.tour')}}" class="dropdown-item">Tour yêu thích</a>
                        <a href="/logout" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                @else
                <div class="d-flex align-items-center">
                    <a href="{{ route('login.user')}}" class="btn btn-primary rounded-pill py-2 px-4 mx-1">Đăng nhập</a>
                    <a href="{{ route('register.user')}}" class="btn btn-primary rounded-pill py-2 px-4 mx-1">Đăng ký</a>
                </div>
                @endif
            </div>
        </div>
    </nav>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src=" {{ asset('searchAjax/js/search_ajax.js')}}"></script>

<style>
    .input-group input {
        border: none;
    }

    .btn {
        border-radius: 5px;
    }

    .rounded {
        border-radius: 8px !important;
    }

    .input:focus {
        outline: none;
        box-shadow: none;
        /* Optional: Nếu muốn loại bỏ hiệu ứng shadow */
    }

    #search-results,
    #search-results-destination {
        max-height: 200px;
        /* Adjust as needed */
        overflow-y: auto;
        background: white;
        border: 1px solid #ddd;
        z-index: 9999;
        /* Ensure it appears above other content */
        display: none;
        /* Hide by default */
        width: 100%;
        top: 100%;
        left: 0;
    }

    .search-item,
    .search-item-destination {
        padding: 10px;
        cursor: pointer;
    }

    .search-item:hover {
        background-color: #f0f0f0;
    }

    .search-index {
        z-index: 9999;
    }
</style>
