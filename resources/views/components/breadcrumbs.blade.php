<div class="breadcrumbs">
    <div class="breadcrumbs-container container" style="
        display: flex;
        justify-content: space-between;
        align-items: center;
    ">
        <div>
            {{ $slot }}
        </div>
        <div>
            @include('partials.search')
        </div>
    </div>
</div> <!-- end breadcrumbs -->
