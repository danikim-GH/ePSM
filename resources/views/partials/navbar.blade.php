@foreach ($mainMenu as $menu)
    @php
        $subs = $submenus[$menu->ID] ?? collect();
    @endphp

    @if ($subs->count())
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="dynamic" aria-expanded="false">
                {{ $menu->menu_tajuk }}
            </a>
            <div class="dropdown-menu dropdown-menu-end m-0">
                @foreach ($subs as $sub)

                    @if ($sub->menu_action === 'modal' && !empty($sub->menu_target))
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#{{ $sub->menu_target }}">{{ $sub->menu_tajuk }}</a>
                    
                    @elseif ($sub->menu_action === 'route' && !empty($sub->menu_target))
                        <a href="{{ route($sub->menu_target) }}" class="dropdown-item" target="_blank">{{ $sub->menu_tajuk }}</a>
                    
                    @elseif($sub->menu_action === 'link' && !empty($sub->menu_target))
                        {{-- LINK --}}
                        <a href="{{ $sub->menu_target }}"
                        class="dropdown-item">
                            {{ $sub->menu_tajuk }}
                        </a>
                    @else
                        {{-- FALLBACK SELAMAT --}}
                        <a href="#"
                        class="dropdown-item text-muted">
                            {{ $sub->menu_tajuk }}
                        </a>
                    @endif
                    @endforeach
                </div>
            </div>
    @else
    <a href="{{ route($menu->menu_target ?? '#') }}" class="nav-item nav-link">
        {{ $menu->menu_tajuk }}
    </a>
    @endif
@endforeach