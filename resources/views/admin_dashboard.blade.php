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
   
               <h2 class="card-title text-center color-theme">Order Received</h2>
            </header>
            <div class="card-body">
                @if(count($orders)>0)
             
				@foreach($orders as $key => $order)
				<!-- accordian -->
				<div id="accordion{{$key}}">
					<div class="card">
						<div id="heading{{$key}}">
							<h5 class="m-0 p-0">
							<div class="btn @if($order->status==0) btn-dark @elseif ($order->status==1) btn-warning @elseif($order->status==2) btn-info @else btn-success @endif text-white collapsed mb-1 d-flex justify-content-between" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse">
							<span>{{date("M d Y h:ia", strtotime($order->order_date))}}</span>  <span>{{$order->company_name}}</span> 
							<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a data-confirm="This will permanently remove the order, are you sure you want to delete?" class="text-danger pull-right" href="{{url('order_delete')}}/{{$order->id}}"><i class="fa fa-trash"></i></a></span>
							</div>
							
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
									<?php $item_details = DB::table('order_items')->where('order_id',$order->id)->get();?>
									@if(count($item_details)>0)
									<tr>
										<th>Item Code</th>
										<th>Quantity</th>
									</tr>
									@else
									@if($order->attachment)
									<tr>
										<td colspan="2">
											
										<embed style="height: 100vh;" src="{{$order->attachment}}" width="100%" />
										
										</td>
									</tr>
									@endif
									@endif
									</thead>
									<tbody>
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
											<form action="{{route('update_to_tracking')}}" method="post">
												@csrf
												<input type="hidden" name="id" value="{{$order->id}}">
											
												<td width="50%">
													<input type="date" name="created" class="form-control" required>
												</td>
												<td width="50%">
													<button type="submit" class="btn btn-sm btn-success" href="">Created</button>
												</td>
											</form>
										</tr>
										<tr>
										   <form action="{{route('update_note')}}" method="post">
										  @csrf
										  <input type="hidden" name="order_id" value="{{$order->id}}">
										    <td>
    										  <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }' name="note" placeholder="add <br> after each line.">	{!!$order->note!!}</textarea>
										    </td>
										    <td><button type="submit" class="btn btn-sm btn-success">Update Note</button></td>
										    </form>
										</tr>
									</tbody>

								</table>
							</div>
							</div>
						</div>
						
					</div>
				</div>

				@endforeach
				
				<!--  accordian end -->
				
				@endif
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
   
               <h2 class="card-title text-center color-theme">In tracker</h2>
            </header>
            <div class="card-body">
                @if(count($trackeds)>0)
				@foreach($trackeds as $aey => $tracked)
				<!-- accordian -->
				<div id="accordionit{{$aey}}">
					<div class="card">
						<div id="headingit{{$aey}}">
							<h5 class="m-0 p-0">
							<div class="btn @if($tracked->status==0) btn-dark @elseif ($tracked->status==1) btn-warning @elseif ($tracked->status==2) btn-info @else btn-success @endif text-white w-100 collapsed mb-1 d-flex justify-content-between" data-toggle="collapse" data-target="#collapseit{{$aey}}" aria-expanded="false" aria-controls="collapse">
							<table width="100%">
								<tbody>
									<tr align="center">
										<td width="30%"><span>{{date("M d Y h:ia", strtotime($tracked->order_date))}}</span></td>
										<td width="30%"> <span>{{$tracked->company_name}}</span></td>
										<td width="30%"><span>{{date("M d Y", strtotime($tracked->created))}}</span></td>
										<td width="10%"><span><a data-confirm="This will permanently remove the order, are you sure you want to delete?" class="text-danger pull-right" href="{{url('order_delete')}}/{{$tracked->id}}"><i class="fa fa-trash"></i></a></span></td>
									</tr>
								</tbody>
							</table>
							
							</div>
							</h5>
						</div>
						

						
						<div id="collapseit{{$aey}}" class="collapse" aria-labelledby="headingit{{$aey}}" data-parent="#accordionit{{$aey}}">
							<div class="card-body">
							<div class="table-responsive">
								<table class="table table-border border text-center">
									<thead align="center">
									<tr>
										<th colspan="2">Order ID #{{$tracked->id}}</th>
									</tr>
									<?php $item_details = DB::table('order_items')->where('order_id',$tracked->id)->get();?>
									@if(count($item_details)>0)
									<tr>
										<th>Item Code</th>
										<th>Quantity</th>
									</tr>
									@else
									@if($tracked->attachment)
									<tr>
										<td colspan="2"><img width="100%" src="{{asset($tracked->attachment)}}"></td>
									</tr>
									@endif
									@endif
									</thead>
									<tbody>
										@if(count($item_details)>0)
										@foreach($item_details as $item)
										<tr>
											<td>{{$item->item_code}}</td>
											<td>{{$item->quantity}}</td>												
										</tr>
										@endforeach
										@endif

										@if($tracked->note)
										
										<tr>
											<th> Delivery Note:</th>
											<td>
												{!!$tracked->note!!}
											</td>
										</tr>
										@endif
										<tr>
											<th>Status:</th>
											<td>
												@if($tracked->status==0) 
												<span class="badge btn-danger">pending</span><br>
												@elseif($tracked->status==1 || $tracked->status==2)
												<span class="badge btn-warning">processed</span><br>
												@else
												<span class="badge btn-success">tracked</span><br>
												@endif
												
											</td>
										</tr>
										<tr>
											<td colspan="2">
												{{$tracked->address}}, {{$tracked->city}}, {{$tracked->province}}, {{$tracked->zip}}
											</td>
										</tr>
										
									</tbody>

								</table>
							</div>
							</div>
						</div>
						
					</div>
				</div>
				@endforeach
				<!--  accordian end -->
				@endif
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
   
               <h2 class="card-title text-center color-theme">Completed</h2>
            </header>
            <div class="card-body">
                @if(count($completeds)>0)
				@foreach($completeds as $pey => $completed)
				<!-- accordian -->
				<div id="accordionc{{$pey}}">
					<div class="card">
						<div id="headingc{{$pey}}">
							<h5 class="m-0 p-0">
							<div class="btn @if($completed->status==0) btn-dark @elseif ($completed->status==1) btn-warning @elseif($completed->status==2) btn-info @else btn-success @endif text-white w-100 collapsed mb-1" data-toggle="collapse" data-target="#collapsec{{$pey}}" aria-expanded="false" aria-controls="collapse">
							<table width="100%">
								<tbody>
									<tr align="center">
										<td width="25%"><span>{{date("M d Y h:ia", strtotime($completed->order_date))}}</span></td>
										<td width="25%"> <span>{{$completed->company_name}}</span></td>
										<td width="25%"> <span>{{date("M d Y", strtotime($completed->created))}}</span></td>
										<td width="20%"> <span>Inv #{{$completed->invoice_no}}</span></td>
										<td><span><a data-confirm="This will permanently remove the order, are you sure you want to delete?" class="text-danger pull-right" href="{{url('order_delete')}}/{{$completed->id}}"><i class="fa fa-trash"></i></a></span></td>
									</tr>
								</tbody>
							</table>
							</div>
							</h5>
						</div>
						

						
						<div id="collapsec{{$pey}}" class="collapse" aria-labelledby="headingc{{$pey}}" data-parent="#accordionc{{$pey}}">
							<div class="card-body">
							<div class="table-responsive">
								<table class="table table-border border text-center">
									<thead align="center">
									<tr>
										<th colspan="2">Order ID #{{$completed->id}}</th>
									</tr>
									<?php $item_details = DB::table('order_items')->where('order_id',$completed->id)->get();?>
									@if(count($item_details)>0)
									<tr>
										<th>Item Code</th>
										<th>Quantity</th>
									</tr>
									@else
									@if($completed->attachment)
									<tr>
										<td colspan="2"><img width="100%" src="{{asset($completed->attachment)}}"></td>
									</tr>
									@endif
									@endif
									</thead>
									<tbody>
										@if(count($item_details)>0)
										@foreach($item_details as $item)
										<tr>
											<td>{{$item->item_code}}</td>
											<td>{{$item->quantity}}</td>												
										</tr>
										@endforeach
										@endif

										@if($completed->note)
										
										<tr>
											<th> Delivery Note:</th>
											<td>
												{!!$completed->note!!}
											</td>
										</tr>
										@endif
										<tr>
											<th>Status:</th>
											<td>
												@if($completed->status==0) 
												<span class="badge btn-danger">pending</span><br>
												@elseif($completed->status==1 || $completed->status==2)
												<span class="badge btn-warning">processed</span><br>
												@else
												<span class="badge btn-success">Completed</span><br>
												@endif
												
											</td>
										</tr>
										<tr>
											<td colspan="2">
												{{$completed->address}}, {{$completed->city}}, {{$completed->province}}, {{$completed->zip}}
											</td>
										</tr>
										
									</tbody>

								</table>
							</div>
							</div>
						</div>
						
					</div>
				</div>
				@endforeach
				<div class="text-center">
					<a data-confirm="This will permanently remove the order, are you sure you want to delete?" class="btn btn-danger" href="{{url('/delete_complted_orders')}}">Delete all completed orders</a>
				</div>
				<!--  accordian end -->
				@endif
            </div>
         </section>
      </div>
    </div>
	
	<!-- end: page -->
</section>




@endsection