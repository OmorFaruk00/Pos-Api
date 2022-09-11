<?php
namespace App\Http\Services;

use App\model\Product;




class ProductService 
{
    
    public function storeProduct($request)
    {
       $data['name'] = $request->name;
       $data['product_code'] = $request->code;
       return $data;
    // return "product service";
        
    }
    public function storeUser()
    {
       dd("user service") ;
        
    }
}