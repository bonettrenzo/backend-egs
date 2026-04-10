<?php
namespace App\Interface;

interface IProductSearchService
{
    public function search(string $query);
}