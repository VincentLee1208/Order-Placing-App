@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Orders</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Orders</span></li>
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
   
               <h2 class="card-title text-center color-theme">My Orders History</h2>
            </header>
            <div class="card-body">
                @if(count($orders)>0)
				@foreach($orders as $key => $order)
				<!-- accordian -->
				<div id="accordion{{$key}}">
					<div class="card">
						<div id="heading{{$key}}">
							<h5 class="m-0 p-0">
							<button class="btn @if($order->status==0) btn-dark @elseif ($order->status==1) btn-warning @elseif($order->status==2) btn-info @else btn-success @endif text-white w-100 collapsed mb-1" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse">
							{{$order->company_name}} - 	{{date("M d Y", strtotime($order->order_date))}}
							</button>
							</h5>
						</div>
						

						
						<div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion{{$key}}">
							<div class="card-body">
							<div class="table-responsive">
								<table class="table table-border border text-center">
									<thead align="center">
									<tr>
										<th colspan="2">Order ID #{{$order->id}}</th>
									</tr>
										<tr>
											<th>Item Code</th>
											<th>Quantity</th>
										</tr>
									</thead>
									<tbody>
									<?php $item_details = DB::table('order_items')->where('order_id',$order->id)->get();?>
										@if(count($item_details)>0)
										@foreach($item_details as $item)
										<tr>
											<td>{{$item->item_code}}</td>
											<td>{{$item->quantity}}</td>												
										</tr>
										@endforeach
										@endif

										@if($order->note)
										
										<tr>
											<th> Delivery Note:</th>
											<td>
												{!!$order->note!!}
											</td>
										</tr>
										@endif
										<tr>
											<th>Status:</th>
											<td>
												@if($order->status==0) 
												<span class="badge btn-danger">pending</span><br>
												@elseif($order->status==1 || $order->status==2)
												<span class="badge btn-warning">processed</span><br>
												@else
												<span class="badge btn-success">Completed</span><br>
												@endif
												
											</td>
										</tr>
										<tr>
											<td colspan="2">
												{{$order->address}}, {{$order->city}}, {{$order->province}}, {{$order->zip}}
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<a data-toggle="modal" href="#reorder{{$key}}" class="btn btn-sm bg-theme">Re-order</a>
											</td>
										</tr>
										
									</tbody>

								</table>
							</div>
							</div>
						</div>
						
					</div>
				</div>
				
										
				<!-- modal start -->
				@if(count($item_details)>0)
				<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reorder{{$key}}" class="modal fade">
			      <div class="modal-dialog">
			         <div class="modal-content">
			              <div class="modal-header">
			                <h4 class="modal-title">Re Order</h4>
			              </div>
			             
			              <form action="{{route('add2cart_reorder')}}" method="POST" enctype="multipart/form-data">
			                
			                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
			                <div class="modal-body">

			   					 <ul class="list-group mb-3">
		                            @foreach($item_details as $item)
		                            <?php $product=DB::table('products')->where('id',$item->product_id)->first();?>
		                            <li class="list-group-item d-flex justify-content-between lh-condensed">
		                            	@if($product)
			                               <div>
			                                  <h6 class="my-0">Item: {{$item->item_code}}</h6>
			                               </div>
			                               <div class="w-50 m-auto" data-plugin-spinner="" data-plugin-options="{ &quot;value&quot;:1, &quot;step&quot;: 1, &quot;min&quot;: 1, &quot;max&quot;: 200000 }">
				                                <div class="input-group">
			                                       <div class="input-group-prepend">
				                                       <button type="button" class="btn btn-sm btn-default spinner-down">
				                                       <i class="fas fa-minus"></i>
				                                       </button>
			                                       </div>
			                                       <input type="hidden" name="id[]" value="{{$product->id}}">
			                                       <input name="quantity[]" type="number" class="spinner-input form-control text-center form-control-sm" value="{{$item->quantity}}" maxlength="999">
			                                       <div class="input-group-append">
				                                       <button type="button" class="btn btn-sm btn-default spinner-up">
				                                       <i class="fas fa-plus"></i>
				                                       </button>
			                                       </div>
				                                </div>
				                             </div>
			                               	<span class="text-muted"><img width="42" src="{{asset($product->catalogue)}}" alt=""></span>
			                              @else
			                              	<div>
			                                  <h6 class="my-0">Item: {{$item->item_code}}</h6>
			                                  <small class="text-muted">x {{$item->quantity}}</small>
			                               </div>
			                               <span class="text-muted">Not available</span>
			                              @endif
		                            </li>
		                            @endforeach
		                            
		                         </ul>
			                    
			                </div>
			                <div class="modal-footer">
			                  <button data-dismiss="modal" class="btn btn-danger" type="button">Cancel</button>
			                  <button class="btn btn-success" type="submit">Add to cart</button>
			                </div>
			              </form>
			          </div>
			      </div>
			    </div>
			    
				@endif
				<!-- modal end -->

				@endforeach
				<!--  accordian end -->
				@endif
            </div>
         </section>
      </div>
    </div>
	
	<!-- end: page -->
</section>


@endsection