<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $table = $request->query('table'); // e.g., 5

        $menu = [
            'Food' => [
                (object)['id' => 1, 'name' => 'មាន់ដុត', 'description' => 'មាន់ស្រស់ៗត្រង់ពីផ្សារ', 'price' => 5.99, 'image' => 'https://i.pinimg.com/736x/47/41/44/47414448166bc99e09878559ade8ed6d.jpg'],
                (object)['id' => 2, 'name' => 'បង្កាអាំង', 'description' => 'រសជាតិឆ្ងាញ់', 'price' => 3.49, 'image' => 'https://i.pinimg.com/736x/7e/26/d3/7e26d30b897d5610e5ee7a182103c54a.jpg'],
                (object)['id' => 3, 'name' => 'ម្ជូរគ្រឿង', 'description' => 'រសជាតិឆ្ងាញ់', 'price' => 4.25, 'image' => 'https://i.pinimg.com/736x/43/90/b4/4390b439c7766613b23c7090675fed3b.jpg'],
                (object)['id' => 4, 'name' => 'អាម៉ុក', 'description' => 'រសជាតិឆ្ងាញ់', 'price' => 4.25, 'image' => 'https://res.cloudinary.com/rainforest-cruises/images/c_fill,g_auto/f_auto,q_auto/v1620068179/Traditional-Cambodian-Dishes-To-Eat-Amok/Traditional-Cambodian-Dishes-To-Eat-Amok.jpg'],
            ],
            'Drink' => [
                (object)['id' => 5, 'name' => 'ទឹកសុទ្ធ', 'description' => 'រសជាតិឆ្ងាញ់', 'price' => 1.99, 'image' => 'https://imgs.search.brave.com/FLOJ6m0QLHnROfyImQZEcW0jJ0ShskUik2N6Pxebavw/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9wcm92/aWRhd2F0ZXIuY29t/L3dwLWNvbnRlbnQv/dXBsb2Fkcy8yMDI1/LzA2L1Byb3ZpZGEt/Ym90dGxlLTEuNW1M/LnBuZw'],
                (object)['id' => 6, 'name' => 'កូកា', 'description' => 'រសជាតិឆ្ងាញ់', 'price' => 2.50, 'image' => 'https://imgs.search.brave.com/9RcLAP9RsvPaKw1-DXfgtPDA1_Z2jhvxNPOZz0wtwts/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pLnBp/bmltZy5jb20vb3Jp/Z2luYWxzLzI4Lzc1/LzdmLzI4NzU3ZmI0/NzdlNzYyMGYxNjlm/MTEyOWVkNDIwODBl/LmpwZw'],
                (object)['id' => 7, 'name' => 'ទឹកអំពៅ', 'description' => 'រសជាតិឆ្ងាញ់', 'price' => 1.00, 'image' => '/images/water.jpg'],
            ],
        ];

        return view('food', compact('menu', 'table'));
    }
}
