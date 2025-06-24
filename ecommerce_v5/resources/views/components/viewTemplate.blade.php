<div class="d-flex gap-2 mb-4">
    @php
        $currentView = request('view', 'card'); // default to card
    @endphp

    <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}"
       class="btn btn-outline-light {{ $currentView === 'grid' ? 'active' : '' }}">Grid View</a>
    <a href="{{ request()->fullUrlWithQuery(['view' => 'table']) }}"
       class="btn btn-outline-light {{ $currentView === 'table' ? 'active' : '' }}">Table View</a>
    <a href="{{ request()->fullUrlWithQuery(['view' => 'card']) }}"
       class="btn btn-outline-light {{ $currentView === 'card' ? 'active' : '' }}">Card View</a>
    <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}"
       class="btn btn-outline-light {{ $currentView === 'list' ? 'active' : '' }}">List View</a>
    <a href="{{ request()->fullUrlWithQuery(['view' => 'gallery']) }}"
       class="btn btn-outline-light {{ $currentView === 'gallery' ? 'active' : '' }}">Gallery View</a>
</div>
