<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Admin Panel</div>

                <a class="nav-link" href="{{route('dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>


                <div class="sb-sidenav-menu-heading">Categories</div>
                <a class="nav-link" href="{{route('Category')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-bars"></i></div>
                    Categories
                </a>
                <div class="sb-sidenav-menu-heading">Category Wallpapers</div>

                <a class="nav-link wall" style="position:relative; cursor:pointer;">
                    <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                    Wallpapers
                    <div class="sb-nav-link-icon" style="position: absolute;right: 0;">
                        <span class="material-symbols-outlined none" id="arrow1">
                            expand_more
                        </span>
                        <span class="material-symbols-outlined" id="arrow2">
                            expand_less
                        </span>
                    </div>
                    <form action="{{url('wall')}}" method="get" id="wall_form">
                        @csrf
                        <div class="wallpaper_drop_down">
                            @foreach (App\Models\Category::get() as $category)
                            <a class="nav-link" href="{{ url('wall/'.$category->id)  }}" style="padding: 0.4rem 2.5rem; cursor:pointer;">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </form>
                </a>
                <form method="post" action="{{route('logout')}}" id="lform">
                    @csrf
                    <a class="nav-link" onclick="document.getElementById('lform').submit();">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                        Logout
                    </a>
                </form>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{auth()->user()->first_name.' '. auth()->user()->last_name}}
        </div>
    </nav>
</div>

<script>
    // function editCat(id) {
    //     console.log(id)
    //     $.ajax({
    //         // url: "{{ url('edit_category/') }}" + "/" + id,
    //         url: "{{ url('wall/') }}" + "/" + id,
    //         success: function(data) {
    //             // console.log(data.id)
    //             // $("#category_id").val(id);
    //         }
    //     });

    //     // setTimeout(() => {
    //     //     document.getElementById('wall_form').submit();
    //     // }, 100);
    // }

    let wallpaper = document.getElementsByClassName('wall')[0];
    let arrow1 = document.getElementById('arrow1');
    let arrow2 = document.getElementById('arrow2');
    let wallpaper2 = document.getElementsByClassName('wall')[1].style.padding = '0';
    let wallpaper3 = document.getElementsByClassName('wall')[2].style.padding = '0';
    let dropDown = document.getElementsByClassName('wallpaper_drop_down')[0];

    wallpaper.addEventListener('click', () => {
        dropDown.classList.toggle('none')
        arrow1.classList.toggle('none')
        arrow2.classList.toggle('none')
        // arrow.classList.add('fa-angle-up')
    })
</script>