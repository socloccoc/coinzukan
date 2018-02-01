
    <ul class="list-group">
        @forelse($coins as $item)
            <a href=""><li class="list-group-item"><img src="{{ $item->icon_url }}">{{ $item->name }}</li></a>
        @empty
        @endforelse
    </ul>