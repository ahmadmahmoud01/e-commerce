@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')

@endsection

@section('content')

    {{--  <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shopping Cart</span>
        </div>
    </div> <!-- end breadcrumbs -->  --}}

    @component('components.breadcrumbs')

        <a href="#">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>

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

    <div class="cart-section container">
        <div>

            @if (session()->has('success'))
                <div class="alert alert-success" style="color: rgb(0, 0, 0); padding:10px; background-color: #9dd386">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger" style="color: rgb(0, 0, 0); padding:10px; background-color: #d87373">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>

            <div class="cart-table">

                @forelse (Cart::content() as $item)
                    <div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <a href="{{ url(route('shop.show', $item->model->slug)) }}"><img src="{{ asset('storage/' . $item->model->image) }}"
                                    alt="item" class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item"><a
                                        href="{{ url(route('shop.show', $item->model->slug)) }}">{{ $item->model->name }}</a>
                                </div>
                                <div class="cart-table-description">{{ $item->model->details }}</div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                {{--  <a href="#">Remove</a> <br>  --}}
                                <form action="{{ url(route('cart.destroy', $item->rowId)) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="cart-option">Remove</button>

                                </form>
                                {{--  <a href="#">Save for Later</a>  --}}
                                <form action="{{ url(route('cart.switchToSaveForLater', $item->rowId)) }}" method="post">
                                    @csrf

                                    <button type="submit" class="cart-option">Save for later</button>

                                </form>
                            </div>
                            <div>
                                <select class="quantity" data-id="{{ $item->rowId }}">
                                    @for($i = 1; $i < 6; $i++)

                                        <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>

                                    @endfor

                                    {{--  <option {{ $item->qty == 1 ? 'selected' : '' }}>1</option>
                                    <option {{ $item->qty == 2 ? 'selected' : '' }}>2</option>
                                    <option {{ $item->qty == 3 ? 'selected' : '' }}>3</option>
                                    <option {{ $item->qty == 4 ? 'selected' : '' }}>4</option>
                                    <option {{ $item->qty == 5 ? 'selected' : '' }}>5</option>  --}}

                                </select>
                            </div>
                            <div>${{ $item->subtotal() }}</div>
                        </div>
                    </div> <!-- end cart-table-row -->

                @empty

                    <h3>No items in your cart!</h3>
                    <div class="cart-buttons">
                        <a href="{{ url(route('shop.index')) }}" class="button">Continue Shopping</a>
                    </div>
                @endforelse


            </div> <!-- end cart-table -->

            {{--  <a href="#" class="have-code">Have a Code?</a>

            <div class="have-code-container">
                <form action="#">
                    <input type="text">
                    <button type="submit" class="button button-plain">Apply</button>
                </form>
            </div> <!-- end have-code-container -->  --}}

            <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like
                    figuring out.
                </div>

                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        Tax(14%) <br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        ${{ Cart::subtotal() }} <br>
                        ${{ Cart::tax() }} <br>
                        <span class="cart-totals-total">${{ Cart::total() }}</span>
                    </div>
                </div>
            </div> <!-- end cart-totals -->

            <div class="cart-buttons">
                <a href="{{ url(route('shop.index')) }}" class="button">Continue Shopping</a>
                <a href="{{ url(route('checkout.index')) }}" class="button-primary">Proceed to Checkout</a>
            </div>

            <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For Later</h2>

            <div class="saved-for-later cart-table">

                @forelse (Cart::instance('saveForLater')->content() as $item)
                    <div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <a href="{{ route('shop.show', $item->model->slug) }}"><img
                                    src="{{ productImage($item->model->image) }}" alt="item"
                                    class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item"><a
                                        href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a>
                                </div>
                                <div class="cart-table-description">{{ $item->model->details }}</div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                {{--  <a href="#">Remove</a> <br>  --}}
                                <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="cart-options">Remove</button>

                                </form>
                                {{--  <a href="#">Move to cart</a>  --}}

                                <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                                    {{ csrf_field() }}

                                    <button type="submit" class="cart-options">Move to Cart</button>
                                </form>
                            </div>
                            {{-- <div>
                                <select class="quantity">
                                    <option selected="">1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div> --}}
                            <div>{{ $item->model->price }}</div>
                        </div>
                    </div> <!-- end cart-table-row -->

                @empty
                    <h3>No items saved for later</h3>
                @endforelse


            </div> <!-- end saved-for-later -->

        </div>

    </div> <!-- end cart-section -->

    @include('partials.might-like')

    @section('extra-js')

        <script src="{{ asset('js/app.js') }}"></script>
        <script>

            (function() {

                const classname = document.querySelectorAll('.quantity')

                Array.from(classname).forEach(function(element) {

                    element.addEventListener('change', function() {

                        const id = element.getAttribute('data-id')
                        axios.patch(`/cart/${id}`, {

                                quantity: this.value

                            })

                            .then(function(response) {

                                // console.log(response);
                                window.location.href = '{{ route('cart.index') }}'

                            })
                            .catch(function(error) {

                                // console.log(error);
                                window.location.href = '{{ route('cart.index') }}'

                            });
                    })
                })
            })();

        </script>

    @endsection


@endsection
