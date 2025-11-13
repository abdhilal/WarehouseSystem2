<aside class="page-sidebar">
  <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
  <div class="main-sidebar" id="main-sidebar">
    <ul class="sidebar-menu" id="simple-bar">
      <li class="pin-title sidebar-main-title">
        <div>
          <h5 class="f-w-700 sidebar-title">{{ __('Pinned') }}</h5>
        </div>
      </li>
      @foreach(config('sidebar') as $section)
        @if(!empty($section['title']))
          <li class="sidebar-main-title">
            <div>
              <h5 class="f-w-700 sidebar-title">{{ __($section['title']) }}</h5>
            </div>
          </li>
        @endif
        @foreach(($section['items'] ?? []) as $item)
          @php
            $hasChildren = !empty($item['children']);
            $href = $hasChildren ? 'javascript:void(0)' : (isset($item['route']) ? route($item['route']) : ($item['url'] ?? '#'));
            $icon = $item['icon'] ?? null;
            $label = $item['label'] ?? '';
            $itemActive = isset($item['route']) ? request()->routeIs($item['route']) : (isset($item['url']) ? request()->is(ltrim(parse_url($item['url'], PHP_URL_PATH) ?? '', '/')) : false);
            // keep submenu open if any child is active
            $open = $itemActive;
            if ($hasChildren) {
              foreach ($item['children'] as $c) {
                $cActive = isset($c['route']) ? request()->routeIs($c['route']) : (isset($c['url']) ? request()->is(ltrim(parse_url($c['url'], PHP_URL_PATH) ?? '', '/')) : false);
                if ($cActive) { $open = true; break; }
              }
            }
          @endphp
          <li class="sidebar-list {{ $open ? 'active' : '' }}">
            <i class="fa-solid fa-thumbtack"></i>
            <a class="sidebar-link" href="{{ $href }}" @if($hasChildren) aria-expanded="{{ $open ? 'true' : 'false' }}" @endif>
              @if($icon)
                <svg class="stroke-icon">
                  <use href="{{ asset('assets/svg/iconly-sprite.svg#'.$icon) }}"></use>
                </svg>
              @endif
              <h6 class="f-w-600" @if(!empty($item['color'])) style="color: {{ $item['color'] }}" @endif>{{ __($label) }}</h6>
              @if($hasChildren)
                <i class="iconly-Arrow-Right-2 icli"></i>
              @endif
            </a>
            @if($hasChildren)
              <ul class="sidebar-submenu" @if($open) style="display: block;" @endif>
                @foreach($item['children'] as $child)
                  @php
                    $childHref = isset($child['route']) ? route($child['route']) : ($child['url'] ?? '#');
                    $childActive = isset($child['route']) ? request()->routeIs($child['route']) : (isset($child['url']) ? request()->is(ltrim(parse_url($child['url'], PHP_URL_PATH) ?? '', '/')) : false);
                  @endphp
                  <li class="{{ $childActive ? 'active' : '' }}">
                    <a href="{{ $childHref }}" @if(!empty($child['color'])) style="color: {{ $child['color'] }}" @endif>{{ __($child['label'] ?? '') }}</a>
                  </li>
                @endforeach
              </ul>
            @endif
          </li>
        @endforeach
      @endforeach
    </ul>
  </div>
</aside>
