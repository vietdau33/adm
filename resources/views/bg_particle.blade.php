@php
    $css = [];
    foreach ([
        'position' => 'fixed',
        'top' => 0,
        'left' => '0',
        'z-index' => '0',
        'width' => '100vw',
        'height' => '100vh',
        'background-color' => '#eff6ff',
    ] as $key => $value) {
        $css[] = $key . ':' . $value;
    }
@endphp
<div
    id="particles-bg"
    class="particles-container particles-bg"
    style="{{ implode(';', $css) }}"
    data-pt-base="#00c0fa"
    data-pt-base-op=".3"
    data-pt-line="#2b56f5"
    data-pt-line-op=".5"
    data-pt-shape="#00c0fa"
    data-pt-shape-op=".2"></div>
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/set_particle.js') }}"></script>
