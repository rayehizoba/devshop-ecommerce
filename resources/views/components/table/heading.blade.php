@props([
    'sortable' => null,
    'direction' => null,
])

<th
    {{ $attributes->merge([
        'class' => 'py-3 text-left text-xs leading-4 text-gray-400 uppercase tracking-wider'
    ])->only('class') }}
>
    @unless ($sortable)
        <div>
            {{ $slot }}
        </div>
    @else
        <button {{ $attributes->except('class') }} class="flex items-center space-x-1 uppercase focus:outline-none parent">
            <span class="font-bold">{{ $slot }}</span>



            <span>
                @if ($direction === 'asc')
                    <i class="mdi mdi-sort-ascending"></i>
                @elseif ($direction === 'desc')
                    <i class="mdi mdi-sort-descending"></i>
                @else
                    <i class="mdi mdi-sort opacity-25 parent-hover:opacity-100 transition duration-50 ease-out"></i>
                @endif
            </span>
        </button>
    @endif
</th>
