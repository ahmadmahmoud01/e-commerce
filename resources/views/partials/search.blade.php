<form action="{{ route('products.search') }}" method="GET" class="search-form" style="position: relative;">
    <i class="fa fa-search search-icon" style="color: gray;
    position: absolute; top: 12px; left: 12px;"></i>
    <input type="text" name="query"
        style="padding: 10px 12px 10px 34px; width: 400px; max-width: 100%; font-size: 14px;"
        id="query" class="search-box" value="{{ request()->input('query') }}" placeholder="Search for product">
</form>
