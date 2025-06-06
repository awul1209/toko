<header class="navbar sticky-top flex-md-nowrap p-0 shadow" data-bs-theme="dark" style="background-color:#3498DB;">
    <a href="index.html" class="logo me-auto" style="color:white; text-decoration: none;"><img src="../assets/img/konten/icon.png" alt="icon" class="img-fluid" width="50" style="padding:2px; margin:2px 0 2px 0; margin-left: 35px; ">  SeePay</a>

    <div class="text m-3 text-white">
        <h6>Welcome back <?= $ses_nama ?> </h6>
    </div>

    <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                <svg class="bi">
                    <use xlink:href="#search" />
                </svg>
            </button>
        </li>
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <svg class="bi">
                    <use xlink:href="#list" />
                </svg>
            </button>
        </li>
    </ul>

    <div id="navbarSearch" class="navbar-search w-100 collapse">
        <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
    </div>
</header>