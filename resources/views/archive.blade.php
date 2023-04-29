@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Archive</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Archive</span></li>
			</ol>
	
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
		</div>
	</header>

	@if(isset($createds))
	<!-- start: page -->
	<div class="row">
      <div class="col-md-12">
         <section class="card">
            <header class="card-header bg-theme">
               <div class="card-actions">
                  <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
               </div>
   
               <h2 class="card-title text-center color-theme">Archived Orders</h2>
            </header>
            <div class="card-body">
            	<div class="dropdown mb-2">
				  <button onclick="myFunction()" class="dropbtn btn-sm">Scroll to date</button>
				  <div id="myDropdown" class="dropdown-content">
				    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
				    @foreach($createds as $key => $created)
				    <a href="#scrolly{{$key}}">{{date("M d Y", strtotime($created))}}</a>
				    @endforeach
				  </div>
				</div>
            	<form action="{{route('print')}}" method="post" target="_blank">
               		@csrf
					<button type="submit" class="btn btn-sm btn-info mb-1">Print</button>
	               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
	               	
	                  <div class="table-responsive">
	                     <table class="table table-bordered table-striped" id="datatable-tabletools">
	                     	@foreach($createds as $key => $created)
									
							<thead align="center">
								<tr id="scrolly{{$key}}" class="bg-dark text-white">
									<th colspan="9">{{date('l', strtotime($created))}}, {{date("M d Y", strtotime($created))}}</th>
								</tr>
							</thead>
							<tbody align="center">
								<?php $orders = DB::table('orders')->where([['created',$created],['status',3]])->get(); ?>
								<tr>	
									<th>Print</th>
									<th>Method</th>
									<th>Company Name</th>
									<th>Invoice</th>
									<th>Address</th>
									<th>Location</th>						
									<th>Rep</th>
									<th>Comment</th>
									<th>Status</th>
									
								</tr>
								@foreach($orders as $mey => $order)
								<tr>
									<td><input type="checkbox" name="order_id[]" value="{{$order->id}}"></td>
									<td>{{$order->method}}</td>
									<td>{{$order->company_name}}</td>
									<td>{{$order->invoice_no}}</td>
									<td>{{$order->address}}, {{$order->city}}, {{$order->province}}, {{$order->zip}}</td>
									<td>{{$order->location}}</td>
									<td>{{$order->rep}}</td>
									<td>{{$order->comment}}</td>
									<td  class="center">
						              @if($order->status==3)
						              	<span class="badge badge-success">completed</span>
						              @else
						              	<a data-confirm="Are you sure you want to complete?" class="text-danger" href="{{url('complete_order')}}/{{$order->id}}"><i class="fa fa-check"></i></a>
						              @endif
						         	</td>
						         	
								</tr>
								
								@endforeach
							</tbody>
							@endforeach
						  </table>
	                  </div>
	               
	               </div>
              </form>
            </div>
         </section>
      </div>
    </div>
    @endif
	<!-- end: page -->
	<div class="row">
      <div class="col-md-12">
         <section class="card">
            <header class="card-header bg-theme">
               <div class="card-actions">
                  <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
               </div>
   
               <h2 class="card-title text-center color-theme">Task & Returns</h2>
            </header>
            <div class="card-body">
               
               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="table-responsive">
                     <table class="table table-bordered table-no-more table-striped" id="datatable-tabletools">
						<thead align="center">
							<tr>
								<th>Date</th>
		                        <th>Method</th>
		                        <th>Company Name</th>
								<th>Return Item</th>
								<th>Exchange Item</th>
								<th>Invoice</th>
								<th>Received Good?</th>								
								<th>On Rack</th>
		                        <th>Good's Condition</th>
		                        <th>A/P Credit Memo</th>
		                        <th>Comment</th>
		                        
		        			</tr>
						</thead>
						<tbody align="center">
							@foreach($tasks as $key => $task)
							<tr>
								  <td data-title="Date">
		                            {{date("M d Y", strtotime($task->dates))}}
		                          </td>
		                          <td data-title="Method">{{$task->method}}</td>
		                          <td data-title="Company Name">{{$task->company_name}}</td>
									<td data-title="Return Item">{{$task->return_item}}</td>
									<td data-title="Exchange Item">{{$task->exchange}}</td>
									<td data-title="Invoice">{{$task->invoice}}</td>
									<td data-title="Received Good?">
										{{$task->received}}
									</td>
		                          <td data-title="On Rack">
		                            {{$task->on_rack}}
		                          </td>
		                          <td data-title="Good's Condition">
		                            {{$task->good_condition}}
		                          </td>
		                          <td data-title="A/P Credit Memo">
		                            {{$task->memo}}
		                          </td>
		        				  <td data-title="Comment">
		                            {{$task->comment}}
		                          </td>
		        				  
							</tr>
							@endforeach
		    						
		    							
		    						</tbody>
		    					</table>
                  </div>
               </div>
            </div>
         </section>
      </div>
  </div>
</section>

@endsection