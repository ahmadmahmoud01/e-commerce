<?php

function presentPrice($price) {

    return '$' . (int)$price / 100;

}

function setActiveCategory($category, $output = 'active') {

    return request()->category == $category ? $output : '';

}

function productImage($path)
{
    return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg');
}
