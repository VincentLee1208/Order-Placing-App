@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Representatives</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>representatives</span></li>
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
   
               <h2 class="card-title text-center color-theme">Representatives List</h2>
            </header>
            <div class="card-body">
                <a data-toggle="modal" href="#newCat" class="btn btn-sm btn-info mb-2 bg-theme color-theme">Create</a>
               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="table-responsive">
                     <table class="table table-bordered table-no-more table-striped" id="datatable-tabletools">
            						<thead align="center">
            							<tr>
            								<th>Name</th>            								
                            <th>Action</th>
            							</tr>
            						</thead>
            						<tbody align="center">
            							@foreach($reps as $key => $rep)
            								<tr>
                              <td data-title="Name">{{$rep->name}}</td>
            									<td data-title="Action" class="center">
                                  <a data-toggle="modal" href="#newCat{{$key}}" class="text-success"><i class="fa fa-edit"></i></a>
                                  <a data-confirm="Are you sure you want to archive?" class="text-danger" href="{{url('delete_rep')}}/{{$rep->id}}"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Create Rep</h4>
              </div>
             
              <form action="{{route('rep_save')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">

                	  <div class="form-group">
                      <label class="" for="exampleInputEmail1">Name</label>
                      <input class="form-control form-control" name="name" type="text">
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


@foreach($reps as $key => $rep)
	
	<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="newCat{{$key}}" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Update User</h4>
              </div>
             
              <form action="{{route('rep_update')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">
                	<input type="hidden" name="id" value="{{$rep->id}}">
                	  <div class="form-group">
                      <label class="" for="exampleInputEmail1">Name</label>
                      <input class="form-control" name="name" type="text" value="{{$rep->name}}">
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
	
@endforeach


@endsection