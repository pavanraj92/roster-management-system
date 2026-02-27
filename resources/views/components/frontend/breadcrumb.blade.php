@props([
    'items' => [],
])

@if (!empty($items))
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                @foreach ($items as $index => $item)
                    @php
                        $label = $item['label'] ?? '';
                        $url = $item['url'] ?? null;
                    @endphp

                    @if ($index === 0)
                        @if ($url)
                            <a href="{{ $url }}" rel="nofollow">
                                <i class="fi-rs-home mr-5"></i>{{ $label }}
                            </a>
                        @else
                            <span><i class="fi-rs-home mr-5"></i>{{ $label }}</span>
                        @endif
                    @else
                        <span></span>
                        @if ($url)
                            <a href="{{ $url }}">{{ $label }}</a>
                        @else
                            <span>{{ $label }}</span>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
