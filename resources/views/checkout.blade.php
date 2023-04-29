@extends('head')
@section('maincontent')

<section role="main" class="content-body">
   <header class="page-header">
      <h2>Checkout</h2>
      <div class="right-wrapper text-right">
         <ol class="breadcrumbs">
            <li>
               <a href="{{route('dashboard')}}">
               <i class="fas fa-home"></i>
               </a>
            </li>
            <li><span>Pages</span></li>
            <li><span>Checkout</span></li>
         </ol>
         <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
      </div>
   </header>
   <!-- start: page -->
   <div class="row">
        <div class="col-md-12">
             <section class="card">
                <header class="card-header bg-theme">
                   <div class="card-actions">
                      <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                      <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
                   </div>
       
                   <h2 class="card-title text-center color-theme">Checkout</h2>
                </header>
                <div class="card-body">
                   <div class="row">
                      
                      <div class="col-md-4 order-md-2 mb-4">
                        <p class="text-center"> <button data-toggle="modal" href="#daysinfo" class="btn btn-sm bg-theme">See Delivery Dates</button></p>
                         <h4 class="mb-3">Billing address</h4>
                         <form action="{{route('order_save')}}" method="post">
                         @csrf
                           @foreach(Session::get('cart') as $id => $quantity)
                            <?php $product=DB::table('products')->where('id',$id)->first();?>
                            <input type="hidden" name="id[]" value="{{$id}}">
                            <input type="hidden" name="item_code[]" value="{{$product->item_code}}">
                            <input type="hidden" name="quantity[]" value="{{$quantity['quantity']}}">
                            @endforeach

                            <div class="row">
                               <div class="col-md-6 mb-3">
                                  <label for="firstName">Full name</label>
                                  <input type="text" class="form-control" name="name" placeholder="" value="{{$user_details->name}}" readonly>
                                  <div class="invalid-feedback">
                                     Valid first name is required.
                                  </div>
                               </div>
                               <div class="col-md-6 mb-3">
                                  <label for="firstName">Company name</label>
                                  <input type="text" class="form-control" name="company_name" placeholder="" value="{{$user_details->company_name}}" readonly>
                                  <div class="invalid-feedback">
                                     Valid first name is required.
                                  </div>
                               </div>
                            </div>
                            
                            <div class="row">
                               <div class="col-md-12 mb-3">
                                  <label for="country">Choose location</label>
                                 
                                  <select name="location_id" class="custom-select d-block w-100" id="country" required>
                                     <option value="">Choose...</option>
                                    @if(count($locations)>0)
                                     @foreach($locations as $key => $location)
                                     <option value="{{$location->id}}" @if($key==0) selected @endif>{{$location->address}}, {{$location->city}}, {{$location->province}}, {{$location->zip}}</option>
                                     @endforeach
                                    @endif
                                  </select>
                                 
                                  <br>
                                   <a href="{{route('profile')}}">Add new location</a>
                              
                               </div>
                            </div>
                            <hr class="mb-4">
                            <div class="mb-3">
                               <label for="address2">Special instructions (Store hours,Front door,back door, etc) <span class="text-muted">(Optional)</span></label>
                               <textarea name="note" class="form-control" placeholder="Note"></textarea>
                            </div>
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                         </form>
                      </div>
                      <div class="col-md-8 order-md-1">
                         <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Your cart</span>
                            <span class="badge badge-secondary badge-pill">{{count(Session::get('cart'))}}</span>
                         </h4>
                         <ul class="list-group mb-3">
                           @foreach(Session::get('cart') as $id => $quantity)
                            <?php $product=DB::table('products')->where('id',$id)->first();?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                               <div>
                                  <h6 class="my-0">{{$product->item_code}}</h6>
                                  <small class="text-muted">x {{$quantity['quantity']}}</small>
                               </div>
                               <span class="text-muted"><img width="42" src="{{asset($product->catalogue)}}" alt=""></span>
                               <a class="pull-right" href="{{url('/product/clearSingle')}}/{{$id}}">
                                <i class="fas fa-trash text-danger"></i>
                              </a>
                            </li>
                            @endforeach
                            <a href="{{url('/product/clearCart')}}" class="btn btn-sm btn-danger mt-3 d-inline-block text-white">Clear</a>
                         </ul>
                         <p class="text-center font-weight-bold mt-5">{{$welcome->texts}}</p>
                      </div>
                   </div>
                </div>
             </section>
        </div>
    </div>
   <!-- end: page -->
</section>

   <!-- Modal -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="daysinfo" class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Check delivery days for specific place</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
              </div>
             
              
                <div class="modal-body">
                <div class="table-responsive">
                <table class="table">
                  <tr>
                     <td><button style="font-size:10px;" class="btn btn-sm bg-theme" onclick="VancouverFunction()">Vancouver</button><td>
                     <td><button style="font-size:10px;" class="btn btn-sm bg-theme" onclick="NVanWVanFunction()">North/West Vancouver</button><td>
                     <td><button style="font-size:10px;" class="btn btn-sm bg-theme" onclick="RichmondFunction()">Richmond</button><td>
                     <td><button style="font-size:10px;" class="btn btn-sm bg-theme" onclick="BurnabyFunction()">Burnaby/Coquitlam/New Westminster</button><td>
                     <td><button style="font-size:10px;" class="btn btn-sm bg-theme" onclick="DeltaFunction()">Delta/Langley/Surrey/White Rock</button><td>
                  </tr>
                </table>
                </div>
                <div class="table-responsive">
                  <table id="table" class="table">
                       <tr>
                          <td>
                             <b>Days</b>
                          </td>
                          <td id="Monday">
                             Monday
                          </td>
                          <td id="Tuesday">
                             Tuesday
                          </td>
                          <td id="Wednesday">
                             Wednesday
                          </td>

                          <td id="Thursday">
                             Thursday
                          </td>
                          <td id="Friday">
                             Friday
                          </td>
                       </tr>
                  </table>
                </div>

                	  

                    
                    
                </div>
                
                <script>
                  var Monday = document.getElementById("table").rows[0].cells[1];
                  var Tuesday = document.getElementById("table").rows[0].cells[2];
                  var Wednesday = document.getElementById("table").rows[0].cells[3];
                  var Thursday= document.getElementById("table").rows[0].cells[4];
                  var Friday = document.getElementById("table").rows[0].cells[5];

                  function BurnabyFunction() {
                     Monday.style.backgroundColor = "white";
                     Tuesday.style.backgroundColor = "steelblue";
                     Wednesday.style.backgroundColor = "white";
                     Thursday.style.backgroundColor = "steelblue";
                     Friday.style.backgroundColor = "white";
                  }

                  function VancouverFunction() {
                     Monday.style.backgroundColor = "yellow";
                     Tuesday.style.backgroundColor = "yellow";
                     Wednesday.style.backgroundColor = "yellow";
                     Thursday.style.backgroundColor = "yellow";
                     Friday.style.backgroundColor = "yellow";
                  }

                  function NVanWVanFunction() {
                     Monday.style.backgroundColor = "white";
                     Tuesday.style.backgroundColor = "salmon";
                     Wednesday.style.backgroundColor = "white";
                     Thursday.style.backgroundColor = "white";
                     Friday.style.backgroundColor = "salmon";
                  }

                  function RichmondFunction() {
                     Monday.style.backgroundColor = "darkolivegreen";
                     Tuesday.style.backgroundColor = "white";
                     Wednesday.style.backgroundColor = "darkolivegreen";
                     Thursday.style.backgroundColor = "white";
                     Friday.style.backgroundColor = "darkolivegreen"; 
                  }

                  function DeltaFunction() {
                     Monday.style.backgroundColor = "violet";
                     Tuesday.style.backgroundColor = "white";
                     Wednesday.style.backgroundColor = "violet";
                     Thursday.style.backgroundColor = "white";
                     Friday.style.backgroundColor = "white";
                  }

            </script>
          </div>
      </div>
    </div>
  <!-- modal -->


@endsection