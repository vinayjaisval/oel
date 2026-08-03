
<style>

    .oel-breadcrumb {
    background: #f8f9fa;
    padding: 12px 18px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.oel-breadcrumb .breadcrumb {
    margin: 0;
    background: transparent;
}

.oel-breadcrumb .breadcrumb-item {
    font-size: 14px;
    font-weight: 500;
}

.oel-breadcrumb .breadcrumb-item a {
    color: #0d6efd;
    text-decoration: none;
    transition: color .2s ease;
}

.oel-breadcrumb .breadcrumb-item a:hover {
    color: #0a58ca;
    text-decoration: underline;
}

.oel-breadcrumb .breadcrumb-item.active {
    color: #6c757d;
    font-weight: 600;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #adb5bd;
    padding: 0 .6rem;
}
    </style>
<nav aria-label="breadcrumb" class="oel-breadcrumb mb-3">
    <ol class="breadcrumb mb-0">
        @foreach($items as $item)
            @if(!$loop->last && !empty($item['url']))
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>

@push('structured_data')
<script type="application/ld+json">
{
    "@context":"https://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[
        @foreach($items as $i => $item)
        {
            "@type":"ListItem",
            "position":{{ $i + 1 }},
            "name":@json($item['label']),
            "item":@json($item['url'] ?? url()->current())
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endpush