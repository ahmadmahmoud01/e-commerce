@extends('layout')

@section('title', 'Products')

@section('extra-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">

<style>
    a {
        text-decoration: none;
        color: black
    }
</style>

@endsection

@section('content')

    {{--  <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shop</span>
        </div>
    </div> <!-- end breadcrumbs -->  --}}

    @component('components.breadcrumbs')

        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shop</span>

    @endcomponent

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>

                @foreach ($categories as $category)

                    <li class="{{ setActiveCategory($category->slug) }}"><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>

                @endforeach

            </ul>

            {{--  <h3>By Price</h3>
            <ul>
                <li><a href="#">$0 - $700</a></li>
                <li><a href="#">$700 - $2500</a></li>
                <li><a href="#">$2500+</a></li>
            </ul>  --}}
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header" style="display: flex">
                <h1 class="stylish-heading">{{ $categoryName }}</h1>
                <div style="margin-left: 50%">
                    <strong style="font-weight: bold">Price : </strong>
                    <a href="{{ url(route('shop.index', ['category' => request()->category, 'sort' => 'low_high'])) }}">Low to High</a> |
                    <a href="{{ url(route('shop.index', ['category' => request()->category, 'sort' => 'high_low'])) }}">High to Low</a>
                </div>
            </div>
            <div class="products text-center">

                @forelse ($products as $product)

                    <div class="product">
                        <a href="{{ url(route('shop.show', $product->slug)) }}"><img src="{{ productImage($product->image) }}" alt="product"></a>
                        <a href="{{ url(route('shop.show', $product->slug)) }}"><div class="product-name">{{ $product->name }}</div></a>
                        <div class="product-price">{{ $product->presentPrice() }}</div>
                    </div>

                @empty

                    <h3 style="text-align: left">No products found</h3>

                @endforelse


            </div> <!-- end products -->
            <br><br>

            {{ $products->appends(request()->input())->links() }}


        </div>
    </div>


@endsection
