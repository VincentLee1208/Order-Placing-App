<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>APE</title>
		<meta name="keywords" content="" />
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="apple-touch-icon" sizes="512x512" href="{{asset('owner/img/touch.png')}}">
		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:100,300,400,600,800,900|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{asset('owner/vendor/bootstrap/css/bootstrap.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/animate/animate.css')}}">
		<link rel="stylesheet" href="{{asset('owner/vendor/font-awesome/css/all.min.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/magnific-popup/magnific-popup.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/pnotify/pnotify.custom.css')}}" />

		<!--(remove-empty-lines-end)-->

		


		<!--(specific page vendor)-->
		<link rel="stylesheet" href="{{asset('owner/vendor/jquery-ui/jquery-ui.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/jquery-ui/jquery-ui.theme.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/select2/css/select2.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/dropzone/basic.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/dropzone/dropzone.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/summernote/summernote-bs4.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/codemirror/lib/codemirror.css')}}" />
		<link rel="stylesheet" href="{{asset('owner/vendor/codemirror/theme/monokai.css')}}" />
		<link rel="stylesheet" href="{{asset('vendor/pnotify/pnotify.custom.css')}}" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{asset('owner/css/theme.css')}}" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="{{asset('owner/css/skins/default.css')}}" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('owner/css/custom.css')}}">

		<!-- Head Libs -->
		<script src="{{asset('owner/vendor/modernizr/modernizr.js')}}"></script>
		<script src="https://cdn.tiny.cloud/1/03amq3ktfhsd2thvku1y26x542y1yq6e7cso7pnz0qtuecg3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

		<style type="text/css">
			ul.nav-main li a {
				color: #000;
			}

			html.no-overflowscrolling .sidebar-left .nano {
				background: -webkit-linear-gradient(left, {{$user_details->bg_color1}}, {{$user_details->bg_color2}}) !important;
			}

			.page-header{
				background: -webkit-linear-gradient(left, {{$user_details->bg_color1}}, {{$user_details->bg_color2}}) !important;
			}

			.page-header h2{
				color: {{$user_details->text_color}};
			}
			.page-header .breadcrumbs li{
				color: {{$user_details->text_color}};
			}
			ul.nav-main li a{
				color: {{$user_details->text_color}};
			}

			.sidebar-left .sidebar-header .sidebar-toggle i{
				color: {{$user_details->text_color}};
			}

			.bg-theme{
				background:-webkit-linear-gradient(left, {{$user_details->bg_color2}}, {{$user_details->bg_color1}}) !important;
				color: {{$user_details->text_color}} !important;
			}
			.color-theme{
				color: {{$user_details->text_color}} !important;
			}
			.page-header .breadcrumbs a, .page-header .breadcrumbs span{
				color: {{$user_details->text_color}};
			}
			ul.nav-main li.nav-parent > a:after{
				color: {{$user_details->text_color}};
			}
			.alert-danger,.alert-success{
				display: none;
			}
		</style>

	</head>
	

	


	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="{{route('dashboard')}}" class="logo">
						<img src="{{asset('owner/img/logo.png')}}" width="35" alt="Logo" />
					</a>
					<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					
			
					<span class="separator"></span>
			
					<ul class="notifications">
						
						@if($user_details->role=='client')
						<li>
							<a href="{{route('checkout')}}" class="dropdown-toggle notification-icon">
								<i class="fas fa-shopping-cart"></i>
								
									<span class="badge">
									@if (Session::has('cart'))
									{{count(Session::get('cart'))}}
									@else
									0
									@endif
									</span>
								
							</a>
							@if (Session::has('cart'))
							<!-- <div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="float-right badge badge-default">Added products</span>
									Your Cart
								</div>
			
								<div class="content">
									<ul>
										<form action="{{route('checkout')}}" method="post">
										@csrf
											@foreach(Session::get('cart') as $id => $quantity)
											<?php $product=DB::table('products')->where('id',$id)->first();?>
											<input type="hidden" name="id[]" value="{{$id}}">
											<input type="hidden" name="quantity[]" value="{{$quantity['quantity']}}">
											<li>
												<span class="title text-left">
													<img width="25" src="{{asset($product->catalogue)}}"> Item Code:{{$product->item_code}} x {{$quantity['quantity']}}
													<a class="pull-right" href="{{url('/product/clearSingle')}}/{{$id}}">
														<i class="fas fa-trash text-danger"></i>
													</a>
												</span>
											</li>
											@endforeach
											<li>
												<button class="btn btn-sm bg-theme theme-color d-inline-block">Checkout</button>
												<a href="{{url('/product/clearCart')}}" class="btn btn-sm btn-danger d-inline-block text-white">Clear</a>
											</li>
										</form>
									</ul>
								</div>
							</div> -->
							@endif
						</li>
						@endif
					</ul>
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="@if(!empty($user_details->image))
										{{asset($user_details->image)}} 
										@endif
										@if(empty($user_details->image))	 
										{{asset('owner/img/!sample-user.jpg')}} 
										@endif" alt="Joseph Doe" class="rounded-circle" 
										data-lock-picture="@if(!empty($user_details->image))
										{{asset($user_details->image)}} 
										@endif
										@if(empty($user_details->image))	 
										{{asset('owner/img/!sample-user.jpg')}} 
										@endif" />
							</figure>
							<div class="profile-info" data-lock-name="{{Session::get('name')}}" data-lock-email="{{Session::get('user_email')}}">
								<span class="name"> {{Session::get('name')}}</span>
								<span class="role">{{$user_details->role}}</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled mb-2">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="{{route('profile')}}"><i class="fas fa-user"></i> My Profile</a>
								</li>
								<!-- <li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fas fa-lock"></i> Lock Screen</a>
								</li> -->
								<li>
									<a role="menuitem" tabindex="-1" href="{{route('logout')}}"><i class="fas fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
				    <div class="sidebar-header">
				        <div class="sidebar-title">
				            Navigation
				        </div>
				        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				        </div>
				    </div>
				
				    <div class="nano">
				        <div class="nano-content">
				            <nav id="menu" class="nav-main" role="navigation">
				            
				                <ul class="nav nav-main">
				                	
				                    <li>
				                        <a class="nav-link color-theme @if(Route::current()->getName() == 'dashboard') bg-dark @endif" href="{{route('dashboard')}}">
				                            <i class="fas fa-home" aria-hidden="true"></i>
				                            <span>Dashboard</span>
				                        </a>                        
				                    </li>
				                    @if($user_details->role=="client")
									<li>
				                        <a class="nav-link color-theme @if(Route::current()->getName() == 'favourite') bg-dark @endif" href="{{route('favourite')}}">
				                            <i class="fas fa-gift" aria-hidden="true"></i>
				                            <span>All Products</span>
				                        </a>                        
				                    </li>
									<li>
				                        <a class="nav-link color-theme @if(Route::current()->getName() == 'history') bg-dark @endif" href="{{route('history')}}">
				                            <i class="fas fa-history" aria-hidden="true"></i>
				                            <span>History</span>
				                        </a>                        
				                    </li>
									@endif
									@if($user_details->role=="warehouse")
									<li>
				                        <a class="nav-link color-theme @if(Route::current()->getName() == 'tracking') bg-dark @endif" href="{{route('tracking')}}">
				                            <i class="fas fa-truck-moving" aria-hidden="true"></i>
				                            <span>Tracking</span>
				                        </a>                        
				                    </li>
				                    <li>
				                        <a class="nav-link color-theme @if(Route::current()->getName() == 'task') bg-dark @endif" href="{{route('task')}}">
				                            <i class="fas fa-tasks" aria-hidden="true"></i>
				                            <span>Return & Task</span>
				                        </a>                        
				                    </li>
									@endif
				                   

				                   <!--  <li class="nav-parent nav-active">
				                        <a class="nav-link" href="#">
				                            <i class="fas fa-users" aria-hidden="true"></i>
				                            <span>Family</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                 <a class="nav-link" href="">
				                                   Active Family
				                                </a>
				                            </li>
				                            
				                            <li>
				                               <a class="nav-link" href="">
				                                    Inactive Family
				                                </a>
				                            </li>
				                        </ul>
				                    </li> -->
				
				                </ul>
				            </nav>


				           
					 	
				
				           
					 	@if($user_details->role=="admin" ||$user_details->role=="staff")
					 	 <hr class="separator" />
				            <div class="sidebar-widget widget-tasks">
				                <div class="widget-header">
				                    <h6 class="color-theme">Admin Features</h6>
				                    <div class="widget-toggle">+</div>
				                </div>
				                <div class="widget-content">
				                    <ul class="list-unstyled m-0">
				                    	<li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'create_order') bg-dark @endif" href="{{route('create_order')}}">
					                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
					                            <span>Create Order</span>
					                        </a>                        
					                    </li>
					                    <li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'history') bg-dark @endif" href="{{route('history')}}">
					                            <i class="fas fa-history" aria-hidden="true"></i>
					                            <span>Order History</span>
					                        </a>                        
					                    </li>
					                     <li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'tracking') bg-dark @endif" href="{{route('tracking')}}">
					                            <i class="fas fa-truck-moving" aria-hidden="true"></i>
					                            <span>Tracking</span>
					                        </a>                        
					                    </li>
					                    <li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'task') bg-dark @endif" href="{{route('task')}}">
					                            <i class="fas fa-tasks" aria-hidden="true"></i>
					                            <span>Return & Task</span>
					                        </a>                        
					                    </li>
					                    <li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'archive') bg-dark @endif" href="{{route('archive')}}">
					                            <i class="fas fa-archive" aria-hidden="true"></i>
					                            <span>Archive</span>
					                        </a>                        
					                    </li>
				                    	<li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'orders') bg-dark @endif" href="{{route('orders')}}">
					                            <i class="fas fa-heart" aria-hidden="true"></i>
					                            <span>Add to favourite</span>
					                        </a>                        
					                    </li>
										<li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'favourite_list') bg-dark @endif" href="{{route('favourite_list')}}">
					                            <i class="fas fa-star" aria-hidden="true"></i>
					                            <span>Favourites</span>
					                        </a>                        
					                    </li>
				                    	<!-- <li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'categories') bg-dark @endif" href="{{route('categories')}}">
					                            <i class="fas fa-folder" aria-hidden="true"></i>
					                            <span>Categories</span>
					                        </a>                        
					                    </li> -->
				                       
				                       	<li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'products') bg-dark @endif" href="{{route('products')}}">
					                            <i class="fas fa-gifts" aria-hidden="true"></i>
					                            <span>Products</span>
					                        </a>                        
					                    </li>
					                    	<li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'rep') bg-dark @endif" href="{{route('rep')}}">
					                            <i class="fas fa-shipping-fast"></i>
					                            <span>Reps</span>
					                        </a>                        
					                    </li>
				                    	<li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'marketing') bg-dark @endif" href="{{route('marketing')}}">
					                            <i class="fas fa-bullhorn" aria-hidden="true"></i>
					                            <span>Marketing</span>
					                        </a>                        
					                    </li>
					                    <li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'promoted_products') bg-dark @endif" href="{{route('promoted_products')}}">
					                            <i class="fas fa-bullhorn" aria-hidden="true"></i>
					                            <span>Promoted products</span>
					                        </a>                        
					                    </li>
					                    @if($user_details->role=="admin")
					                	<li>
					                        <a class="nav-link color-theme @if(Route::current()->getName() == 'users') bg-dark @endif" href="{{route('users')}}">
					                            <i class="fas fa-users" aria-hidden="true"></i>
					                            <span>User Accounts</span>
					                        </a>                        
					                    </li>
					                    @endif
					                
				                       
				                    </ul>
				                </div>
				            </div>
				
				        @endif
				        </div>
				
				        <script>
				            // Maintain Scroll Position
				            if (typeof localStorage !== 'undefined') {
				                if (localStorage.getItem('sidebar-left-position') !== null) {
				                    var initialPosition = localStorage.getItem('sidebar-left-position'),
				                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');
				                    
				                    sidebarLeft.scrollTop = initialPosition;
				                }
				            }
				        </script>
				        
				
				    </div>
				
				</aside>
				<!-- end: sidebar -->
					
				 @yield('maincontent')
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close d-md-none">
							Collapse <i class="fas fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Calender</h6>
								<div data-plugin-datepicker data-plugin-skin="dark"></div>
							</div>
			
							
			
						</div>
					</div>
				</div>
			</aside>
		
		</section>

		<!-- modal -->
		@if(!empty($all_report) && $user_details->role=='admin')
			@foreach($all_report as $key=> $report)
			<?php $report_user = DB::table('admins')->where('id',$report->user_id)->first(); ?>
			<div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h3 class="modal-title font-weight-bold text-center" id="exampleModalLabel">{{$report_user->name}}'s Issue for Flower(#{{$report->flower_id}})</h3>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	{{$report->comment}}
			      </div>
			      
			    </div>
			  </div>
			</div>
		<!-- modal end -->
		@endforeach
		@endif

		<!-- Vendor -->
		<script src="{{asset('owner/vendor/jquery/jquery.js')}}"></script>
		<script src="{{asset('owner/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
		<script src="{{asset('owner/vendor/popper/umd/popper.min.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap/js/bootstrap.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
		<script src="{{asset('owner/vendor/common/common.js')}}"></script>
		<script src="{{asset('owner/vendor/nanoscroller/nanoscroller.js')}}"></script>
		<script src="{{asset('owner/vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>
		<script src="{{asset('owner/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
		
		<!-- Specific Page Vendor -->
		<script src="{{asset('owner/vendor/jquery-ui/jquery-ui.js')}}"></script>
		<script src="{{asset('owner/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
		<script src="{{asset('owner/vendor/select2/js/select2.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>
		<script src="{{asset('owner/vendor/jquery-maskedinput/jquery.maskedinput.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
		<script src="{{asset('owner/vendor/fuelux/js/spinner.js')}}"></script>
		<script src="{{asset('owner/vendor/dropzone/dropzone.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-markdown/js/markdown.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-markdown/js/to-markdown.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-markdown/js/bootstrap-markdown.js')}}"></script>
		<script src="{{asset('owner/vendor/codemirror/lib/codemirror.js')}}"></script>
		<script src="{{asset('owner/vendor/codemirror/addon/selection/active-line.js')}}"></script>
		<script src="{{asset('owner/vendor/codemirror/addon/edit/matchbrackets.js')}}"></script>
		<script src="{{asset('owner/vendor/codemirror/mode/javascript/javascript.js')}}"></script>
		<script src="{{asset('owner/vendor/codemirror/mode/xml/xml.js')}}"></script>
		<script src="{{asset('owner/vendor/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>
		<script src="{{asset('owner/vendor/codemirror/mode/css/css.js')}}"></script>
		<script src="{{asset('owner/vendor/summernote/summernote-bs4.js')}}"></script>
		<script src="{{asset('owner/vendor/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
		<script src="{{asset('owner/vendor/ios7-switch/ios7-switch.js')}}"></script>
		<!-- Specific Page Vendor -->
		<script src="{{asset('owner/vendor/select2/js/select2.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/media/js/dataTables.bootstrap4.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js')}}"></script>
		<script src="{{asset('owner/vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js')}}"></script>
		<script src="{{asset('owner/vendor/pnotify/pnotify.custom.js')}}"></script>


		<!--(remove-empty-lines-end)-->
		
		<!-- Theme Base, Components and Settings -->
		<script src="{{asset('owner/js/theme.js')}}"></script>
		
		<!-- Theme Custom -->
		
		
		<!-- Theme Initialization Files -->
		<script src="{{asset('owner/js/theme.init.js')}}"></script>

		<!-- Examples -->
		<script src="{{asset('owner/js/examples/examples.advanced.form.js')}}"></script>
		<!-- Examples -->
		<script src="{{asset('owner/js/examples/examples.datatables.default.js')}}"></script>
		<script src="{{asset('owner/js/examples/examples.datatables.row.with.details.js')}}"></script>
		<script src="{{asset('owner/js/examples/examples.datatables.tabletools.js')}}"></script>
		 <script src="{{asset('owner/js/jscolor.js')}}"></script>
		 <script src="{{asset('owner/js/modified_jquery.isotope.min_v2.js')}}"></script>
		 
		 <!-- <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script> -->

		@if (Session::has('message'))
		<script type="text/javascript">

			new PNotify({
				title: 'Success!',
				text: '{{Session::get('message')}}',
				type: 'success',
				addclass: 'stack-topright'
			});
		</script>
		@endif


		@if (Session::has('error'))
		<script type="text/javascript">
			new PNotify({
				title: 'Error!',
				text: '{{Session::get('error')}}',
				type: 'error'
				addclass: 'stack-topright'
			});
		</script>
		@endif

		<!-- <script>
	    tinymce.init({
	      selector: 'textarea',
	      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak code',
	      toolbar_mode: 'code',
	      menubar: "tools"
	    });
	  </script> -->
	  
	  <script type="text/javascript">
            $(document).on('click', ':not(form)[data-confirm]', function(e){
	        if(!confirm($(this).data('confirm'))){
		          e.stopImmediatePropagation();
		          e.preventDefault();
		        }
		    });
	    </script>
	     <script>
		$(document).ready(function(){
		  $("#btn1").click(function(){
		    $("#weapon_add").append('<input type="text" name="car_code[]" class="form-control" placeholder="Task Step" required>');
		  });
		  
		});
		</script>

		<script>
		$(document).ready(function(){
		  $("#btn3").click(function(){
		    $("#weapon_add2").append('<input type="text" name="car_code[]" class="form-control" placeholder="Task Step" required><a title="Click here if you want to add more!" class="btn2" style="font-size:20px;" href="#"><i class="fas fa-minus-circle"></i></a>');
		  });
		  
		});
		</script>

		<script>
		$(document).ready(function(){
		  $(".btn2").click(function(){
		    $(this).prev().remove();
		    $(this).remove();
		  });
		  
		});
		</script>

		<script>
			$(function () {
				$('[data-toggle="popover"]').popover()
			})

			$('body').on('click', function (e) {
			    //only buttons
			    if ($(e.target).data('toggle') !== 'popover'
			        && $(e.target).parents('.popover.in').length === 0) { 
			        $('[data-toggle="popover"]').popover('hide');
			    }
			    //buttons and icons within buttons
			    /*
			    if ($(e.target).data('toggle') !== 'popover'
			        && $(e.target).parents('[data-toggle="popover"]').length === 0
			        && $(e.target).parents('.popover.in').length === 0) { 
			        $('[data-toggle="popover"]').popover('hide');
			    }
			    */
			});
		</script>

		<script>
			// search feature for product search
			$("#search_product").keyup(function(){
			  var input, filter, ul, li, a, i, txtValue;
			    input = document.getElementById("search_product");
			    filter = input.value.toUpperCase();
			    ul = document.getElementById("products_container");
			    li = ul.getElementsByClassName("product-item");
			    for (i = 0; i < li.length; i++) {
			        a = li[i].getElementsByTagName("span")[0];
			        txtValue = a.textContent || a.innerText;
			        if (txtValue.toUpperCase().indexOf(filter) > -1) {
			            li[i].style.display = "";
						li[i].style.opacity = "1";
			        } else {
			            li[i].style.display = "none";
						li[i].style.opacity = "0";
			        }
			    }
			});


			// init Isotope
			// var $grid = $('#products_container').isotope({
			// 	itemSelector: '.product-item',
			// 	layoutMode: 'fitRows'
			// });
			// filter items on button click
			// $('.controls').on( 'click', 'a', function() {
			// 	var filterValue = $(this).attr('data-filter');
			// 	$grid.isotope({ filter: filterValue });
			// });
		</script>

		<script>
			// search feature for product search
			$("#search_product2").keyup(function(){
			  var input, filter, ul, li, a, i, txtValue;
			    input = document.getElementById("search_product2");
			    filter = input.value.toUpperCase();
			    ul = document.getElementById("products_container");
			    li = ul.getElementsByClassName("product-item");
			    for (i = 0; i < li.length; i++) {
			        a = li[i].getElementsByTagName("h6")[0];
			        txtValue = a.textContent || a.innerText;
			        if (txtValue.toUpperCase().indexOf(filter) > -1) {
			            li[i].style.display = "";
			        } else {
			            li[i].style.display = "none";
			        }
			    }
			});
		</script>

		<script>
			$('.control').on( 'click', function() {
				var filterValue = $(this).attr('data-filter');
				$("."+filterValue).css("display", "block");
				$('.product-item').not("."+filterValue).css("display", "none");
				
			});
		</script>

		<script>
			

			$(function() {
			    $('input[name=username]').on('keypress', function(e) {
			        if (e.which == 32)
			            return false;
			    });
			});
		</script>

		<script type="text/javascript">
	      	$(document).ready(function(){
				$( "#post_list" ).sortable({
					placeholder : "ui-state-highlight",
					update  : function(event, ui)
					{
						var post_order_ids = new Array();
						$('#post_list tr').each(function(){
							post_order_ids.push($(this).data("post-id"));
						});
						$.ajax({

							type:"get",
	                        url: "{{url('sortable')}}",
	                        data: {post_order_ids:post_order_ids},
	                        success:function(data)
							{
								 if(data){
								 	$(".alert-danger").hide();
								 	$(".alert-success ").show();
								 }else{
								 	$(".alert-success").hide();
								 	$(".alert-danger").show();
								 }
							}
						});
					}
				});
			});
	      </script>

	  <script src="{{asset('owner/js/custom.js')}}"></script>
	</body>
</html>