

<li>
    <a href="{{ backpack_url('dashboard') }}">
        <i class="fa fa-dashboard"></i>
        <span>{{ trans('backpack::base.dashboard') }}</span>
    </a>
</li>

@foreach (\Config::get('backpack.menu.items') as $group => $items)
    <li class="text-white">
        <a class="h4">{{ $group }}</a>
    </li>
    @foreach ($items as $slug => $item)
        <li>
            <a href='{{ backpack_url($slug) }}'>
                <i class='fa {{ $item['icon'] }}'></i>
                <span>{{ $item['name'] }}</span>
            </a>
        </li>
    @endforeach
@endforeach
