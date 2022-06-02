<nav class="navbar sticky-top navbar-expand-lg navbar-dark" style="background-color:#191919">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="/img/LogoGFGWhite.png" alt="GFG" width=90></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" style="font-size: 20px">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ ($active === "home") ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($active === "reviewPosts") ? 'active' : '' }}" href="/reviewPosts">Review</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($active === "tipPosts") ? 'active' : '' }}" href="/tipPosts">Tips & Tricks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($active === "newsPosts") ? 'active' : '' }}" href="/newsPosts">News</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ ($active === "edit") ? 'active' : '' }} dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->username }}
                        </a>
                        <ul class="dropdown-menu" id="dropUser" aria-labelledby="navbarDropdown" style="background-color:#191919">
                            <li><a class="dropdown-item" href="/editProfile" style="color:#919191"><i class="bi bi-person"></i> Edit Profile</a></li>
                            <li><hr class="dropdown-divider" style="color:white"></li>
                            <li>
                                <form action="/logout" method="post" class="">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color:#919191"><i class="bi bi-arrow-left-circle"></i> Logout</a></button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="/login" class="nav-link {{ ($active === "login") ? 'active' : '' }}"><i class="bi bi-arrow-right-circle"></i> Log In</a>    
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>