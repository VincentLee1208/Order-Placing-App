@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>New Order</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>New Order</span></li>
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
   
               <h2 class="card-title text-center color-theme">Create Order</h2>
            </header>
            <div class="card-body">
                <div class="form-body">
                    <form action="{{route('order_save')}}" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Clients</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-users"></i>
                                        </span>
                                    </span>
                                    <select name="client_id" data-plugin-selectTwo class="form-control w-100" required="1">
                                        <option value="">Select a client</option>
                                        @if(count($users)>0)
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->company_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Delivery Address (optional)</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="text" name="address" class="form-control" placeholder="Address">
                                    </div>
                                    <div class="d-md-none mb-3"></div>
                                    <div class="col-sm-2">
                                        <input type="text" name="city" class="form-control" placeholder="City">
                                    </div>
                                    <div class="d-md-none mb-3"></div>
                                    <div class="col-sm-2">
                                        <input type="text" name="province" class="form-control" placeholder="Province">
                                    </div>
                                    <div class="d-md-none mb-3"></div>
                                    <div class="col-sm-2">
                                        <input type="text" name="zip" class="form-control" placeholder="Zip code">
                                    </div>
                                </div>
    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Note</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }' name="note" placeholder="add <br> after each line."></textarea>
                                </div>
                            </div>
                        </div>
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
                        <div class="form-group row">
                            <div class="col-md-6 mx-auto mt-2">
                                <button class="subscribe btn btn-primary btn-block" type="submit"> Create Order  </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
         </section>
      </div>
    </div>
	
	<!-- end: page -->
</section>

@endsection