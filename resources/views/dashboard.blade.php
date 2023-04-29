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
      <div class="col-sm-auto mb-1">
         <form action="ecommerce-products-list.html" class="search search-style-1 search-style-1-light mx-auto" method="GET">
            <div class="input-group">
               <input type="text" class="form-control" name="product-term" id="search_product" placeholder="Search Item Code">
               <span class="input-group-append">
               <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
               </span>
            </div>
         </form>
      </div>
      <div class="col-md-9 mb-1">
         @if(count($promoted)>0)
         <a class="banner btn btn-success btn-lg py-3 w-100" href="{{route('promoted')}}">Click to see our promotional items</a>
         @endif
      </div>
   </div>
   <div class="row row-gutter-sm mb-5">
      <div class="col-lg-1-5 col-xl-1-5 mb-4 mb-lg-0">
         <div class="filters-sidebar-wrapper bg-light rounded p-0">
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
      <div class="col-lg-4-5 col-xl-4-5">
         <div id="products_container" class="row">
            @foreach($products as $key => $product)
            <?php $product=DB::table('products')->where('id',$product->product_id)->first();?>
               <div class="col-md-6 col-lg-6 col-xl-4 p-1 product-item {{str_replace(' ', '', $product->category)}}">
                  <form action="{{route('add2cart')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{$product->id}}">
                     <table style="border:1px solid black; padding:2px;" class="table">
                        <tr class="border-0">
                           <td rowspan="2" width="30%" class="border-0 p-0 text-left">
                              <div class="image-frame-wrapper">
                                 <div class="image-frame-badges-wrapper">
                                    <span class="color-theme badge bg-theme">{{$product->item_code}}</span>
                                 </div>
                                  <a data-toggle="modal" href="#image{{$key}}" class="text-success">
                                    <img width="95%" src="{{asset($product->catalogue)}}" class="img-fluid" alt="{{$product->item_code}}" />
                                  </a>
                              </div>
                           </td>
                           <td colspan="2"  width="50%" class="border-0 p-0 text-left">
                           <?php 
                              $string=$product->descriptions;
                              $string = strip_tags($string);
                              if (strlen($string) > 117) {
                           
                                  // truncate string
                                  $stringCut = substr($string, 0, 117);
                                  $endPoint = strrpos($stringCut,' ');
                           
                                  //if the string doesn't contain any space then it will cut without word basis.
                                  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                              }
                           
                           ?>
                           <strong>{{$product->category}}</strong><br>
                           {!!$string!!}@if(strlen($product->descriptions) > 116)...<a data-toggle="popover" data-placement="top" data-content="{{$product->descriptions}}" class="text-success" href="#">more</a>@endif
                              
                           </td>
                           
                        </tr>
                        <tr>
                           <td class="border-0 p-0 pt-1 text-left">
                              <div class="w-100" data-plugin-spinner="" data-plugin-options="{ &quot;value&quot;:1, &quot;step&quot;: 1, &quot;min&quot;: 1, &quot;max&quot;: 200000 }">
                                 <div class="input-group">
                                       <div class="input-group-prepend">
                                       <button type="button" class="btn btn-sm btn-default spinner-down">
                                       <i class="fas fa-minus"></i>
                                       </button>
                                       </div>
                                       <input type="hidden" name="id" value="{{$product->id}}">
                                       <input name="quantity" type="number" class="spinner-input form-control text-center form-control-sm" maxlength="999">
                                       <div class="input-group-append">
                                       <button type="button" class="btn btn-sm btn-default spinner-up">
                                       <i class="fas fa-plus"></i>
                                       </button>
                                       </div>
                                 </div>
                              </div>
                           </td>
                           <td class="border-0 p-0 pt-1 text-center">
                              <button type="submit" class="btn btn-sm btn-success theme-color bg-theme"><i class="fa fa-cart-plus"></i></button>
                           </td>
                        </tr>
                        
                     </table>
                  </form>
               </div>
           
            @endforeach
         </div>
         
      </div>
   </div>
   <!-- end: page -->
   @endif
</section>


 @foreach($products as $key => $product)
  <?php $product=DB::table('products')->where('id',$product->product_id)->first();?>
      <!-- Modal -->
      <div class="modal fade" id="image{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$key}}" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center" id="exampleModalLabel{{$key}}">Item code: {{$product->item_code}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
             <img width="100%" src="{{asset($product->catalogue)}}">
            </div>
            
          </div>
        </div>
      </div>
      <!-- modal -->
  @endforeach

@endsection