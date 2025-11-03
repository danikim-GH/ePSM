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
            <a href="{{route('logout')}}" class="nav-item nav-link">
                {{ $menu->menu_tajuk }}
            </a>
        @else    
            <a href="{{ url(strtolower($menu->menu_tajuk)) }}" class="nav-item nav-link">
                {{ $menu->menu_tajuk }}
            </a>
        @endif
    @endif
@endforeach
