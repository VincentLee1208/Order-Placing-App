@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Tracking</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Tracking</span></li>
			</ol>
	
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
		</div>
	</header>

	<!-- start putting info -->
	@if(count($not_filleds)>0)
	<div class="row">
      <div class="col-md-12">
         <section class="card">
            <header class="card-header bg-theme">
               <div class="card-actions">
                  <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
               </div>
   
               <h2 class="card-title text-center color-theme">Order created (Not in tracker)</h2>
            </header>
            <div class="card-body">
               
				@foreach($not_filleds as $key => $not_filled)
				<!-- accordian -->
				<div id="accordion{{$key}}">
					<div class="card">
						<div id="heading{{$key}}">
							<h5 class="m-0 p-0">
							<button class="btn @if($not_filled->status==0) btn-dark @elseif ($not_filled->status==1) btn-warning @else btn-success @endif text-white w-100 collapsed mb-1" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse">
							{{$not_filled->company_name}} - 	{{date("M d Y", strtotime($not_filled->created))}}
							</button>
							</h5>
						</div>
						

						
						<div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion{{$key}}">
							<div class="card-body">
							<div class="table-responsive">
								<table class="table table-border border text-center">
									
									<tbody>
										<tr>
											 <form action="{{route('order_update')}}" method="POST">
												@csrf
												<input type="hidden" name="id" value="{{$not_filled->id}}">
											
												<td>
													<select name="method" class="form-control" required="1">
								                      	<option value="">Select Method</option>
								                      	<option value="delivery">Delivery</option>
								                      	<option value="pickup">Pickup</option>
								                      	<option value="shipment">shipment</option>
								                      </select>
												</td>
												<td>
													<input class="form-control" name="invoice_no" type="text" required="" placeholder="Invoice No">
												</td>
												<td>
													<select name="location" class="form-control">
								                      	<option value="">Location</option>
								                     	  <option> Vancouver</option>
									                      <option> Burnaby</option>
									                      <option> Surrey</option>
									                      <option> Richmond</option>
									                      <option> North/West Vancouver</option>
									                      <option> Coquitlam</option>
									                      <option> Langley</option>
									                      <option> White Rock</option>
									                      <option> New Westminster</option>
									                      <option> Delta</option>
									                      <option> APE</option>
								                      </select>
												</td>
												<td>
													<select name="rep" class="form-control" required="1">
								                      	<option value="">Select Rep</option>
								                      	@if(count($reps)>0)
								                      	@foreach($reps as $rep)
								                      	<option value="{{$rep->name}}">{{$rep->name}}</option>
								                      	@endforeach
								                      	@endif
								                      </select>
												</td>
												<td>
													<input type="text" class="form-control" name="comment" placeholder="Comment">
												</td>
												<td>
													<button type="submit" class="btn btn-sm btn-success" href="">Input to track</button>
												</td>
											</form>
										</tr>

									</tbody>

								</table>

								<table class="table table-border border text-center">
									<tbody>
										<?php $item_details = DB::table('order_items')->where('order_id',$not_filled->id)->get();?>
											@if(count($item_details)>0)
									<tr>
										<th>Item Code</th>
										<th>Quantity</th>
									</tr>
									@else
									@if($not_filled->attachment)
									<tr>
										<td colspan="2"><img width="100%" src="{{asset($not_filled->attachment)}}"></td>
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

										@if($not_filled->note)
										
										<tr>
											<th> Delivery Note:</th>
											<td>
												{!!$not_filled->note!!}
											</td>
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
	<!-- end putting info -->
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
   
               <h2 class="card-title text-center color-theme">Delivery Pending</h2>
            </header>
            <div class="card-body">
            	<div class="col-md-12 m-0 p-0">
            		<div class="table-responsive">
            			<table class="table table-border border text-center mb-4 p-0">
						<tbody>
							<tr>
								<th colspan="7">Create a quick order</th>
							</tr>
							 <form action="{{route('quick_order')}}" method="POST" enctype="multipart/form-data">
							 	@csrf
							<tr>
								
									
									<td>
										<label>Date</label>
										<input type="date" name="created" class="form-control mt-1" required>
									</td>
									<td>
										<label>Company</label>
										<input type="text" name="company_name" class="form-control" placeholder="Type company name" required>
									</td>
									<td>
										<label>Method</label>
										<select name="method" class="form-control" required="1">
					                      	<option value="">Select Method</option>
					                      	<option value="delivery">Delivery</option>
					                      	<option value="pickup">Pickup</option>
					                      	<option value="shipment">shipment</option>
					                      </select>
									</td>
									<td>
										<label>Invoice</label>
										<input class="form-control" name="invoice_no" type="text" required="" placeholder="Invoice No">
									</td>
									<td>
										<label>Location</label>
										<select name="location" class="form-control">
					                      	<option value="">Location</option>
					                     	  <option> Vancouver</option>
						                      <option> Burnaby</option>
						                      <option> Surrey</option>
						                      <option> Richmond</option>
						                      <option> North/West Vancouver</option>
						                      <option> Coquitlam</option>
						                      <option> Langley</option>
						                      <option> White Rock</option>
						                      <option> New Westminster</option>
						                      <option> Delta</option>
						                      <option> APE</option>
					                      </select>
									</td>
									<td>
										<label>Reps</label>
										<select name="rep" class="form-control" required="1">
					                      	<option value="">Select Rep</option>
					                      	@if(count($reps)>0)
					                      	@foreach($reps as $rep)
					                      	<option value="{{$rep->name}}">{{$rep->name}}</option>
					                      	@endforeach
					                      	@endif
					                      </select>
									</td>
									<td>
										<label>Comment</label>
										<input type="text" class="form-control" name="comment" placeholder="Comment">

									</td>
									
								
							</tr>
							<tr>
                                    <td colspan="7">
                                        <div class="form-group row">
                                            <label class="col-lg-3 control-label text-lg-right pt-2">Attachment</label>
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-file"></i>
                                                        </span>
                                                    </span>
                                                    <input type="file" name="attachement" class="form-control">
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </td>
							</tr>
							<tr>
								<td colspan="7">
									<button type="submit" class="btn btn-sm btn-success" href="">Add to track</button>
								</td>
							</tr>
							</form>
						</tbody>

					</table>
            		</div>
            	</div>

            	<form action="{{route('print')}}" method="post" target="_blank">
               		@csrf
					<button id="print" type="submit" name="action" value="print" class="btn btn-sm btn-info my-1">Print</button>
					<button id="complete" type="submit" name="action" value="complete" class="btn btn-sm btn-success my-1" onclick="setTimeout('top.window.close()', 100); ">Complete</button>
					<button type="submit" name="action" value="delivery" class="btn btn-sm btn-primary my-1" onclick="setTimeout('top.window.close()', 100); ">Move to delivery</button>
					<div class="dropdown mb-2 mt-1 float-md-right">
					  <a onclick="myFunction()" class="dropbtn btn-sm text-white">Scroll to date</a>
					  <div id="myDropdown" class="dropdown-content">
					    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
					    @foreach($createds as $key => $created)
					    <a href="#scrolly{{$key}}">{{date("M d Y", strtotime($created))}}</a>
					    @endforeach
					  </div>
					</div>
	                <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
	               	
	                    <div class="table-responsive">
	                        <table class="table table-bordered table-striped" id="datatable-tabletools">
	                     	    @foreach($createds as $key => $created)
									
							    <thead align="center">
								    <tr id="scrolly{{$key}}" class="bg-dark text-white">
									    <th colspan="10">{{date('l', strtotime($created))}}, {{date("M d Y", strtotime($created))}}</th>
								    </tr>
							    </thead>
							    <tbody align="center">
								    <?php $orders = DB::table('orders')->where([['created',$created],['status',2],['delivery',0]])->get(); ?>
								    <tr>	
                                        <th>Print</th>
                                        <th>Sl. No</th>
                                        <th>Method</th>
                                        <th>Company Name</th>
                                        <th>Invoice</th>
                                        <th>Address</th>
                                        <th>Location</th>						
                                        <th>Rep</th>
                                        <th>Action</th>
                                        <th>Comment</th>
                                        
                                    </tr>
                                    @foreach($orders as $mey => $order)
                                    <tr>
                                        <td><input type="checkbox" name="order_id[]" value="{{$order->id}}"></td>
                                        <td>{{$mey+1}}</td>
                                        <td>{{$order->method}}</td>
                                        <td>{{$order->company_name}}</td>
                                        <td>{{$order->invoice_no}}</td>
                                        <td>{{$order->address}}, {{$order->city}}, {{$order->province}}, {{$order->zip}}</td>
                                        <td>{{$order->location}}</td>
                                        <td>{{$order->rep}}</td>
                                        
                                        <td width="10%"  class="center">
										<a data-toggle="modal" href="#lar{{$mey}}{{$key}}" class="text-success"><i class="fa fa-eye"></i></a>

                                        <a data-toggle="modal" href="#lara{{$mey}}{{$key}}" class="text-success"><i class="fa fa-edit"></i></a>
                                        <a data-confirm="This will permanently remove the order, are you sure you want to delete?" class="text-danger" href="{{url('order_delete')}}/{{$order->id}}"><i class="fa fa-trash"></i></a>
                                        @if($order->status==3)
                                            <span class="badge badge-success">completed</span>
                                        @else
                                            <a data-confirm="Are you sure you want to complete?" class="text-danger" href="{{url('complete_order')}}/{{$order->id}}"><i class="fa fa-check"></i></a>
                                        @endif
                                        
                                        </td>
                                        <td>{{$order->comment}}</td>
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

    <div class="row">
      <div class="col-md-12">
         <section class="card">
            <header class="card-header bg-theme">
               <div class="card-actions">
                  <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
               </div>
   
               <h2 class="card-title text-center color-theme">Out for delivery</h2>
            </header>
            <div class="card-body">
            	
            	<form action="{{route('print')}}" method="post" target="_blank">
               		@csrf
					<button type="submit" name="action" value="print" class="btn btn-sm btn-info mb-1">Print</button>
					<button type="submit" name="action" value="complete" class="btn btn-sm btn-success mb-1" onclick="setTimeout('top.window.close()', 100); ">Complete</button>
					<button type="submit" name="action" value="pending" class="btn btn-sm btn-primary mb-1" onclick="setTimeout('top.window.close()', 100); ">Move to pending</button>
					<div class="dropdown mb-2 float-right">
				  <a onclick="mYdrop()" class="dropbtn btn-sm text-white">Scroll to date</a>
					  <div id="mYdrop" class="dropdown-content">
					    <input class="form-control" type="text" placeholder="Search.." id="youInput" onkeyup="mYfilter()">
					    @foreach($createds as $key => $created)
					    <a href="#scrolly1{{$key}}">{{date("M d Y", strtotime($created))}}</a>
					    @endforeach
					  </div>
					</div>
	               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
	               	
	                  <div class="table-responsive">
	                     <table class="table table-bordered table-striped" id="datatable-tabletools">
	                     	@foreach($createds as $key => $created)
							<?php $orders = DB::table('orders')->where([['created',$created],['status',2],['delivery',1]])->get(); ?>
							@if(count($orders)>0)	
							<thead align="center">
								<tr id="scrolly1{{$key}}" class="bg-dark text-white">
									<th colspan="10">{{date('l', strtotime($created))}}, {{date("M d Y", strtotime($created))}}</th>
								</tr>
							</thead>
							<tbody align="center">
								
								<tr>	
									<th>Print</th>
									<th>Sl. No</th>
									<th>Method</th>
									<th>Company Name</th>
									<th>Invoice</th>
									<th>Address</th>
									<th>Location</th>						
									<th>Rep</th>
									<th>Action</th>
									<th>Comment</th>
									
								</tr>
								@foreach($orders as $mey => $order)
								<tr>
									<td><input type="checkbox" name="order_id[]" value="{{$order->id}}"></td>
									<td>{{$mey+1}}</td>
									<td>{{$order->method}}</td>
									<td>{{$order->company_name}}</td>
									<td>{{$order->invoice_no}}</td>
									<td>{{$order->address}}, {{$order->city}}, {{$order->province}}, {{$order->zip}}</td>
									<td>{{$order->location}}</td>
									<td>{{$order->rep}}</td>
									
									<td  class="center">
						             <!--  <a data-toggle="modal" href="#lara{{$mey}}{{$key}}" class="text-success"><i class="fa fa-edit"></i></a> -->
						              @if($order->status==3)
						              	<span class="badge badge-success">completed</span>
						              @else
						              	<a data-confirm="Are you sure you want to complete?" class="text-danger" href="{{url('complete_order')}}/{{$order->id}}"><i class="fa fa-check"></i></a>
						              @endif
						              
						         	</td>
						         	<td>{{$order->comment}}</td>
								</tr>
								
								@endforeach
							</tbody>
							@endif
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
</section>
@if(isset($createds))
@foreach($createds as $key => $created)
<?php $orders = DB::table('orders')->where([['created',$created],['status',2],['delivery',0]])->get(); ?>
@foreach($orders as $mey => $order)
<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="lara{{$mey}}{{$key}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Order</h4>
                </div>
                
                <label class="" for="exampleInputEmail1">Change Date</label>
                    <form action="{{route('change_date')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$order->id}}">
                                                
                        <td width="50%">
                            <input type="date" name="created" class="form-control" required>
                        </td>
                        <td width="50%">
                            <button type="submit" class="btn btn-success" href="">Change Date</button>
                        </td>
                    </form>

                <form action="{{route('order_update')}}" method="POST" enctype="multipart/form-data">

                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">

                	<input type="hidden" name="id" value="{{$order->id}}">
                	<div class="form-group">
                      <label class="" for="exampleInputEmail1">Method</label>
                      <select name="method" class="form-control" required="1">
                      	<option value="">Select Method</option>
                      	<option value="delivery" @if($order->method=='delivery') selected @endif>Delivery</option>
                      	<option value="pickup" @if($order->method=='pickup') selected @endif>Pickup</option>
                      	<option value="shipment" @if($order->method=='shipment') selected @endif>shipment</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Invoice no.</label>
                      <input class="form-control" name="invoice_no" type="text" required="" value="{{$order->invoice_no}}">
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Location</label>
                      <select name="location" class="form-control">
                      	<option value="">Location</option>
                     	  <option> Vancouver</option>
	                      <option> Burnaby</option>
	                      <option> Surrey</option>
	                      <option> Richmond</option>
	                      <option> North/West Vancouver</option>
	                      <option> Coquitlam</option>
	                      <option> Langley</option>
	                      <option> White Rock</option>
	                      <option> New Westminster</option>
	                      <option> Delta</option>
	                      <option> APE</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Rep</label>
	                     <select name="rep" class="form-control" required="1">
	                      	<option value="">Select Rep</option>
	                      	@if(count($reps)>0)
	                      	@foreach($reps as $rep)
	                      	<option @if($rep->name == $order->rep) selected @endif value="{{$rep->name}}">{{$rep->name}}</option>
	                      	@endforeach
	                      	@endif
	                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Comment</label>
                      <textarea class="form-control" name="comment">{{$order->comment}}</textarea>
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

  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="lar{{$mey}}{{$key}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Order Items</h4>
                </div>

				<table class="table table-border border text-center">
					<tbody>
						<?php $item_details = DB::table('order_items')->where('order_id',$order->id)->get();?>
							@if(count($item_details)>0)
					<tr>
						<th>Item Code</th>
						<th>Quantity</th>
					</tr>

					@else
					@if($order->attachment)
					<tr>
						<td colspan="2"><img width="100%" src="{{asset($order->attachment)}}"></td>
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
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endforeach
@endforeach
@endif
@endsection
