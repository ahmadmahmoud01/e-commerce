<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Ecommerce Example</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <style>

            header .with-background {
                background: url('/img/triangles.svg');
                background-size: cover;
                color: $white;

            .top-nav {
                display: flex;
                justify-content: space-between;
                padding: 40px 0;
                letter-spacing: 1.5px;

                .logo {
                    font-weight: bold;
                    font-size: 28px;
                }

                ul {
                    // display: flex;
                    // text-transform: uppercase;
                    // justify-content: space-between;
                    // width: 40%;

                    a {
                        color: $white;

                        &:hover {
                            color: darken($white, 10%);
                        }
                    }

                }
            }

            .hero {
                display: grid;
                grid-template-columns: 1fr 1fr; //repeat(2, 1fr)
                grid-gap: $gutter;
                padding-top: 20px;
                padding-bottom: 84px;

                .hero-image {
                    padding-left: 60px;
                }

                h1 {
                    font-size: 52px;
                    margin-top: 50px;
                }

                p {
                    margin: 40px 0 68px;
                }

                .button {
                    margin-right: 14px;
                }
            }
        }

        header {
            background: $gray-background;

            .top-nav {
                display: flex;
                justify-content: space-between;
                padding: 30px 0;
                letter-spacing: 1.5px;

                .logo {
                    font-weight: bold;
                    font-size: 28px;
                    color: $white;
                }

                ul {
                    display: flex;
                    text-transform: uppercase;
                    // justify-content: space-between;
                    // width: 40%;
                    padding-top: 8px;
                    font-weight: 400;

                    li {
                        margin-right: 38px;
                        color: #000;

                        &:last-child {
                            margin-right: 0;
                        }
                    }

                    a {
                        color: $white;

                        &:hover {
                            color: darken($white, 10%);
                        }
                    }

                    .cart-count {
                        display: inline-block;
                        // position: absolute;
                        // right: 0;
                        // top: -22px;
                        // right: -24px;
                        background: $cart-count;
                        color: $text-color;
                        line-height: 0;
                        border-radius: 50%;
                        font-size: 14px;
                    }

                    .cart-count span {
                        display: inline-block;
                        padding-top: 50%;
                        padding-bottom: 50%;
                        margin-left: 6px;
                        margin-right: 6px;
                    }

                }

            }

            .top-nav-left {
                display: flex;
            }

            .top-nav-right {
                display: flex;
                align-items: center;
            }
        }
    </style>

</head>

<body>
    <header class="with-background">
        <div class="top-nav container">

            <div class="top-nav-left">
                <div class="logo">Ecommerce</div>
                {{ menu('main', 'partials.menu.main-left') }}
            </div>

            <div class="top-nav-right">
                @include('partials.menu.main-right')
            </div>

        </div> <!-- end top-nav -->
        <div class="hero container">
            <div class="hero-copy">
                <h1>Laravel Ecommerce Demo</h1>
                <p>Includes multiple products, categories, a shopping cart and a checkout system with Stripe
                    integration.</p>
                <div class="hero-buttons">
                    <a href="#" class="button button-white">Blog Post</a>
                    <a href="#" class="button button-white">GitHub</a>
                </div>
            </div> <!-- end hero-copy -->

            <div class="hero-image">
                <img src="img/macbook-pro-laravel.png" alt="hero image">
            </div> <!-- end hero-image -->
        </div> <!-- end hero -->
    </header>

    <div class="featured-section">

        <div class="container">
            <h1 class="text-center">Laravel Ecommerce</h1>

            <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi,
                consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit
                sunt aliquid possimus temporibus enim eum hic.</p>

            <div class="text-center button-container">
                <a href="#" class="button">Featured</a>
                <a href="#" class="button">On Sale</a>
            </div>

            {{-- <div class="tabs">
                    <div class="tab">
                        Featured
                    </div>
                    <div class="tab">
                        On Sale
                    </div>
                </div> --}}

            <div class="products text-center">

                @forelse ($products as $product)
                    <div class="product">
                        <a href="{{ url(route('shop.show', $product->slug)) }}"><img
                                src="{{ productImage($product->image) }}" alt="product"></a>
                        <a href="{{ url(route('shop.show', $product->slug)) }}">
                            <div class="product-name">{{ $product->name }}</div>
                        </a>
                        <div class="product-price">${{ $product->price }}</div>
                    </div>

                @empty
                    <h3>No products found</h3>
                @endforelse

            </div> <!-- end products -->


            <div class="text-center button-container">
                <a href="{{ url(route('shop.index')) }}" class="button">View more products</a>
            </div>

        </div> <!-- end container -->

    </div> <!-- end featured-section -->

    <div class="blog-section">
        <div class="container">
            <h1 class="text-center">From Our Blog</h1>

            <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi,
                consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit
                sunt aliquid possimus temporibus enim eum hic.</p>

            <div class="blog-posts">
                <div class="blog-post" id="blog1">
                    <a href="#"><img src="/img/blog1.png" alt="Blog Image"></a>
                    <a href="#">
                        <h2 class="blog-title">Blog Post Title 1</h2>
                    </a>
                    <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi,
                        tenetur numquam ipsam reiciendis.</div>
                </div>
                <div class="blog-post" id="blog2">
                    <a href="#"><img src="/img/blog2.png" alt="Blog Image"></a>
                    <a href="#">
                        <h2 class="blog-title">Blog Post Title 2</h2>
                    </a>
                    <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi,
                        tenetur numquam ipsam reiciendis.</div>
                </div>
                <div class="blog-post" id="blog3">
                    <a href="#"><img src="/img/blog3.png" alt="Blog Image"></a>
                    <a href="#">
                        <h2 class="blog-title">Blog Post Title 3</h2>
                    </a>
                    <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi,
                        tenetur numquam ipsam reiciendis.</div>
                </div>
            </div>
        </div> <!-- end container -->
    </div> <!-- end blog-section -->

    @include('partials.footer')


</body>

</html>
