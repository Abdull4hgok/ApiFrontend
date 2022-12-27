<?php
  
namespace App\Http\Controllers;
  
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

  
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::get('http://127.0.0.1:8000/api/products');
        $products = $response->json();
      
        return view('products.index',compact('products'));
             
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token=session('token');
        if($token){
        return view('products.create');
        }
        else{
                        
            return redirect()->route('products.index')
            ->with('error','Unauthenticated');
        }
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token=session('token');
        if($token){
        $response = Http::withToken(
            session('token')
        )->post(
            'http://127.0.0.1:8000/api/add',[
                'name' => $request->name,
               'price' => $request->price,
                'description'=> $request->description,
       ]);

       
        
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
                    }
                    else{
                        
                        return redirect()->route('products.index')
                        ->with('error','Unauthenticated');
                    }
    }
  
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Request $request, $id)
    {
        // $response = Http::get('http://127.0.0.1:8000/api/detail/{id}');
        // $jsonData = $response->json();
        // return $response;
        // dd($response);
        // return view('products.show',compact('product'));
        // if (['status']==1) {

        
        $token=session('token');
        if($token){
            $response = Http::withToken(
                session('token')
            )->get(
                'http://127.0.0.1:8000/api/detail/' . $id,
            );
                    return view('products.show',compact('response'));

        }
        else{
            
            return redirect()->route('products.index')
            ->with('error','Unauthenticated');
        }
// }
// return ('abc');
    }
    
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, $id)
    {
        $token=session('token');
        if($token){

        $response = Http::withToken(
            session('token')
        )->get(
            'http://127.0.0.1:8000/api/detail/' . $id,
        );
        //  dd($response);
    //     $response = Http::get('http://127.0.0.1:8000/api/edit/' . $id 
    // );
    //     $product = $response->json();
            return view('products.edit',compact('response'));
    }
    else {
        return redirect()->route('products.index')
        ->with('error','Unauthenticated');    }


         
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $req)
    // {
    //     $response = Http::withToken(
    //         session('token')
    //     )->post(
    //         'http://127.0.0.1:8000/api/update',  
    //         ['id' => $req->id, 'name' => $req->name, 'price' => $req->price, 'description' => $req->description]
    //     );
    //     return($response);
    //     if ($response['status'] == 0) {

    //         return redirect('/companies')->with('danger', 'Şirket düzenlenmedi lütfen girdiğiniz bilgileri tekrar kontrol edip doldurunuz ');
    //     }
    //     return redirect('/companies')->with('success', 'Şirket başarılı bir şekilde düzenlendi');
    //     compact('response');
    // }
    public function update(Request $request,$id, Product $product)
{
        
        
        $response = Http::withToken(
            session('token')
        )->post(    
            'http://127.0.0.1:8000/api/update/'.$id,
            [
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description
            ]
        )->json();
        // $response = Http::post('http://127.0.0.1:8000/api/update/{id}',[
        //     'name' => $request->name,
        //     'price' => $request->price,
        //     'description'=> $request->description
        // ]);
        // $jsonData = $response->json();
    // return view('products.edit',compact('response'));

        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        $token=session('token');
        if($token){

        $response = Http::withToken(
            session('token')
        )->get(
            'http://127.0.0.1:8000/api/delete/' . $id,
        );
       
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
    else {
        return redirect()->route('products.index')
        ->with('error','Unauthenticated');    
    }
    }
}