<?php

/**
 * Converts the laravel length aware paginator to a good format
 */
function my_paginator($paginator)
{
    $fb = new stdClass();
    //convert lengthAwarePaginator to array
    $myarray = $paginator->toArray();

    $fb->status = "success";
    $fb->from = $myarray['from'];
    $fb->to = $myarray['to'];
    $fb->per_page = $myarray['per_page'];
    $fb->current_page = $myarray['current_page'];
    $fb->last_page = $myarray['last_page'];
    $fb->total = $myarray['total'];
    $fb->data = $myarray['data'];

    return $fb;
}
