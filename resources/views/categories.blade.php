@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Category</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Category</span></li>
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
   
               <h2 class="card-title text-center color-theme">Category List</h2>
            </header>
            <div class="card-body">
                <a data-toggle="modal" href="#newCat" class="btn btn-sm btn-info mb-2 bg-theme color-theme">Create Category</a>
               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="datatable-tabletools">
						<thead align="center">
							<tr>
								
								<th>Category</th>							
								<th>Action</th>
								
							</tr>
						</thead>
						<tbody align="center">
							@foreach($categories as $key => $category)
								<tr>
									<td>{{$category->category}}</td>
									<td  class="center">
				                      <a data-confirm="This will permanently remove the category, are you sure you want to delete?" class="text-danger" href="{{url('category_delete')}}/{{$category->id}}"><i class="fa fa-trash"></i></a>
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
	
	<!-- end: page -->
</section>

<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="newCat" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Create Category</h4>
              </div>
             
              <form action="{{route('category_save')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">

                	<div class="form-group">
                      <label class="" for="exampleInputEmail1">Category</label>
                      <input class="form-control form-control" name="category" type="text" required="">
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




@endsection