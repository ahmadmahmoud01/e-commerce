<ul>
    @guest
        <li><a href="{{ url(route('register')) }}" style="width: 20px">Register</a></li>
        <li><a href="{{ url(route('login')) }}" style="margin-left: 70px">Login</a></li>
    @endguest

    @auth
        <li style="margin-right: 50px; display:inline" disabled>{{ auth()->user()->name }}</li>
        <li>
            {{--  <form action="{{ url(route('logout')) }}" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>  --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('LogOut') }}
                </x-dropdown-link>

            </form>
        </li>
    @endauth
    <li>
        <a href="{{ url(route('cart.index')) }}" style="margin-left: 90px">Cart
            @if(Cart::instance('default')->count() > 0)
                <span class="cart-count">
                    <span>{{ Cart::instance('default')->count() }}</span>
                </span>
            @endif
        </a>
    </li>
    {{--  @foreach($items as $menu_item)

        <li>
            <a href="{{ $menu_item->link() }}">
                {{ $menu_item->title }}</a>

                @if($menu_item->title == 'Cart')

                @endif
        </li>



    @endforeach  --}}
</ul>
