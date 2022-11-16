<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
    <img src="assets/img/logo.png" alt="">
    <span class="d-none d-lg-block">ClinicNet</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">{{ $notcount }}</span>
      </a><!-- End Notification Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
          You have {{ $notcount }} new notifications
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>


        @foreach ($not as $row) 

            <li class="notification-item">
              <i class="{{ $row->icon1 }}"></i>
              <div>
                <h4>{{ $row->subject }}</h4>
                <p>{{ $row->message }}</p>
                <p>30 min. ago</p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

        @endforeach
        
        <!--
        <li class="notification-item">
          <i class="bi bi-x-circle text-danger"></i>
          <div>
            <h4>Atque rerum nesciunt</h4>
            <p>Quae dolorem earum veritatis oditseno</p>
            <p>1 hr. ago</p>
          </div>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="notification-item">
          <i class="bi bi-check-circle text-success"></i>
          <div>
            <h4>Sit rerum fuga</h4>
            <p>Quae dolorem earum veritatis oditseno</p>
            <p>2 hrs. ago</p>
          </div>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="notification-item">
          <i class="bi bi-info-circle text-primary"></i>
          <div>
            <h4>Dicta reprehenderit</h4>
            <p>Quae dolorem earum veritatis oditseno</p>
            <p>4 hrs. ago</p>
          </div>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>
        <li class="dropdown-footer">
          <a href="#">Show all notifications</a>
        </li> -->

      </ul><!-- End Notification Dropdown Items -->

    </li><!-- End Notification Nav -->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-success badge-number">{{ $messagecount }}</span>
      </a><!-- End Messages Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
        <li class="dropdown-header">
          You have {{ $messagecount }} new messages
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>


        @foreach ($messages as $row) 

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('storage/images/' . $row->user->image1 . '')}}" alt="" class="rounded-circle">
                <div>
                  <h4>{{ $row->user->name }}</h4>
                  <p>{{ $row->subject }}</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

        @endforeach


<!--

        <li class="message-item">
          <a href="#">
            <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
            <div>
              <h4>Anna Nelson</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>6 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="message-item">
          <a href="#">
            <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
            <div>
              <h4>David Muldon</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>8 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li> -->

        <li class="dropdown-footer">
          <a href="#">Show all messages</a>
        </li>

      </ul><!-- End Messages Dropdown Items -->

    </li><!-- End Messages Nav -->

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

      
        @if ( auth()->user()->image1 ) 
          <img src="{{ asset('storage/images/' . Auth::user()->image1 . '') }}" alt="{{ Auth::user()->image1 }}" class="rounded-circle">
        @else
          <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="{{ Auth::user()->image1 }}" class="rounded-circle">
        @endif


        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>{{ Auth::user()->name }}</h6>
          <span>
            @if ( auth()->user()->level==1 ) 
                {{ Auth::user()->level }} - Administrator 
            @elseif  (auth()->user()->level == 2 )  
                {{ Auth::user()->level }} - Owner  
            @elseif  (auth()->user()->level == 3 )  
                {{ Auth::user()->level }} - Mgr Operasional        
            @elseif  (auth()->user()->level == 4 )  
                {{ Auth::user()->level }} - Mgr. Keuangan
            @elseif  (auth()->user()->level == 5 )  
                {{ Auth::user()->level }} - Material 
            @elseif  (auth()->user()->level == 6 )  
                {{ Auth::user()->level }} - Upah 
            @elseif  (auth()->user()->level == 7 )  
                {{ Auth::user()->level }} - Peralatan
            @elseif  (auth()->user()->level == 8 )  
                {{ Auth::user()->level }} - Admin Proyek
            @endif
          </span>
          <br><h6 small><span class="badge badge-success">{{ Auth::user()->member->kta }}</span></h6>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="/profil">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-gear"></i>
            <span>Change Password</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>Need Help?</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <form action="{{ route('logout') }}" method="POST">
              @csrf
              <!-- <a class="dropdown-item d-flex align-items-center" href="#"> -->
                <!-- <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span> -->
                <span>
                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>Sign Out</button>
                </span>
              <!--</a>-->
          </form>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->
