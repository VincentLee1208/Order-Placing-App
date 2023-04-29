@extends('head')
@section('maincontent')

<section role="main" class="content-body">
   <header class="page-header">
      <h2>Dashboard</h2>
      <div class="right-wrapper text-right">
         <ol class="breadcrumbs">
            <li>
               <a href="{{route('dashboard')}}">
               <i class="fas fa-home"></i>
               </a>
            </li>
            <li><span>Pages</span></li>
            <li><span>Dashboard</span></li>
         </ol>
         <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
      </div>
   </header>
   <!-- start: page -->
   <!-- start: page -->
   @if(count($products)>0)
   <div class="ecommerce-form-sidebar-overlay-wrapper">
      <div class="ecommerce-form-sidebar-overlay-body">
         <a href="#" class="ecommerce-form-sidebar-overlay-close"><i class="bx bx-x"></i></a>
         <div class="scrollable h-100 loading-overlay-showing" data-plugin-scrollable>
            <div class="loading-overlay">
               <div class="bounce-loader">
                  <div class="bounce1"></div>
                  <div class="bounce2"></div>
                  <div class="bounce3"></div>
               </div>
            </div>
            <div class="ecommerce-form-sidebar-overlay-content scrollable-content px-3 pb-3 pt-1"></div>
         </div>
      </div>
   </div>
   <div class="row justify-content-center justify-content-sm-between">
      <div class="col-sm-auto">
         <form action="ecommerce-products-list.html" class="search search-style-1 search-style-1-light mx-auto" method="GET">
            <div class="input-group">
               <input type="text" class="form-control" name="product-term" id="search_product2" placeholder="Search Item Code">
               <span class="input-group-append">
               <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
               </span>
            </div>
         </form>
      </div>
   </div>
   <div class="row row-gutter-sm mb-5">
      <div class="col-lg-2-5 col-xl-1-5 mb-4 mb-lg-0">
         <div class="filters-sidebar-wrapper bg-light rounded">
            <div class="card card-modern">
               <div class="card-header">
                  <div class="card-actions">
                     <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                  </div>
                  <h4 class="card-title">CATEGORIES</h4>
               </div>
               @foreach($products as $key => $product)
               <?php $matamota[]=$product->category;?>
               @endforeach
               <?php
                  $cats = array_unique($matamota);
                  
                  
                  ?>
               <div class="card-body">
                  <ul class="list list-unstyled mb-0 controls">
                     <li><a type="button" class="control" data-filter="product-item">All</a></li>
                     @foreach($cats as  $key => $cat)
                     <li><a type="button" class="control" data-filter="{{str_replace(' ', '', $cat)}}">{{$cat}}</a></li>
                     @endforeach
                  </ul>
               </div>
            </div>
            <hr class="solid opacity-7">
         </div>
      </div>
      
         <div class="col-lg-3-5 col-xl-4-5">
            <div class="row mb-2">
                  <div class="col-12">
                  <form action="{{route('add2fav')}}" method="post">
                  @csrf
                     <select name="client_id" data-plugin-selectTwo class="form-control populate m-0" required>
                        <option value="">Select client</option>
                        @if(count($users)>0)
                        @foreach($users as $key => $user)
                           <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                        @endif
                     </select>
                  </div>
            </div>
               <div id="products_container" class="row row-gutter-sm">
                  @foreach($products as $key => $product)
                  
                     <div id="{{$product->id}}" class="col-sm-6 col-xl-3 mb-2 px-1 product-item {{str_replace(' ', '', $product->category)}}">
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                           
                           <h6 class="my-0">Item: {{$product->item_code}}</h6>
                           &nbsp; <small>{{$product->descriptions}}</small>
                        </div>

                        <label for="prova{{$key}}" class="text-muted pointer">
                           <img width="42" src="{{asset($product->catalogue)}}" alt="">
                        </label>
                        
                        <input  id="prova{{$key}}" type="checkbox" name="product_id[]" value="{{$product->id}}">
                     </li>
                     </div>
            
                  @endforeach
                  
               </div>
               <button type="submit" class="btn btn-success">Submit</button>
         </div>
      </form>
   </div>
   @endif
   <!-- end: page -->
</section>
@endsection