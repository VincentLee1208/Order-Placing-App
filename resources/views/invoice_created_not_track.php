  <div class="row">
      <div class="col-md-12">
         <section class="card">
            <header class="card-header bg-theme">
               <div class="card-actions">
                  <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
               </div>
   
               <h2 class="card-title text-center color-theme">Invoice created (Not in tracker)</h2>
            </header>
            <div class="card-body">
                @if(count($non_pendings)>0)
				@foreach($non_pendings as $tey => $non_pending)
				<!-- accordian -->
				<div id="accordionic{{$tey}}">
					<div class="card">
						<div id="headingic{{$tey}}">
							<h5 class="m-0 p-0">
							<button class="btn @if($non_pending->status==0) btn-dark @elseif ($non_pending->status==1) btn-warning @elseif($non_pending->status==2) btn-info @else btn-success @endif text-white w-100 collapsed mb-1" data-toggle="collapse" data-target="#collapseic{{$tey}}" aria-expanded="false" aria-controls="collapse">
							{{$non_pending->company_name}} - 	{{date("M d Y", strtotime($non_pending->order_date))}}
							<a data-confirm="This will permanently remove the order, are you sure you want to delete?" class="text-danger pull-right" href="{{url('order_delete')}}/{{$non_pending->id}}"><i class="fa fa-trash"></i></a>
							</button>
							</h5>
						</div>
						

						
						<div id="collapseic{{$tey}}" class="collapse" aria-labelledby="headingic{{$tey}}" data-parent="#accordionic{{$tey}}">
							<div class="card-body">
							<div class="table-responsive">
								<table class="table table-border border text-center">
									<thead align="center">
									<tr>
										<th colspan="2">Order ID #{{$non_pending->id}}</th>
									</tr>
									<?php $item_details = DB::table('order_items')->where('order_id',$non_pending->id)->get();?>
									@if(count($item_details)>0)
									<tr>
										<th>Item Code</th>
										<th>Quantity</th>
									</tr>
									@else
									@if($non_pending->attachment)
									<tr>
										<td colspan="2"><img width="100%" src="{{asset($non_pending->attachment)}}"></td>
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

										@if($non_pending->note)
										
										<tr>
											<th> Delivery Note:</th>
											<td>
												{{$non_pending->note}}
											</td>
										</tr>
										@endif
										<tr>
											<th>Status:</th>
											<td>
												@if($non_pending->status==0) 
												<span class="badge btn-danger">pending</span><br>
												@elseif($non_pending->status==1 || $non_pending->status==2)
												<span class="badge btn-warning">processed</span><br>
												@else
												<span class="badge btn-success">Completed</span><br>
												@endif
												
											</td>
										</tr>
										<tr>
											<td colspan="2">
												{{$non_pending->address}}, {{$non_pending->city}}, {{$non_pending->province}}, {{$non_pending->zip}}
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