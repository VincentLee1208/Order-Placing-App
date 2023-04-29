@extends('head')
@section('maincontent')

<section role="main" class="content-body">
   <header class="page-header">
      <h2>All products</h2>
      <div class="right-wrapper text-right">
         <ol class="breadcrumbs">
            <li>
               <a href="{{route('dashboard')}}">
               <i class="fas fa-home"></i>
               </a>
            </li>
            <li><span>Pages</span></li>
            <li><span>products</span></li>
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






   </div>



    <div class="row">
        <div class="col-md-12">
            <section class="card">
                <header class="card-header bg-theme">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
                    </div>
    
                    <h2 class="card-title text-center color-theme">Change Checkout Message</h2>
                </header>
                <div class="card-body">
                    <div class="form-body">
                        <div class="col-md-10 mb-1">
                            <form action="{{route('welcome_text')}}" method="post">
                            @csrf
                                <div class="form-row align-items-center">
                                    <div class="col-sm-8 my-1">
                                        <label class="sr-only" for="inlineFormInputGroupUsername">Welcome Text</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-signature"></i></div>
                                            </div>
                                            <textarea type="text" name="texts" class="form-control" id="inlineFormInputGroupUsername" placeholder="Welcome text for checkout page">{{$welcome->texts}}</textarea>
                                        </div>
                                    </div>
                                            
                                    <div class="col-auto my-1">
                                        <button type="submit" value="W" name="form1" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <section class="card">
                <header class="card-header bg-theme">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
                    </div>
    
                    <h2 class="card-title text-center color-theme">Change Order Confirmation Text</h2>
                </header>
                <div class="card-body">
                    <div class="form-body">
                        <div class="col-md-10 mb-1">
                            <form action="{{route('welcome_text')}}" method="post">
                            @csrf
                                <div class="form-row align-items-center">
                                    <div class="col-sm-10 my-1">
                                        <label class="sr-only" for="inlineFormInputGroupUsername">Thank You Text</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-signature"></i></div>
                                            </div>
                                            <textarea type="text" rows="4" name="texts2" class="form-control" id="inlineFormInputGroupUsername" placeholder="Thank you text first message after checkout page">{{$thankyou->texts}}</textarea>

                                            <textarea type="text" rows="4" name="texts3" class="form-control" id="inlineFormInputGroupUsername" placeholder="Thank you text second message after checkout page">{{$thankyou2->texts}}</textarea>

                                            <textarea type="text" rows="4" name="texts4" class="form-control" id="inlineformInputGroupUsername" placeholder="Thank you page promotion message">{{$thankyou3->texts}}</textarea>
                                        </div>
                                    </div>
                                            
                                    <div class="col-auto my-1">
                                        <button type="submit" value="TY" name="form2" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>

                            <p>
                                <h3>To add a link to another page copy and fill in the following:</h3>
                                <br>

                                &lt;a href="Extension of page you want to link to"> Words you want to be clickable &lt;/a>

                                <br>
                                <br>

                                For example:

                                <br>

                                To link to the apeorder.com/dashboard, the link would be 

                                <br>
                                <br>

                                &lt;a href="dashboard">Dashboard&lt;/a>
                            </p>

                            <div class="col-auto my-1">
                                <a data-toggle="modal" href="#preview" class="btn btn-sm btn-info mb-2 bg-theme color-theme">Preview</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <h1> Promote Products </h1>
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
               <div class="col-md-6 col-lg-6 col-xl-4 p-1 product-item {{str_replace(' ', '', $product->category)}}">
                  <a data-toggle="modal" href="#newCat{{$key}}">
                     <table style="border:1px solid black; padding:2px;" class="table">
                        <tr class="border-0">
                           <td width="36%" class="border-0 p-0 text-left">
                              <div class="image-frame-wrapper">
                                 <div class="image-frame-badges-wrapper">
                                    <span class="color-theme badge bg-theme">{{$product->item_code}}</span>
                                 </div>
                                 <img width="100%" src="{{asset($product->catalogue)}}" class="img-fluid" alt="Product Short Name" />
                              </div>
                           </td>
                           <td width="64%" class="border-0 p-0 text-left">
                           <?php 
                              $string=$product->descriptions;
                              $string = strip_tags($string);
                              if (strlen($string) > 100) {
                           
                                  // truncate string
                                  $stringCut = substr($string, 0, 100);
                                  $endPoint = strrpos($stringCut,' ');
                           
                                  //if the string doesn't contain any space then it will cut without word basis.
                                  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                              }
                           
                           ?>
                           <strong>{{$product->category}}</strong> @if($product->promoted==1) <span class="float-right badge badge-success">promoted</span> @endif<br>
                              {!!$string!!}...<a data-toggle="popover" data-placement="top" data-content="{{$product->descriptions}}" class="text-success" href="#">more</a>
                              
                           </td>
                           
                        </tr>                        
                     </table>
                  </a>
               </div>
           
            @endforeach
         </div>
         
      </div>
   </div>
   <!-- end: page -->
   @endif
</section>



 @foreach($products as $key => $product)
   
   <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="newCat{{$key}}" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add banner</h4>
              </div>
             
              <form action="{{route('marketing')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <input type="hidden" name="id" value="{{$product->id}}">
                <div class="modal-body">
                    <p class="text-center">
                        <img style="border:2px solid #fff;" width="45%" src="{{asset($product->catalogue)}}">
                    </p>
                     

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Add banner for this product</label>
                      <input class="form-control form-control" name="banner" type="file" required="">
                    </div>

                    
                    
                </div>
                <div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-danger" type="button">Cancel</button>
                  <button class="btn btn-success" type="submit">Save</button>
                </div>
              </form>
          </div>
      </div>
    </div>
  <!-- modal -->
   
@endforeach


    <!-- Modal -->

    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="preview" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thank You Text Preview</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <section class="card">
                            <div class="jumbotron text-center">
                                <h1>
                                
                                <!-- First Message-->

                                <?php
                                    $thankyou = DB::table('welcome_text')->where('id',2)->first();
                                    $thankyou2 = DB::table('welcome_text')->where('id',3)->first();
                                    $thankyou3 = DB::table('welcome_text')->where('id',4)->first();
                                    $promotext = $thankyou3->texts;
                                ?>

                                {{$thankyou->texts}}
                                
                                <!-- End of First Message-->
                                
                                </h1>
                                <p class="lead"><strong>
                                
                                <!-- Second Message-->

                                {{$thankyou2->texts}}
                                
                                <!-- End of Second Message-->

                                <br>
                                <br>

                                <?php
                                    echo $promotext;
                                ?>

                                </strong></p>
                                <hr>
                                
                                <p class="lead">
                                    <a class="btn btn-primary btn-sm" href="{{route('dashboard')}}" role="button">Continue shopping</a>
                                </p>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
                





@endsection