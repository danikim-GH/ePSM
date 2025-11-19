@php
use App\Models\Menu;
$user_level = session('user_level', 9);

$mainMenu = Menu::where('menu_level', 1)
    ->whereRaw("FIND_IN_SET(?, userlevel)", [$user_level])
    ->orderBy('menu_sort')
    ->get();
@endphp

@foreach ($mainMenu as $menu)
    @php
        $submenu = null;
        if ($menu->menu_tajuk === 'Info Latihan') {
            $submenu = Menu::where('menu_level', 2)
                ->where('menu_arah', 'info')
                ->whereRaw("FIND_IN_SET(?, userlevel)", [$user_level])
                ->orderBy('menu_sort')
                ->get();
        } elseif ($menu->menu_tajuk === 'Pustaka') {
            $submenu = Menu::where('menu_level', 2)
                ->where('menu_arah', 'pustaka')
                ->whereRaw("FIND_IN_SET(?, userlevel)", [$user_level])
                ->orderBy('menu_sort')
                ->get();
        } elseif ($menu->menu_tajuk === 'Direktori') {
            $submenu = Menu::where('menu_level', 2)
                ->where('menu_arah', 'direktori')
                ->whereRaw("FIND_IN_SET(?, userlevel)", [$user_level])
                ->orderBy('menu_sort')
                ->get();
        }
    @endphp

    {{-- Menu dengan submenu --}}
    @if ($submenu && $submenu->count() > 0)
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $menu->menu_tajuk }}</a>
            <div class="dropdown-menu m-0">
                @foreach ($submenu as $sub)
                    <a href="{{ url(strtolower($menu->menu_arah) . '?id=' . $sub->ID) }}" class="dropdown-item">
                        {{ $sub->menu_tajuk }}
                    </a>
                @endforeach
            </div>
        </div>
    @else
        {{-- Menu tanpa submenu --}}
        @if ($menu->menu_tajuk === 'User')
            <a href="#" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#userModal">
                {{ $menu->menu_tajuk }}
            </a>
        @else    
            <a href="{{ url(strtolower($menu->menu_tajuk)) }}" class="nav-item nav-link">
                {{ $menu->menu_tajuk }}
            </a>
        @endif
    @endif
@endforeach


<!--Modal user profile-->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title pt-sans-bold" id="userModalLabel">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="{{ asset("assets/img/cropped-kedah-baru.png")}}" alt="Avatar" class="rounded-circle mb-2" width="100" height="100">
                </div>

                <div class="mb-2">
                    <strong>Nama:</strong> {{ session('nama','tidak tersedia') }}
                </div>

                <div class="mb-2">
                    <strong>No KP:</strong> {{session('nokp', 'tidak tersedia')}}
                </div>

                <div class="mb-2">
                    <strong>Emel:</strong> {{session('email', 'tidak tersedia')}}
                </div>

                <div class="mb-2">
                    <strong>No Telefon:</strong> {{session('phone', 'tidak tersedia')}}
                </div>

                <div class="d-grid gap-2 d-sm-flex justify-content-end mt-3">
                    <a href="{{ route('logout') }}" class="btn btn-danger w-100 mb-2">
                        Logout
                    </a>
                    <a href="{{ route('adminView') }}" class="btn btn-warning w-100 mb-2">
                        Admin Panel
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>