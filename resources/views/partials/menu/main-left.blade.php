<ul>
    @foreach($items as $menu_item)

        <li>
            <a href="{{ $menu_item->link() }}" style="margin-left: 70px">
                {{ $menu_item->title }}</a>

                @if($menu_item->title == 'Cart')
                    @if(Cart::instance('default')->count() > 0)
                        <span class="cart-count">
                            <span>{{ Cart::instance('default')->count() }}</span>
                        </span>
                    @endif
                @endif
        </li>



    @endforeach
</ul>
