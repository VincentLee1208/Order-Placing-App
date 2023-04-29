<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Image;
use DB;
use DateTime;
use Session;

class DashboardController extends Controller {

   	// dashboard page protection
	public function dashboard(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
				
				$orders = DB::table('orders')->where('status',0)->orderby('id','desc')->get();
				$non_pendings=DB::table('orders')->where('status',1)->orderby('id','desc')->get();
				$trackeds=DB::table('orders')->where('status',2)->orderby('id','desc')->get();
				$completeds=DB::table('orders')->where([['status','=',3],['keep','=',0]])->orderby('created','desc')->get();
				return view('admin_dashboard', compact(['user_details','orders','non_pendings','trackeds','completeds']));
		   	}elseif($user_details->role=="client"){
		   		$promoted = DB::table('products')->orderby('category','asc')->orderby('item_code','asc')->where('promoted',1)->get();
				$products = DB::table('favourites')->where('user_id',$user_id)->orderBy('category', 'asc')
                ->orderBy('item_code', 'asc')->get();
				return view('dashboard', compact(['user_details','products','user_id','promoted']));

		   	}elseif($user_details->role=="warehouse"){
		   		return redirect()->route('tracking');
		   	}else{
		   		return "ami ki kormu?";
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// dashboard page protection
	public function favourite_list(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
				$users = DB::table('admins')->where('role','client')->get();
		   		return view('favourite_list', compact(['user_details','users','user_id']));
		   	}else{
				return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// dashboard page protection
	public function favourite_list_individual(Request $request){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$client_id=$request->input('client_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="admin" || $user_details->role=="staff"){
					$users = DB::table('admins')->where('role','client')->get();
					return redirect('favourite_list'.'/'.$client_id);
					return view('favourite_list', compact(['user_details','user_id','client_id','users']));
				}else{
					return redirect()->route('dashboard');
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// dashboard page protection
	public function favourite_list_individual_id(Request $request,$client_id){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="admin" || $user_details->role=="staff"){
					$users = DB::table('admins')->where('role','client')->get();
					$favourites = DB::table('favourites')->where('user_id',$client_id)->orderBy('id', 'desc')->get();
					return view('favourite_list', compact(['user_details','user_id','client_id','users','favourites']));
				}else{
					return redirect()->route('dashboard');
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	
	// dashboard page protection
	public function favourite(Request $request){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="admin" || $user_details->role=="staff"){
					return redirect()->route('dashboard');
				}else{
					$promoted = DB::table('products')->orderby('category','asc')->orderby('item_code','asc')->where('promoted',1)->get();
					$products=DB::select('SELECT * FROM (products) Order By category ASC,item_code ASC');
					return view('favourite', compact(['user_details','products','user_id','promoted']));
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// dashboard page protection
	public function marketing(Request $request){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="admin" || $user_details->role=="staff"){
					if ($request->isMethod('get')) {
						$welcome = DB::table('welcome_text')->where('id',1)->first();
						$thankyou = DB::table('welcome_text')->where('id',2)->first();
                        $thankyou2 = DB::table('welcome_text')->where('id',3)->first();
                        $thankyou3 = DB::table('welcome_text')->where('id',4)->first();
						$products=DB::select('SELECT * FROM (products) Order By category ASC,item_code ASC');
						return view('marketing', compact(['user_details','products','user_id','welcome','thankyou','thankyou2','thankyou3']));
					}else{
						$id=$request->input('id');
						// $bumpid_check=DB::select('SELECT * FROM (bumpid_pin) WHERE bumpid=?',[$bumpid]);
						// // check email duplicate or not
						// if($bumpid_check){
						// 	Session::flash('error','This bump id is already created');
						// 	return redirect()->back();
						// }

						$image = $request->banner;
						if(!empty($image)){
							
						$name = time().'.'.$image->getClientOriginalExtension();
						$destinationPath = base_path('assets/banners');
						$image->move($destinationPath, $name);
						$image = Image::make('assets/banners/'.$name)->orientate()->fit(1100, 350)->save();

						$banner = 'assets/banners/' . $name;

						}else{
						   $banner='';
						}
						$product_update=DB::update('UPDATE products SET promoted=?,banner=? WHERE id=?',[1,$banner,$id]);
						if ($product_update) {
							Session::flash('message','Banner added succesfully');
						}
						return redirect()->back();
					}
				}else{
					return redirect()->route('dashboard');
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}



	// dashboard page protection
	public function welcome_text(Request $request){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="admin" || $user_details->role=="staff"){
					if ($request->isMethod('post')) {
						if($request->has('form1')) {
							$texts = $request->input('texts');
							$welcome_text=DB::update('UPDATE welcome_text SET texts=? WHERE id=?',[$texts,1]);
							if ($welcome_text) {
								Session::flash('message','Note updated');
							}
							return redirect()->route('marketing');
						}else if($request->has('form2')) {
							$texts = $request->input('texts2');
							$texts2 = $request->input('texts3');
                            $texts3 = $request->input('texts4');
							$thankyou_text1=DB::update('UPDATE welcome_text SET texts=? WHERE id=?',[$texts,2]);
							$thankyou_text2=DB::update('UPDATE welcome_text SET texts=? WHERE id=?',[$texts2,3]);
                            $thankyou_text3=DB::update('UPDATE welcome_text SET texts=? WHERE id=?',[$texts3,4]);
							if($thankyou_text1 && $thankyou_text2) {
								Session::flash('message','Note updated');
							}
							return redirect()->route('marketing');
						}	
					}else{
						
						return redirect()->route('dashboard');
					}
				}else{
					return redirect()->route('dashboard');
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}






	// dashboard page protection
	public function promoted(Request $request){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="client"){
					if ($request->isMethod('get')) {
						$products = DB::table('products')->orderby('category','asc')->orderby('item_code','asc')->where('promoted',1)->get();
						return view('promoted', compact(['user_details','products','user_id']));
					}else{
						return redirect()->back();
					}
				}else{
					return redirect()->route('dashboard');
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// dashboard page protection
	public function promoted_products(Request $request){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="admin" || $user_details->role=="staff"){
					if ($request->isMethod('get')) {
						$products = DB::table('products')->orderby('category','asc')->orderby('item_code','asc')->where('promoted',1)->get();
						return view('promoted_products', compact(['user_details','products','user_id']));
					}else{
						$product_ids = $request->input('product_id');

						foreach ($product_ids as $key => $product_id) {
							$product_update=DB::update('UPDATE products SET promoted=?,banner=? WHERE id=?',[0,NULL,$product_id]);
						}

						Session::flash('message','Products removed!');
						return redirect()->back();
					}
				}else{
					return redirect()->route('dashboard');
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// dashboard page protection
	public function add2fav(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="admin" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('product_id'))) {
					$client_id = $request->input('client_id');
					$product_ids = $request->input('product_id');
					$item_codes = $request->input('item_code');
					$categorys = $request->input('category');
					foreach($product_ids as $key1 => $product_id){
						$product_details=DB::table('products')->where('id',$product_id)->first();
						$model_check=DB::table('favourites')->where([['user_id',$client_id],['product_id',$product_id]])->first();
						// check email duplicate or not
						if($model_check){
							Session::flash('error','This product already saved in your favourites');
						}else{
							$regi=DB::insert('insert into favourites (user_id,product_id,category,item_code) values(?,?,?,?)',[$client_id,$product_id,$product_details->category,$product_details->item_code]);
							Session::flash('message','Product saved successfully in dashboard');
						}
					}
					return redirect()->back();
				}else{
					Session::flash('error','Something Wrong or fields may empty!');
					return redirect()->route('dashboard');
				}
		   	}else{
				Session::flash('error','You are not admin');
				return redirect()->route('login_default');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	//delete_model
	public function delete_saved_product(Request $request,$client_id){
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="admin" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('product_id'))) {
					$product_ids = $request->input('product_id');
					foreach($product_ids as $product_id){
						$delete_pro=DB::delete('DELETE FROM favourites WHERE user_id=? AND id=?',[$client_id,$product_id]);
					}	
					Session::flash('message','Product successfully deleted');
					return redirect()->back();
				}
		}
		}else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
	}
	//delete_slider

	// add2cart page protection
	public function add2cart(Request $request){
		// new code applying
		if ($request->session()->has('username')) {
			
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="client"){
				if ($request->isMethod('post') && !empty($request->input('quantity'))) {
					$id=$request->input('id');
					$quantity=$request->input('quantity');
					
					if (Session::has('cart')){
						// var_dump(Session::get('cart.'.$id.'.quantity'));die();
						if (Session::has("cart.".$id)) {
							$cart_array = [
								"pro_id" => $id,
								"quantity"  => $quantity+Session::get('cart.'.$id.'.quantity')
							];
							$request->session()->put('cart.'.$id, $cart_array);
							
						}else{
							$cart_array = [
								"pro_id" => $id,
								"quantity"  => $quantity
							];
							
							$request->session()->put('cart.'.$id, $cart_array);
							
						}
						
						
					}else{
						
						$cart_array = [
							"pro_id" => $id,
							"quantity"  => $quantity
						];
						
						$request->session()->put('cart.'.$id, $cart_array);

					}
					Session::flash('message','Product added to cart');
					return redirect()->back();
					// return redirect('/dashboard'.'#'.$id);
				}else{
					Session::flash('error','Something went wrong');
					return redirect()->back();
				}
			}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}

	}

	public function add2cart_reorder(Request $request){
		// new code applying
		if ($request->session()->has('username')) {
			
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="client"){
				if ($request->isMethod('post') && !empty($request->input('quantity'))) {
					$ids=$request->input('id');
					$quantitys=$request->input('quantity');

					foreach ($ids as $key => $id) {
						foreach ($quantitys as $mey => $quantity) {
							if ($key==$mey) {
								if (Session::has('cart')){
								// var_dump(Session::get('cart.'.$id.'.quantity'));die();
								if (Session::has("cart.".$id)) {
									$cart_array = [
										"pro_id" => $id,
										"quantity"  => $quantity+Session::get('cart.'.$id.'.quantity')
									];
									$request->session()->put('cart.'.$id, $cart_array);
									
								}else{
									$cart_array = [
										"pro_id" => $id,
										"quantity"  => $quantity
									];
									
									$request->session()->put('cart.'.$id, $cart_array);
									
								}
								
								
							}else{
								
								$cart_array = [
									"pro_id" => $id,
									"quantity"  => $quantity
								];
								
								$request->session()->put('cart.'.$id, $cart_array);

							}
							}
						}
					}
					
					
					Session::flash('message','Product added to cart');
					return redirect()->back();
					// return redirect('/dashboard'.'#'.$id);
				}else{
					Session::flash('error','Something went wrong');
					return redirect()->back();
				}
			}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}

	}

	// products for admin
	public function clearSingle(Request $request,$id){
	
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
				if($user_details->role=="client"){
					Session::forget('cart.'.$id);
					Session::flash('message','the product is removed from cart');
					return redirect()->back();
				}else{
					return redirect()->route('dashboard');
				}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// products for admin
	public function checkout(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="client"){
				if ($request->session()->has('cart') && count(Session::get('cart'))>0) {
					$welcome = DB::table('welcome_text')->where('id',1)->first();
					$locations = DB::table('locations')->where('user_id',$user_id)->get();
					return view('checkout', compact(['user_details','locations','welcome']));
				}else{
					
					Session::flash('error','Cart is empty');
					return redirect()->route('dashboard');
				}
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// products for admin
	public function products(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
				   $products=DB::select('SELECT * FROM (products)');
				   $categories=DB::select('SELECT * FROM (categories)');
		   		return view('products', compact(['user_details','products','categories']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// save_product for admin
	public function product_save(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('item_code'))) {
					$item_code=$request->input('item_code');
					$category=$request->input('category');
					$descriptions=$request->input('descriptions');
					$item_code_checking=DB::select('SELECT * FROM (products) WHERE item_code=?',[$item_code]);
					// check email duplicate or not
					if($item_code_checking){
						Session::flash('error','This item code already added');
						return redirect()->back();
					}

					$image = $request->catalogue;
					if(!empty($image)){
						// if (!empty($user_details->image)) {
						// 	unlink($user_details->image);
						// }
					$name = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = base_path('assets/products');
					$image->move($destinationPath, $name);
					$image = Image::make('assets/products/'.$name)->orientate()->fit(1080, 1080)->save();
					
					$image_url = 'assets/products/' . $name;
					}else{
				       $image_url="";
					}
					
					$insert_product=DB::insert('insert into products (item_code,category,descriptions,catalogue) values(?,?,?,?)',[$item_code,$category,$descriptions,$image_url]);

					if ($insert_product) {
						Session::flash('message','Product added succesfully');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// update_product for admin
	public function product_update(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('item_code'))) {
					$id=$request->input('id');
					$item_code=$request->input('item_code');
					$category=$request->input('category');
					$descriptions=$request->input('descriptions');
					$old_url=$request->input('image_url');
					// $bumpid_check=DB::select('SELECT * FROM (bumpid_pin) WHERE bumpid=?',[$bumpid]);
					// // check email duplicate or not
					// if($bumpid_check){
					// 	Session::flash('error','This bump id is already created');
					// 	return redirect()->back();
					// }

					$image = $request->catalogue;
					if(!empty($image)){
						// if (!empty($old_url)) {
						// 	unlink($old_url);
						// }
					$name = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = base_path('assets/products');
					$image->move($destinationPath, $name);
					$image = Image::make('assets/products/'.$name)->orientate()->fit(1080, 1080)->save();
					
					$image_url = 'assets/products/' . $name;

					}else{
				       $image_url=$request->input('image_url');
					}
					$product_update=DB::update('UPDATE products SET item_code=?,category=?,descriptions=?,catalogue=? WHERE id=?',[$item_code,$category,$descriptions,$image_url,$id]);
					

					if ($product_update) {
						Session::flash('message','Product added succesfully');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	//delete_user
	public function product_delete(Request $request,$id){
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="admin" || $user_details->role=="staff"){
				
				$pro_details = DB::table('products')->where('id',$id)->first();
				// if (!empty($pro_details->catalogue)) {
				// 	unlink($pro_details->catalogue);
				// }
				$delete_user=DB::delete('DELETE FROM products WHERE id=?',[$id]);
				Session::flash('message','Product successfully deleted');
				
		   		return redirect()->back();
			}else{
				Session::flash('error','You cannot delete product');
		   		return redirect()->back();
			}

		  
		  
		}else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
	}
	//delete_user


	// Orders for admin
	public function history(Request $request){
		
		if ($request->session()->has('username')) {
			$user_id = Session::get('user_id');
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="client"){
				// $orders=DB::select('SELECT * FROM (orders) Order By order_date DESC');
				$orders = DB::table('orders')->where('user_id',$user_id)->orderBy('id', 'desc')->get();
		   		return view('history', compact(['user_details','orders']));
		   	}else{
		   		if ($request->isMethod('post') && !empty($request->input('client_id'))) {
		   			$user_id= $request->input('client_id');
		   		}
		   		$users = DB::table('admins')->where('role','client')->get();
		   		$orders = DB::table('orders')->where('user_id',$user_id)->orderBy('id', 'desc')->get();
		   		return view('client_wise_order', compact(['user_details','orders','users']));
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// update_product for admin
	public function update_to_tracking(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('created'))) {
					$id=$request->input('id');
					$created=$request->input('created');
					
					$order_update=DB::update('UPDATE orders SET created=?,status=? WHERE id=?',[$created,1,$id]);
					if ($order_update) {
						Session::flash('message','Invoice created!');
						return redirect()->route('tracking');
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	//change_date of order
	public function change_date(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="staff" || $user_details->role=="warehouse"){
				if ($request->isMethod('post') && !empty($request->input('id'))) {
					$id=$request->input('id');
					$created=$request->input('created');
					
					$order_update=DB::update('UPDATE orders SET created=?,status=? WHERE id=?',[$created,2,$id]);
					if ($order_update) {
						Session::flash('message','Invoice updated!');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Something Wrong');
				}
			}else{
					return redirect()->route('dashboard');
			}
		}else{
			Session::flash('error','You are not logged in');
		 	return redirect()->route('login_default');
		}
	}


	// update_product for admin
	public function order_update(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="warehouse" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('id'))) {
					$id=$request->input('id');
					$method=$request->input('method');
					$invoice_no=$request->input('invoice_no');
					$location=$request->input('location');
					$rep=$request->input('rep');
					$comment=$request->input('comment');
					
					$order_update=DB::update('UPDATE orders SET method=?,invoice_no=?,location=?,rep=?,comment=?,status=? WHERE id=?',[$method,$invoice_no,$location,$rep,$comment,2,$id]);
					if ($order_update) {
						Session::flash('message','Invoice updated!');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}
	
	// update_note for admin
	public function update_note(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="warehouse" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('order_id'))) {
					$order_id=$request->input('order_id');
					$note=$request->input('note');
					
					$order_update=DB::update('UPDATE orders SET note=? WHERE id=?',[$note,$order_id]);
					if ($order_update) {
						Session::flash('message','Note updated!');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// update_product for admin
	public function complete_order(Request $request,$id){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="warehouse" || $user_details->role=="staff"){
				if ($request->isMethod('get') && !empty($id)) {
					
					
					$order_update=DB::update('UPDATE orders SET status=? WHERE id=?',[3,$id]);
					if ($order_update) {
						Session::flash('message','Order completed!');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// Orders for admin
	public function tracking(Request $request){
		
		if ($request->session()->has('username')) {
			$user_id = Session::get('user_id');
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="warehouse" || $user_details->role=="staff"){
				// $orders=DB::select('SELECT * FROM (orders) Order By order_date DESC');
				$not_filleds = DB::table('orders')->where('status',1)->orderBy('created', 'asc')->get();
				$reps = DB::table('reps')->get();
				$allorders = DB::table('orders')->where('status',2)->orderBy('created', 'asc')->get();
				if (count($allorders)>0) {
					foreach($allorders as $key => $order){
	               	   $allcreated[]=$order->created;
	               	}

	                $createds = array_unique($allcreated);
	                return view('tracking', compact(['user_details','createds','not_filleds','reps']));
				}else{
					
				}
				

		   		return view('tracking', compact(['user_details','not_filleds','reps']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// Orders for admin
	public function archive(Request $request){
		
		if ($request->session()->has('username')) {
			$user_id = Session::get('user_id');
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
				// $orders=DB::select('SELECT * FROM (orders) Order By order_date DESC');
				
		   		$tasks = DB::table('tasks')->where('status',1)->get();
				$allorders = DB::table('orders')->where('status',3)->orderBy('created', 'asc')->get();
				if (count($allorders)>0) {
					foreach($allorders as $key => $order){
	               	   $allcreated[]=$order->created;
	               	}

	                $createds = array_unique($allcreated);
	                return view('archive', compact(['user_details','createds','tasks']));
				}else{
					
				}
				

		   		return view('archive', compact(['user_details','tasks']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// all users for admin
	public function task(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff" || $user_details->role=="warehouse"){
		   		
		   		$tasks = DB::table('tasks')->where('status',0)->get();
		   		return view('task', compact(['user_details','tasks']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	//save user
	public function task_save(Request $request){

		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff" || $user_details->role=="warehouse"){
		   		if ($request->isMethod('post')) {
		   			$company_name=$request->input('company_name');
		   			$dates=$request->input('dates');
		   			$method=$request->input('method');
					$return_item=$request->input('return_item');
					$exchange=$request->input('exchange');
					$invoice=$request->input('invoice');
					$received=$request->input('received');
					$on_rack=$request->input('on_rack');
					$good_condition=$request->input('good_condition');
					$memo=$request->input('memo');
					$comment=$request->input('comment');
					$joined_date=date('Y-m-d H:i:s');

						$regi=DB::insert('insert into tasks (dates,method,company_name,return_item,exchange,invoice,received,on_rack,good_condition,memo,comment) values(?,?,?,?,?,?,?,?,?,?,?)',[$dates,$method,$company_name,$return_item,$exchange,$invoice,$received,$on_rack,$good_condition,$memo,$comment]);
						if ($regi) {
							Session::flash('message','Task created successfully');
							return redirect()->back();
						}else{
							Session::flash('error','Not successful!');
							return redirect()->back();
						}
					
				}else{
					Session::flash('error','Something Went Wrong');
					return redirect()->back();
				}
		   	}else{
		   		Session::flash('error','You are not permitted to create account!');
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	
	}


	//update_user
	public function task_update(Request $request){

		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff" || $user_details->role=="warehouse"){
		   		if ($request->isMethod('post')) {
		   			$id=$request->input('id');
		   			$company_name=$request->input('company_name');
		   			$dates=$request->input('dates');
		   			$method=$request->input('method');
					$return_item=$request->input('return_item');
					$exchange=$request->input('exchange');
					$invoice=$request->input('invoice');
					$received=$request->input('received');
					$on_rack=$request->input('on_rack');
					$good_condition=$request->input('good_condition');
					$memo=$request->input('memo');
					$comment=$request->input('comment');
					
						$update_task=DB::update('UPDATE tasks SET dates=?,method=?,company_name=?,return_item=?,exchange=?,invoice=?,received=?,on_rack=?,good_condition=?,memo=?,comment=? WHERE id=?',[$dates,$method,$company_name,$return_item,$exchange,$invoice,$received,$on_rack,$good_condition,$memo,$comment,$id]);
						
						if ($update_task) {
							Session::flash('message','Task updated successfully');
							return redirect()->back();
						}else{
							Session::flash('error','Not successful!');
							return redirect()->back();
						}
					
				}else{
					Session::flash('error','Something Went Wrong');
					return redirect()->back();
				}
		   	}else{
		   		Session::flash('error','You are not permitted to create account!');
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}

	}


	//delete_user
	public function complete_task(Request $request,$id){
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			
			if ($user_details->role=="admin" || $user_details->role=="staff" || $user_details->role=="warehouse") {
				$update_task=DB::update('UPDATE tasks SET status=? WHERE id=?',[1,$id]);
	   			if ($update_task) {
	   				Session::flash('message','Archived successfully');
	   			}
			
		   		return redirect()->back();
			}else{
				Session::flash('error','You cannot delete task');
		   		return redirect()->route('users');
			}

		  
		  
		}else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
	}

    public function task_delete(Request $request,$id) {
        if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();

            if($request->isMethod('get') && $user_details->role=="admin" || $user_details->role=="staff"){
				
                $delete_task=DB::delete('DELETE FROM tasks WHERE id=?',[$id]);
                
                Session::flash('message','Task deleted');
                return redirect()->back();
            }else{
                return redirect()->route('dashboard');
            }
        
        }else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
    }

	//delete_user


		// all users for admin
	public function rep(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
		   		
		   		$reps = DB::table('reps')->get();
		   		return view('reps', compact(['user_details','reps']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	//save user
	public function rep_save(Request $request){

		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
		   		if ($request->isMethod('post')) {
		   			$name=$request->input('name');
		   				$rep_check = DB::table('reps')->where('name',$name)->first();
		   				if ($rep_check) {
		   					Session::flash('message','This rep already exist!');
							return redirect()->back();
		   				}
						$regi=DB::insert('insert into reps (name) values(?)',[$name]);
						if ($regi) {
							Session::flash('message','rep created successfully');
							return redirect()->back();
						}else{
							Session::flash('error','Not successful!');
							return redirect()->back();
						}
					
				}else{
					Session::flash('error','Something Went Wrong');
					return redirect()->back();
				}
		   	}else{
		   		Session::flash('error','You are not permitted to create account!');
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	
	}


	//update_user
	public function rep_update(Request $request){

		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff" || $user_details->role=="warehouse"){
		   		if ($request->isMethod('post')) {
		   			$id=$request->input('id');
		   			$name=$request->input('name');

						$update_rep=DB::update('UPDATE reps SET name=? WHERE id=?',[$name,$id]);
						if ($update_rep) {
							Session::flash('message','rep updated successfully');
							return redirect()->back();
						}else{
							Session::flash('error','Not successful!');
							return redirect()->back();
						}
					
				}else{
					Session::flash('error','Something Went Wrong');
					return redirect()->back();
				}
		   	}else{
		   		Session::flash('error','You are not permitted to create account!');
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}

	}


	//delete_user
	public function delete_rep(Request $request,$id){
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			
			if ($user_details->role=="admin" || $user_details->role=="staff") {
				$update_rep=DB::delete('DELETE FROM reps WHERE id=?',[$id]);
	   			if ($update_rep) {
	   				Session::flash('message','Deleted successfully');
	   			}
			
		   		return redirect()->back();
			}else{
				Session::flash('error','You cannot delete rep');
		   		return redirect()->route('users');
			}

		  
		  
		}else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
	}
	//delete_user



	public function print(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="warehouse" || $user_details->role=="staff"){
		   		if ($request->isMethod('post')){
		   			if (empty($request->input('order_id'))) {
		   				Session::flash('error','You did not select any order!');
		   				return redirect()->back();
		   			}
		   			// input the case
		   			 switch ($request->input('action')) {
					    case 'print':
					        // do printing
					    	$print=DB::select('SELECT * FROM (print)');
							if (count($print)>0) {
								$delete=DB::delete('DELETE FROM print');
								$order_ids=$request->input('order_id');
								foreach ($order_ids as $key => $order_id) {
									$insert_print=DB::insert('insert into print (order_id) values(?)',[$order_id]);
								}
							}else{
								$order_ids=$request->input('order_id');
								foreach ($order_ids as $key => $order_id) {
									$insert_print=DB::insert('insert into print (order_id) values(?)',[$order_id]);
								}
							}
							$print_ids = DB::table('print')->orderby('sort_id','asc')->get();
							return view('print', compact(['user_details','print_ids','user_id']));
					       // end printing
					        break;

					    case 'complete':
					        // do completing
					    	$order_ids=$request->input('order_id');
								foreach ($order_ids as $key => $order_id) {
									$order_update=DB::update('UPDATE orders SET status=? WHERE id=?',[3,$order_id]);
								}
								Session::flash('message','Marked orders are completed and gone to archive!');
								return redirect()->back();
					       // end completing
					        break;

					         case 'delivery':
					        // do completing
					    	$order_ids=$request->input('order_id');
								foreach ($order_ids as $key => $order_id) {
									$order_update=DB::update('UPDATE orders SET delivery=? WHERE id=?',[1,$order_id]);
								}
								Session::flash('message','Marked orders are move to out for delivery!');
								return redirect()->back();
					       // end completing
					        break;

					        case 'pending':
					        // do completing
					    	$order_ids=$request->input('order_id');
								foreach ($order_ids as $key => $order_id) {
									$order_update=DB::update('UPDATE orders SET delivery=? WHERE id=?',[0,$order_id]);
								}
								Session::flash('message','Marked orders are move to out for delivery!');
								return redirect()->back();
					       // end completing
					        break;

					    
					}
		   			//end
		   		}else{
		   			$print_ids = DB::table('print')->orderby('sort_id','asc')->get();
		   			return view('print', compact(['user_details','print_ids','user_id']));
		   		}
				
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}



	// sortable wine for list
	public function sortable(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
			
			
			$post_order = isset($request->post_order_ids) ? $request->post_order_ids : [];

			if(count($post_order)>0){
				for($order_no= 0; $order_no < count($post_order); $order_no++)
				{
				 $update=DB::update('UPDATE print SET sort_id=? WHERE order_id=?',[($order_no+1),$post_order[$order_no]]);
				}
				echo true; 
			}else{
				echo false; 
			}
						   		
		  
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}




	public function create_order(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
				$users = DB::table('admins')->where('role','client')->get();
		   		return view('create_order', compact(['user_details','users','user_id']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// Orders for admin
	public function orders(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
				$products=DB::select('SELECT * FROM (products)');
				$users = DB::table('admins')->where('role','client')->get();
		   		return view('orders', compact(['user_details','products','users','user_id']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// Orders for admin
	public function order_delete(Request $request,$id){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($request->isMethod('get') && $user_details->role=="admin" || $user_details->role=="staff"){
				
   				$delete_order=DB::delete('DELETE FROM orders WHERE id=?',[$id]);
   				
   				Session::flash('message','Order deleted');
   				return redirect()->back();
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	// Orders for admin
	public function delete_complted_orders(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($request->isMethod('get') && $user_details->role=="admin" || $user_details->role=="staff"){
   				
   				$delete_order=DB::update('UPDATE orders SET keep=? WHERE status=?',[1,3]);
   				
   				Session::flash('message','All completed orders deleted');
   				return redirect()->back();
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}



	// save_product for admin
	public function order_save(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="client" || $user_details->role=="admin" || $user_details->role=="staff"){
				if ($request->isMethod('post')) {
					
					if ($user_details->role=="client" && empty($request->input('location_id'))) {
						Session::flash('error','You did not put any location!');
						return redirect()->route('profile');
					}

					$allids=$request->input('id');
					$item_codes=$request->input('item_code');
					$quantities=$request->input('quantity');
					$company_name=$request->input('company_name');
					$location_id=$request->input('location_id');
					$note=$request->input('note');
					$order_date=date('Y-m-d H:i:s');
					
					if (!empty($request->input('client_id'))) {
						$user_id=$request->input('client_id');
						$client_details = DB::table('admins')->where('id',$user_id)->first();
						$company_name=$client_details->company_name;
					}

					$image = $request->attachement;

					if(!empty($image)){
					$name = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = base_path('assets/orders');
					$image->move($destinationPath, $name);					
					$attachment = 'assets/orders/' . $name;
					}else{
				       $attachment="";
					}
					
					
					
					$location_details = DB::table('locations')->where('id',$location_id)->first();
					if ($location_details) {
						$insert_order=DB::insert('insert into orders (user_id,company_name,order_date,address,city,province,zip,note) values(?,?,?,?,?,?,?,?)',[$user_id,$company_name,$order_date,$location_details->address,$location_details->city,$location_details->province,$location_details->zip,$note]);
					}else{
						$address=$request->input('address');
						$city=$request->input('city');
						$province=$request->input('province');
						$zip=$request->input('zip');
						$insert_order=DB::insert('insert into orders (user_id,company_name,order_date,address,city,province,zip,note,attachment) values(?,?,?,?,?,?,?,?,?)',[$user_id,$company_name,$order_date,$address,$city,$province,$zip,$note,$attachment]);
					}
					
					$order_id= DB::getPdo()->lastInsertId();
					
							

					if ($insert_order && $allids) {
						foreach($allids as $key => $id){
							foreach($quantities as $mey => $quantity){
								if($key==$mey){
									$product_details = DB::table('products')->where('id',$id)->first();
									$insert_order_item=DB::insert('insert into order_items (order_id,product_id,item_code,quantity) values(?,?,?,?)',[$order_id,$id,$product_details->item_code,$quantity]);
									
								}
							}
						}
						if ($insert_order_item) {
                            $email =DB::table('admins')->where('username',$username)->value('email');
                            
                            
                            if(!empty($email)){
                                $subject="APE Order Confirmation";
								
								$date = date('d/m/Y');
								$time = time();

								$message = '<!DOCTYPE html>
								<html>
									<head>
										<link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" type="text/css">
										<link href="https://fonts.googleapis.com/css?family=Lato|Nanum+Gothic:700|Raleway&display=swap" rel="stylesheet">
										<style>
											@media only screen and (min-width: 768px) {
												.topnav {
													height: 20%;
												}
								
												.img-container {
													text-align: center;
													width:100%;
													margin-bottom:1%;
												}

												.img-container img {
													width:15%;
													height:auto;
												}
								
												.links {
													width:100%;
													text-align:center;
													background-color: #008ed2;
													padding:1%;
												}
								
												.links a{
													font-size:1em;
													text-decoration:none;
													color:white;
													font-family: Inter, sans-serif;
													margin:0 5%;
								
												}
								
												.content {
													display:flex;
													flex-wrap:wrap;
													font-family: Inter, sans-serif;
												}
								
								
												.right {
													width:50%;
													text-align:center;
													margin:auto;
													font-size: 1.5em;
												}
								
												.title1 {
													font-size: 1.5em;
													padding-top: 10%;
													padding-left:5.5%;
													color:#494949;
												}
								
												.text1 {
													font-size:1em;
													color: #6e6e6e;
													padding-top:5%;
													padding-left: 5.5%;
												}
								
												.tabletitle {
													width:100%;
													background-color: lightgrey;
													color:#3e5CCC;
													margin-top:5%;
													padding: 1% 2.5%;
													font-size:1.2em;
													font-family: Inter, sans-serif;
												}

												.tabletitle img {
													width:2%;
													height:auto
												}

												.cart {
													text-align:center;
													width:100%;
												}

												.quantity {
													font-size: 1.2em;
													width:25%;
												}

												.prodimg {
													width:25%;
													height:auto;
												}

												.productimage {
													width:25%;
												}

												footer {
													background-color: #3c3b3b;
													padding: 1em 4em 1em;
													color: grey;
													font-size:0.9em;
													font-family: Lato, sans-serif;
												}
								
								
								
												footer .row {
													margin: 2em 0;
													position: relative;
													border-bottom: 1px solid #cecece;
												}
								
												footer ul {
													padding:0;   
													
												}

												footer li {
													margin-left:0;
												}
								
												footer ul li {
													list-style-type: none;
													padding:0;            
													line-height: 2;            
												}  
								
												.category {
													font-size: 20px;
													color: #fff;
												}
								
												.col-3 {
													display: inline-table;
													width:33%;
												}
								
												.address {
													margin-left:40%;
												}
								
												.contact {
													margin-left:40%;
												}
								
												.socials {
													margin-top: 5px;
													display:flex;
												}

												footer a {
													text-decoration:none;
												}
											}
								
											@media only screen and (max-width:768px) {
												.topnav {
													height: 30%;
												}
								
												.img-container {
													text-align: center;
													width:100%;
													margin-bottom:1%;
												}

												.img-container img {
													width:50%;
													height:auto;
												}
								
												.links {
													width:100%;
													text-align:center;
													background-color: #008ed2;
													padding:2%;
												}
								
												.links a{
													font-size:0.8em;
													text-decoration:none;
													color:white;
													font-family: Inter, sans-serif;
													margin:0 5%;
								
												}

												.content {
													display:flex;
													flex-wrap:wrap;
													font-family: Inter, sans-serif;
												}

												.left {
													width:100%;
													text-align:center;
												}

												.right {
													width:100%;
													text-align:center;
													margin:auto;
													padding-left: 3%;
													font-size: 1.5em;
												}

												.title1 {
													font-size: 1.5em;
													padding-top: 10%;
													padding-left:5.5%;
													color:#494949;
												}
								
												.text1 {
													font-size:1em;
													color: #6e6e6e;
													padding-top:5%;
													padding-left: 5.5%;
													margin-bottom:5%;
												}

												.tabletitle {
													width:100%;
													background-color: lightgrey;
													color:#3e5CCC;
													margin-top:5%;
													padding: 1% 2.5%;
													font-size:1em;
													font-family: Inter, sans-serif;
												}

												.tabletitle img {
													width:5%;
													height:auto;
												}


												.quantity {
													font-size: 0.5em;
													width:25%;
													margin-left:20px;
												}

												.cart img {
													width: 80px;
													height: auto;
												}

												.proddescript {
													font-size: 0.7em;
													margin-left: 5px;
												}

												footer {
													background-color: #3c3b3b;
													padding: 1em 4em 1em;
													color: grey;
													font-size:0.9em;
													font-family: Lato, sans-serif;
												}

												
												footer .row {
													margin: 2em 0;
													position: relative;
													border-bottom: 1px solid #cecece;
												}
								
												footer ul {
													padding:0;   
												}

												footer li {
													margin-left:0;
												}
								
												footer ul li {
													list-style-type: none;
													padding:0;            
													line-height: 2;            
												}  

												.category {
													font-size: 20px;
													color: #fff;
													text-align:center;
												}
								
												.col-3 {
													display: inline-table;
												}
								
												.address {
													width:100%;
													
													padding-right:30px;
												}
								
												
								
												.socials {
													margin-top: 5px;
													display:flex;
												}

												footer a {
													text-decoration:none;
												}

												

											}
										</style>
									
									</head>
								
									<body>
										<div class="topnav">
											<div class="img-container">
												<img src="http://www.apeorder.com/assets/email/APE_Logo_1200x1200.jpg">
											</div>
								
											<div class="links">
												<a href="apeorder.com/promoted">PROMOTIONS ></a>
												<a href="apeorder.com/all_products">ORDER NOW ></a>
											</div>
								
											<div class="content">
												<div class="left">
													<div class="title1">
														<strong>Hi ' .$company_name . ', we received your order on '.$date.'.</strong>
													</div>
								
													<div class="text1">
														Thank you for ordering with Access Pacific Enterprises. We appreciate your business
														and look forward to seeing you soon. <br><br>
														
														Below is a summary of your order. Please be sure to review your items to ensure everything is correct<br><br>
								
														Sincerely, <br><br>
								
														Access Pacific Customer Care Team
													</div>
												</div>
								
												<div class="right">
													<strong>Order #</strong><bR>
													' . $order_id .'
												</div>
							
											</div>
											<div class="tabletitle">
												<img src="http://www.apeorder.com/assets/email/delivery.png">
												<strong>Ordered Items</strong>
											</div>
								
											<div class="items">
												<table class="cart">';

												foreach(Session::get('cart') as $id => $quantity) {

												$product = DB::table('products')->where('id', $id)->first();
													$message .=
													'<tr>
														<td class="productimage">
															<img src="http://www.apeorder.com/' .$product->catalogue.'" class="prodimg">
														</td>
														<td colspan="2">
															<div class="proddescript">'
																.$product->descriptions.	
															'</div>
														</td>
														<td class="quantity">
															<strong>QTY</strong><br> x '
															. $quantity['quantity'] .
														'</td>
													</tr>';
												} 
												$message .= '
												</table>
											</div>
											
										</div>
										
									</body>

									<footer>
										<div class="row">
											<div class="col-3">
												<span class="category">About Us</span>
												<p class="about">
												Located in the heart of Richmond, we at Access Pacific pride ourselves on providing your business with quality packaging products to 
												enhance satisfaction and convenience. With our large inventory of unique, eco-friendly food and beverage products, on-site graphic design, 
												and our exceptional customer service, we promise to bring complete satisfaction to your business.
												</p>
											</div>

											<div class="col-3">
												<div class="address">
													<span class="category">Home Office</span>

													<ul>
														<li>
															11111 Twigg Place., Unit 1063<br>
															Richmond, BC V6V 0B7 Canada <br>
															Business Hours: <br>
															Mon - Fri 8:30AM - 5:00PM
														</li>
													</ul>
												</div>
											</div>

											<div class="col-3">
												<div class="contact">
													<span class="category">Contact Us</span>

													<ul>
														<li>
															sales@accesspacific.ca 
														</li>
														<li>
															(604) 821-0088
														</li>

														<div class="socials">
															<li>
																<a href="https://www.facebook.com/pages/category/Shopping---Retail/Access-Pacific-107378444444526/">
																	<img src="http://www.apeorder.com/assets/email/facebook.png" width="20px" height="auto">
																</a>
															</li>
								
															<li style="margin-left:5px;">
																<a href="https://www.instagram.com/access.pacific/">
																	<img src="http://www.apeorder.com/assets/email/instagram.png" width="20px" heigh="auto">
																</a>
															</li>
														</div>
													</ul>
												</div>
											</div>

											
										</div>

									</footer>
								
								</html>';
											
            
        
                                $emailfrom = 'no-reply@apeorder.com';
                                $fromname = 'APE Order Confirmation';
                                
                                
                                $headers = 
                                    'Return-Path: ' . $emailfrom . "\r\n" . 
                                    'From: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" . 
                                    'X-Priority: 3' . "\r\n" . 
                                    'X-Mailer: PHP ' . phpversion() .  "\r\n" . 
                                    'Reply-To: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" .
                                    'MIME-Version: 1.0' . "\r\n" . 
                                    //'Content-Transfer-Encoding: 8bit' . "\r\n" . 
                                    'Content-Type: text/html; charset=UTF-8' . "\r\n";
                                $params = '-f' . $emailfrom;

                                mail($email, $subject, $message, $headers, $params);
                            }

                            Session::flash('message', 'Order Placed!');
                           
							Session::forget('cart');
						}
                        return view('thankyou', compact(['user_details']));
                      
					}else{
						Session::flash('message','Order placed without items');
						return redirect()->back();
					}

				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// save_product for admin
	public function quick_order(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="warehouse" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('company_name'))) {

					$company_name=$request->input('company_name');

					// $insert_order=DB::insert('insert into admins (company_name,joined_date,role) values(?,?,?)',[$company_name,date('Y-m-d H:i:s'),'client']);
					// $client_id = DB::getPdo()->lastInsertId();

					$method=$request->input('method');
					$created=$request->input('created');
					$invoice_no=$request->input('invoice_no');
					$location=$request->input('location');
					$rep=$request->input('rep');
					$comment=$request->input('comment');

					$image = $request->attachement;
					
                    if(!empty($image)) {
						$name = time().'.'.$image->getClientOriginalExtension();
                        
						$destinationPath = base_path('assets/orders');
						$image->move($destinationPath, $name);					
						$attachment = 'assets/orders/' . $name;
					}else{
				       	$attachment="";
					} 

					$insert_order=DB::insert('insert into orders (company_name,order_date,attachment,created,method,invoice_no,location,rep,comment,status) values(?,?,?,?,?,?,?,?,?,?)',[$company_name,date('Y-m-d H:i:s'),$attachment,$created,$method,$invoice_no,$location,$rep,$comment,2]);
					if ($insert_order) {
						Session::flash('message','Order created!');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	public function download(Request $request){
		if ($request->isMethod('post')){
			$file=$request->input('file');
		    
		    return response()->download(asset($file));
	    }
	}

	// products for admin
	public function categories(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin" || $user_details->role=="staff"){
		   		$categories=DB::select('SELECT * FROM (categories)');
		   		return view('categories', compact(['user_details','categories']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	// save_product for admin
	public function category_save(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
		    if($user_details->role=="admin" || $user_details->role=="staff"){
				if ($request->isMethod('post') && !empty($request->input('category'))) {
					
					$category=$request->input('category');
					
					// $bumpid_check=DB::select('SELECT * FROM (bumpid_pin) WHERE bumpid=?',[$bumpid]);
					// // check email duplicate or not
					// if($bumpid_check){
					// 	Session::flash('error','This bump id is already created');
					// 	return redirect()->back();
					// }

					
					$insert_product=DB::insert('insert into categories (category) values(?)',[$category]);

					if ($insert_product) {
						Session::flash('message','Category added succesfully');
						return redirect()->back();
					}else{
						Session::flash('error','Something Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	//update_category for admin
	public function category_update(Request $request) {
		if($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			 if($user_details->role=="admin" || $user_details->role=="staff") {
				if($request->isMethod('post') && !empty($request->input('category'))) {
					$old_category=$request->input('old_category');
					$category=$request->input('category');

					$product_update=DB::update('UPDATE products SET category=? WHERE category=?',[$category,$old_category]);
					$category_update=DB::update('UPDATE categories SET category=? WHERE category=?',[$category, $old_category]);

					if($product_update && $category_update) {
						Session::flash('message','Category updated succesfully');
						return redirect()->back();
					}else{
						Session::flash('error','Something Went Wrong');
						return redirect()->back();
					}
				}else{
					Session::flash('error','Field Should Not empty');
					return redirect()->back();
				}
			}else{
				return redirect()->route('dashboard');
			} 
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}

	//delete_user
	public function category_delete(Request $request,$id){
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="admin" || $user_details->role=="staff"){
			
					
					$delete_user=DB::delete('DELETE FROM categories WHERE id=?',[$id]);
		   			Session::flash('message','User successfully deleted');
			
		   		return redirect()->back();
			}else{
				Session::flash('error','You cannot delete user');
		   		return redirect()->route('users');
			}

		  
		  
		}else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
	}
	//delete_user

	// all users for admin
	public function all_users(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin"){
		   		$total_users=DB::select('SELECT * FROM (admins)');
		   		return view('all_users', compact(['user_details','total_users']));
		   	}else{
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}


	//save user
	public function joinnow_save(Request $request){

		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin"){
		   		if ($request->isMethod('post') && !empty($request->input('username'))) {
		   			$company_name=$request->input('company_name');
		   			$name=$request->input('name');
		   			$username=$request->input('username');
					$email=$request->input('email');
					$phone=$request->input('phone');
					$password=$request->input('password');
					$role=$request->input('role');
					$joined_date=date('Y-m-d H:i:s');
					$email_check=DB::select('SELECT * FROM (admins) WHERE email=?',[$email]);
					// check email duplicate or not
					$username_check=DB::select('SELECT * FROM (admins) WHERE username=?',[$username]);
					if($username_check){
						Session::flash('error','Username is already used');
						return redirect()->route('users');
					}
					if($email_check){
						Session::flash('error','Email is already used');
						return redirect()->route('users');
					}else{
						$password = password_hash($password, PASSWORD_BCRYPT);
						$regi=DB::insert('insert into admins (name,username,company_name,email,password,joined_date,phone,role) values(?,?,?,?,?,?,?,?)',[$name,$username,$company_name,$email,$password,$joined_date,$phone,$role]);
						if ($regi) {
							Session::flash('message','Account created successfully');
							return redirect()->route('users');
						}else{
							Session::flash('error','Not successful!');
							return redirect()->route('users');
						}
					}
				}else{
					Session::flash('error','Something Went Wrong');
					return redirect()->route('users');
				}
		   	}else{
		   		Session::flash('error','You are not permitted to create account!');
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}

		
	}



	//update_user
	public function joinnow_update(Request $request){

		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_details = DB::table('admins')->where('username',$username)->first();
		   	if($user_details->role=="admin"){
		   		if ($request->isMethod('post') && !empty($request->input('name'))) {
		   			$id=$request->input('id');
		   			$company_name=$request->input('company_name');
		   			$name=$request->input('name');
		   			$username=$request->input('username');
					$company_name=$request->input('company_name');
					$phone=$request->input('phone');
					$email=$request->input('email');
					$role=$request->input('role');
					$password=$request->input('password');
					if ($password) {
						$password = password_hash($password, PASSWORD_BCRYPT);
						$update_user=DB::update('UPDATE admins SET company_name=?,name=?,username=?,password=?,company_name=?,phone=?,email=?,role=? WHERE id=?',[$company_name,$name,$username,$password,$company_name,$phone,$email,$role,$id]);
					}else{
						$update_user=DB::update('UPDATE admins SET company_name=?,name=?,username=?,company_name=?,phone=?,email=?,role=? WHERE id=?',[$company_name,$name,$username,$company_name,$phone,$email,$role,$id]);
					}
					
					
						
						if ($update_user) {
							Session::flash('message','Account updated successfully');
							return redirect()->route('users');
						}else{
							Session::flash('error','Not successful!');
							return redirect()->route('users');
						}
					
				}else{
					Session::flash('error','Something Went Wrong');
					return redirect()->route('users');
				}
		   	}else{
		   		Session::flash('error','You are not permitted to create account!');
		   		return redirect()->route('dashboard');
		   	}
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}

		
	}

 

	//delete_user
	public function delete_user(Request $request,$id){
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="admin"){
				if ($user_id==$id) {
					Session::flash('error','You cannot delete own account');
				}else{
					$get_user_details = DB::table('admins')->where('id',$id)->first();
					if (!empty($get_user_details->img)) {
						unlink($get_user_details->img);
					}
					$delete_user=DB::delete('DELETE FROM admins WHERE id=?',[$id]);
		   			Session::flash('message','User successfully deleted');
				}
		   		return redirect()->back();
			}else{
				Session::flash('error','You cannot delete user');
		   		return redirect()->route('users');
			}

		  
		  
		}else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
	}
	//delete_user



	// show profile
	public function profile(Request $request){
		
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			
			$locations = DB::table('locations')->where('user_id',$user_id)->get();
			return view('profile', compact(['user_details','locations']));		    
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}
	}// show profile



	// save_profile
	public function save_profile(Request $request){
				
		if ($request->session()->has('username')) {

				if ($request->isMethod('post') && !empty($request->input('current_pwd'))) {

				$current_pwd=$request->input('current_pwd');
				$pwd=$request->input('pwd');
				$pwd_confirm=$request->input('pwd_confirm');

				$user_id=Session::get('user_id');
				
				$admin = DB::table('admins')->where('id',$user_id)->first();
				 
		      	if(password_verify($current_pwd, $admin->password)){

				if (!empty($pwd_confirm) && !empty($pwd) && $pwd!=$pwd_confirm) {
					
					Session::flash('error','New Password not match!');
					 return redirect()->route('profile');
				}else{

					$uppercase = preg_match('@[A-Z]@', $pwd);
					$lowercase = preg_match('@[a-z]@', $pwd);
					$number    = preg_match('@[0-9]@', $pwd);

					if(!$uppercase && !$lowercase || !$number || strlen($pwd) < 8) {
					 
					  Session::flash('error','Password must be at least 8 charecters and contain number and letter!');
					   return redirect()->route('profile');
					}

				}

			}else{
				
				 Session::flash('error','Current Password wrong!');
				 return redirect()->route('profile');
			}


				$pwd = password_hash($pwd, PASSWORD_BCRYPT);
        		$update=DB::update('UPDATE admins SET password=? WHERE id=?',[$pwd,$user_id]);
				
				if($update){
					Session::flash('message','Password changed successfully');
					return redirect()->route('profile');
				}else{
					Session::flash('error','Password changes not successful');
					return redirect()->route('profile');
				}
				

		}elseif($request->isMethod('post') && !empty($request->input('text_color'))){
			$text_color=$request->input('text_color');
			$bg_color1=$request->input('bg_color1');
			$bg_color2=$request->input('bg_color2');
			$user_id=Session::get('user_id');
			$update=DB::update('UPDATE admins SET text_color=?,bg_color1=?,bg_color2=? WHERE id=?',[$text_color,$bg_color1,$bg_color2,$user_id]);
			
			Session::flash('message','Color Updated!');
			return redirect()->route('profile');
			
				
		}elseif($request->isMethod('post') && !empty($request->input('gift_method'))){
			$gift_method=$request->input('gift_method');
			$gift_username=$request->input('gift_username');
			$gift_method2=$request->input('gift_method2');
			$gift_username2=$request->input('gift_username2');
			$comment=$request->input('comment');			
			$user_id=Session::get('user_id');
			$update=DB::update('UPDATE admins SET gift_method=?,gift_username=?,gift_method2=?,gift_username2=?,comment=? WHERE id=?',[$gift_method,$gift_username,$gift_method2,$gift_username2,$comment,$user_id]);
			
			Session::flash('message','Gift method Updated!');
			return redirect()->route('profile');
			
				
		}elseif($request->isMethod('post') && !empty($request->input('profilepic'))){
			$image = $request->img;
			if(!empty($image)){
			$name = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = base_path('owner/profile-image');
			$image->move($destinationPath, $name);
			$image_url = 'owner/profile-image/' . $name;
			}else{
		        	$image_url="";
		        }
			$user_id=Session::get('user_id');
			$update=DB::update('UPDATE admins SET image=? WHERE id=?',[$image_url,$user_id]);
			
			Session::flash('message','Profile picture updated!');
			return redirect()->route('profile');
			
		}elseif($request->isMethod('post') && !empty($request->input('address'))){
			$address=$request->input('address');
			$city=$request->input('city');
			$province=$request->input('province');
			$zip=$request->input('zip');
			$user_id=Session::get('user_id');
			$regi=DB::insert('insert into locations (user_id,address,city,province,zip) values(?,?,?,?,?)',[$user_id,$address,$city,$province,$zip]);
			if($regi){
				Session::flash('message','Location added!');
			}
			
			
			return redirect()->route('profile');
			
		}else{
            Session::flash('error','Fields cannot be empty');
			return redirect()->route('profile');
		}

		    
		}else{
			Session::flash('error','You are not logged in');
			return redirect()->route('login_default');
		}

	}//save_member



	//delete_location
	public function delete_location(Request $request,$id){
		if ($request->session()->has('username')) {
			$username = Session::get('username');
			$user_id = Session::get('user_id');
			$user_details = DB::table('admins')->where('username',$username)->first();
			if($user_details->role=="client"){

				$delete_location=DB::delete('DELETE FROM locations WHERE user_id=? AND id=?',[$user_id,$id]);
				Session::flash('message','Location successfully deleted');
		   		return redirect()->back();
			}else{
				Session::flash('error','You cannot delete');
		   		return redirect()->back();
			}

		}else{
			Session::flash('message','You are logout!');
			return redirect()->route('login_default');
		}
	}
	//delete_user
	


	// Cronjob
	public function cronjob(Request $request){
			
		$tasks = DB::table('tasks')->where('mail_sent',0)->get();
	
		if ($tasks) {
			foreach ($tasks as $key => $task) {

				$dateo=$task->timeframe.' '.$task->time;

				

				$date_close = (new DateTime($dateo))->modify('-15 minutes');

				

				$joined = strtotime($date_close->format('Y-m-d H:i:s a'));

				$limit=strtotime(date('Y-m-d H:i:s a'));

				if($joined<$limit){
					
					echo "yes";
					DB::update('UPDATE tasks SET mail_sent=? WHERE id=?',[1,$task->id]);
				}else{
					echo 'no';
				}						
				
			}
		}
		// Delete unpaid fire finish

		
	}







}



?>
