<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;
use DB;
use DateTime;

class ProductController extends Controller
{
    // dashboard page protection
	public function add2cart(Request $request){
		
		if ($request->session()->has('user_email')) {
			$email = Session::get('user_email');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('email',$email)->first();
		   	if($user_details->role=="client"){
                if ($request->isMethod('post') && !empty($request->input('quantity'))) {
                   
                    $id=$request->input('id');
                    $quantity=$request->input('quantity');
                    
                    if($request->session()->has('cart')){
                        if (Session::has("cart".$id)) { //check item exist in products array
                                // Session::forget('cart'.$id); //unset old array item
                            }else{
                                $cart_array = [
                                    "pro_id" => $id,
                                    "quantity"  => $quantity
                            ];
                            $request->session()->put('cart', [$id => $cart_array]);
                            var_dump(Session::get('cart'));die();
                            }
                    }else{
                        $cart_array = [
                            "pro_id" => $id,
                            "quantity"  => $quantity
                        ];
                
                        $request->session()->put('cart', [$id => $cart_array]);
                        
                       echo "<pre>"; var_dump(Session::get('cart')); echo "</pre>"; die(); 
                    }

                    Session::flash('error','Error!');
			        return redirect()->back();
                    
                }else{
                    return view('dashboard', compact(['user_details','user_id']));
                }
		   	}else{
				Session::flash('error','You are not a client!');
			    return redirect()->back();
		   	}
		}else{
			Session::flash('error','You are not loged in');
			return redirect()->route('login_default');
		}
	}
}
