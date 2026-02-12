@foreach ($mainMenu as $menu)
    @php
        $subs = $submenus[$menu->ID] ?? collect();
        $menuUrl = trim($menu->menu_url);
    @endphp

    @if ($subs->count() > 0)
        {{-- Dropdown Menu --}}
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                {{ $menu->menu_tajuk }}
            </a>
            <div class="dropdown-menu dropdown-menu-end m-0">
                @foreach ($subs as $sub)
                    @php $subUrl = trim($sub->menu_url); @endphp
                    
                    {{-- Check kalau submenu ada logout --}}
                    @if($subUrl == 'logout.php')
                        <a href="javascript:void(0);" class="dropdown-item" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ $sub->menu_tajuk }}
                        </a>
                    @elseif($subUrl == 'profail.php')
                        <a href="javascript:void(0);" class="dropdown-item" onclick="openProfileModalManual()">
                            {{ $sub->menu_tajuk }}
                        </a>
                    @else
                        @php

                            $finalUrl = '#';

                            if($subUrl !== '-'){
                                $finalUrl = url($subUrl);
                            }

                            //$subUrl === '-' && 
                            elseif ($sub->ID === 10) {
                                $finalUrl = route('galeri.menu', $sub->ID);
                            }

                            elseif($sub->menu_arah ==='galeri_acara'){
                                $finalUrl = route('galeri.menu', $sub->ID);
                            }

                            elseif ($sub->menu_arah === 'info') {
                                $finalUrl = route('info.show', $sub->menu_idarah);
                            } 

                            elseif($sub->menu_arah === 'direktori'){
                                $finalUrl = route('direktori.menu', $sub->ID);
                            }

                            else {
                                $finalUrl = ($subUrl === '-' ? '#' : url($subUrl));
                            }
                        @endphp
                    
                        <a href="{{ $finalUrl }}" class="dropdown-item">
                            {{ $sub->menu_tajuk }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

    {{-- FIX: Check kalau main menu adalah logout.php --}}
    @elseif($menuUrl == 'logout.php')
        <a href="javascript:void(0);" class="nav-item nav-link" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ $menu->menu_tajuk }}
        </a>
    @elseif($menuUrl =='profail.php')
        <a href="#" class="nav-item nav-link" onclick="openProfileModalManual()">
            {{ $menu->menu_tajuk }}
        </a>
    @else
        {{-- Link biasa --}}
        <a href="{{ $menuUrl === '-' ? '#' : url($menuUrl) }}" class="nav-item nav-link">
            {{ $menu->menu_tajuk }}
        </a>
    @endif
@endforeach

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>