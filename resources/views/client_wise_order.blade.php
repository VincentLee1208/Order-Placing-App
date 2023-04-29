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
	<div class="row mb-2">
        <div class="col">
            <section class="card">
                <header class="card-header bg-theme">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                        <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
                    </div>
    
                    <h2 class="card-title color-theme text-center">Client's Order</h2>
                </header>
                <div class="card-body">
                    <form action="{{route('history')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 m-auto">
                                <select name="client_id" data-plugin-selectTwo class="form-control populate" onchange="this.form.submit()">
                                    <option>Select a client</option>
                                    @if(count($users)>0)
                                    @foreach($users as $key => $user)
                                        <option @if(isset($client_id) && $user->id==$client_id) selected @endif  value="{{$user->id}}"> {{$user->company_name}} </option>
                                    @endforeach
                                    @endif
                                    
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    @if(count($orders)>0)
	<div class="row">
      <div class="col-md-12">
         <section class="card">
            
            <div class="card-body">
                
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
										@if(empty($order->created))
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
										@endif										
									</tbody>

								</table>
							</div>
							</div>
						</div>
						
					</div>
				</div>

				@endforeach
				<!--  accordian end -->
				
            </div>
         </section>
      </div>
    </div>
	@endif
	<!-- end: page -->
</section>


@endsection