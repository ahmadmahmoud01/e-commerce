@extends('layout')

@section('title', 'Product')

@section('extra-css')

    <style>

        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 100%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }

        .badge-primary {
            color: #fff;
            background-color: #007bff;
        }

        .badge-secondary {
            color: #fff;
            background-color: #6c757d;
        }

        .badge-success {
            color: #fff;
            background-color: #28a745;
        }

        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }

        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }

        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }

        .badge-light {
            color: #212529;
            background-color: #f8f9fa;
        }

        .badge-dark {
            color: #fff;
            background-color: #343a40;
        }

        .product-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 120px;
            padding: 100px 0 120px;

            .selected {
                border: 1px solid #979797;
            }
        }

        .product-section-images {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-gap: 20px;
            margin-top: 20px;
        }

        .product-section-thumbnail {
            display: flex;
            align-items: center;
            border: 1px solid lightgray;
            min-height: 66px;
            cursor: pointer;

            &:hover {
                border: 1px solid #979797;
            }
        }

        .product-section-image {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #979797;
            padding: 30px;
            text-align: center;
            height: 400px;

            img {
                opacity: 0;
                transition: opacity .10s ease-in-out;
                max-height: 100%;
            }

            img.active {
                opacity: 1;
            }
        }

        .product-section-information {

            p {
                margin-bottom: 16px;
            }

        }



        .product-section-subtitle {
            font-size: 20px;
            font-weight: bold;
            color: $text-color-light;
        }

        .product-section-price {
            font-size: 38px;
            color: $text-color;
            margin-bottom: 16px;
        }

    </style>




@endsection

@section('content')

    {{--  <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <a href="{{ url(route('shop.index')) }}">Shop</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>{{ $product->name }}</span>
        </div>
    </div> <!-- end breadcrumbs -->  --}}

    @component('components.breadcrumbs')

        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span><a href="{{ route('shop.index') }}">Shop</a></span>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{ $product->name }}</span>

    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="product-section container">
        <div>

            <div class="product-section-image">
                <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage" width="300">
            </div>
            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="{{ productImage($product->image) }}" alt="product">
                </div>
                @if ($product->images)
                    @foreach (json_decode($product->images) as $image)
                        <div class="product-section-thumbnail">
                            <img src="{{ productImage($image) }}" alt="product">
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div>{!! $stockLevel !!}</div>
            <div class="product-section-price">{{ $product->presentPrice() }}</div>

            <p>
                {!! $product->description !!}
            </p>
            <p>&nbsp;</p>



            {{--  <a href="#" class="button">Add to Cart</a>  --}}

            @if($product->quantity > 0)
                <form action="{{ url(route('cart.store', $product->id)) }}" method="post">
                    @csrf

                    <button type="submit" class="button button-plain">Add to Cart</button>
                </form>
            @endif
        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')


@endsection

@section('extra-js')
    <script>

        (function() {
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((element) => element.addEventListener('click', thumbnailClick));


            function thumbnailClick(e) {

                currentImage.classList.remove('active');

                currentImage.addEventListener('transitionend', () => {

                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');

                })

                images.forEach((element) => element.classList.remove('selected'));
                this.classList.add('selected');
            }
        })();

    </script>
@endsection
