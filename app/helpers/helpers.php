<?php

function presentPrice($price) {

    $price  = (float) $price;
    return  number_format($price, 3, ".", 3);

}

function setActiveCategory($category, $output = 'active') {

    return request()->category == $category ? $output : '';

}

function productImage($path)
{
    return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg');
}
