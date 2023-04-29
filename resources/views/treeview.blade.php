@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Funnels</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Funnels</span></li>
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
                  <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
               </div>
   
               <h2 class="card-title text-center color-theme">All Funnels</h2>
            </header>
            <div class="card-body">
                 @if (!empty($flowers)) 
					@foreach($flowers as $i=>$flower)
					
						<!-- accordian -->
						<div id="accordion">
						   <div class="card">
						      <div id="heading{{$i}}">
						         <h5 class="m-0 p-0">
						            <button class="btn @if($flower->active==0) btn-dark @else btn-success @endif text-white w-100 collapsed" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
						            Funnel (#<?php echo $flower->id;?>)
						            </button>
						         </h5>
						      </div>
						      <?php
								 $my_flower_members=DB::select('SELECT * FROM (flower_members) WHERE flower_id=?',[$flower->id]);
							   ?>

							   
						      <div id="collapse{{$i}}" class="collapse" aria-labelledby="heading{{$i}}" data-parent="#accordion">
						         <div class="card-body">
						         	<div class="table-responsive">
							            <table class="table table-border text-center">
							           
							               <thead align="center">
							               	 <?php
											 foreach ($my_flower_members as $key => $my_flower_member) {
											 	$water=DB::table('admins')->where('id',$my_flower_member->user_id)->first();
											?>
								               	 @if($key==0)
									                  <tr style="border-bottom: 2px solid black;">
									                  	<td colspan="8" class="@if($my_flower_member->user_id==$user_id) text-success font-weight-bold @endif">
									                  		<figure class="profile-picture m-0">
									                  		<img width="35" height="35" class="rounded-circle" src="@if(!empty($water->image))
																		{{asset($water->image)}} 
																		@endif
																		@if(empty($water->image))	 
																		{{asset('owner/img/!sample-user.jpg')}} 
																		@endif">
															</figure>
									                  		{{$water->name}}
									                  	</td>
									                  </tr>
									                  <tr>
								                  @endif

								                  @if($key>0)
								                  			<td class="p-0"><div style="border-left:2px solid black;height:40px;margin: 0 auto;width:1px;" class="vl"></div>
								                  				<figure class="profile-picture m-0">
											                  		<img width="35" height="35" class="rounded-circle" src="@if(!empty($water->image))
																				{{asset($water->image)}} 
																				@endif
																				@if(empty($water->image))	 
																				{{asset('owner/img/!sample-user.jpg')}} 
																				@endif">
																	</figure>
								                  				{{$water->name}}
								                  			</td>
								                  @endif
								                  @if($key==0)
								                  		</tr>
								                  @endif
							                  <?php } ?>
							               </thead>
							               
							            </table>
							        </div>
						         </div>
						      </div>
						      
						   </div>
						</div>
						<!--  accordian end -->


						
						
					@endforeach
				@endif
            </div>
         </section>
      </div>
    </div>
	
	<!-- end: page -->
</section>


@endsection