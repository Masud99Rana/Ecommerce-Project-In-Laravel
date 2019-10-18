<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function showHomePage()
    {
        $data = [];
        $data['products'] = Product::select(['id', 'title', 'slug', 'price', 'sale_price'])->where('active', 1)->paginate(9);

        return view('frontend.home', $data);
    }

    public function showCategoryProduct($slug)
    {
        $data = [];

        $category = Category::where('slug', $slug)->first();

        if ($category === null) {
            return redirect()->route('frontend.home');
        }

        $catName = Category::select('name')->where('slug', $slug)->first();

        $catProduct =$category->products()->where('active', 1)->paginate(9);


        return view('frontend.home', compact('catProduct','catName'));
    }

    public function sendSms()
    {   
        //muthofun
        // $client = new Client(['base_uri' => 'http://clients.muthofun.com:8901/esmsgw/', 'timeout' => 3.14]); // timeout => 2 
        // $response = $client->post('sendsms.jsp', [
        //     'form_params' => [
        //         'user' => '9Rana',
        //         'password' => 'RanAMR',
        //         'mobiles' => '88018345',
        //         'sms' => 'Hello! Boss.',
        //         'unicode' => 1,
        //     ],
        // ]);

        // echo $response->getStatusCode();
        // echo $response->getHeaderLine('content-type');
        // echo $response->getBody();
        
        // bulksmsbd
        $client = new Client(['base_uri' => 'http://66.45.237.70/', 'timeout' => 3.14]); // timeout => 2 
        $response = $client->post('api.php', [
            'form_params' => [
                'username'=>"a",
                'password'=>"M",
                'number'=>"880188",
                'message'=>"Hello! Boss."
            ],
        ]);

        echo $response->getStatusCode();
        echo $response->getHeaderLine('content-type');
        echo $response->getBody();

        // succees msg -> 200text/html; charset=UTF-81101|10173429|1

    }

    public function getPdf()
    {
        $product = Product::find(1);
        $pdf = \PDF::loadView('welcome', ['product' => $product]);

        return $pdf->download('product.pdf');
    }

    public function getCart()
    {
        $client = new Client(['base_uri' => 'https://sandbox.sslcommerz.com/', 'timeout' => 2]);
        $response = $client->post('gwprocess/v3/api.php', [
            'form_params' => [
                'store_id' => '',
                'store_passwd' => '@ssl',
                'total_amount' => '100',
                'currency' => 'BDT',
                'tran_id' => '1234',
                'success_url' => 'http://llc.mr',
                'fail_url' => 'http://llc.mr',
                'cancel_url' => 'http://llc.mr',
                'cus_name' => 'Test',
                'cus_email' => 'test@gmail.com',
                'cus_phone' => '88',
            ],
        ]);

        $response = $response->getBody()->getContents();
        $data = json_decode($response, true);

        header('Location: '.$data['GatewayPageURL']);
        exit();
    }
}
