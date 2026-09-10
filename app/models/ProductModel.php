<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primary_key = 'id';
    protected $fillable = ['product_name', 'description', 'price', 'quantity', 'created_at'];
    protected $guarded = ['id'];

    public function __construct()
    {
        parent::__construct();
    }
}