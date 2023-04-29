@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Users</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Users</span></li>
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
   
               <h2 class="card-title text-center color-theme">Users List</h2>
            </header>
            <div class="card-body">
                <a data-toggle="modal" href="#newCat" class="btn btn-sm btn-info mb-2 bg-theme color-theme">Create Account</a>
               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="table-responsive">
                     <table class="table table-bordered table-no-more table-striped" id="datatable-tabletools">
						<thead align="center">
							<tr>
								
								<th>Name</th>
                <th>Username</th>
                <th>Company Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Account Type</th>
								<th>Join Date</th>								
								<th>Action</th>
								
							</tr>
						</thead>
						<tbody align="center">
							@foreach($total_users as $key => $total_user)
								<tr>
									<td data-title="Name">{{$total_user->name}}</td>
                  <td data-title="Username">{{$total_user->username}}</td>
                  <td data-title="Company Name">{{$total_user->company_name}}</td>
									<td data-title="Email">{{$total_user->email}}</td>
									<td data-title="Phone">{{$total_user->phone}}</td>
									<td data-title="Account Type">{{$total_user->role}}</td>
									<td data-title="Join Date">
										{{date("M d Y", strtotime($total_user->joined_date))}}
									</td>
									
									<td data-title="Action" class="center">
                      <a data-toggle="modal" href="#newCat{{$key}}" class="text-success"><i class="fa fa-edit"></i></a>
                      <a data-confirm="This will permanently remove the user, are you sure you want to delete?" class="text-danger" href="{{url('delete_user')}}/{{$total_user->id}}"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Create User</h4>
              </div>
             
              <form action="{{route('joinnow_save')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">

                	  <div class="form-group">
                      <label class="" for="exampleInputEmail1">Name</label>
                      <input class="form-control form-control" name="name" type="text" required="">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Username</label>
                      <input class="form-control form-control" name="username" type="text" required="">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Company Name</label>
                      <input class="form-control form-control" name="company_name" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Email</label>
                      <input class="form-control form-control" name="email" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Phone</label>
                      <input class="form-control form-control" name="phone" type="text" required="">
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Account Type</label>
                      <select class="form-control form-control" name="role" type="text" required="" >
                      	<option value="admin">Admin</option>
                      	<option value="client">Client</option>
                        <option value="warehouse">Warehouse</option>
                        <option value="staff">Staff</option>
                      </select>
                    </div>

                    

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Password</label>
                      <input class="form-control form-control" name="password" type="password" required="">
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


@foreach($total_users as $key => $total_user)
	
	<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="newCat{{$key}}" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Update User</h4>
              </div>
             
              <form action="{{route('joinnow_update')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">
                	<input type="hidden" name="id" value="{{$total_user->id}}">
                	<div class="form-group">
                      <label class="" for="exampleInputEmail1">Name</label>
                      <input class="form-control form-control" name="name" type="text" required="" value="{{$total_user->name}}">
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Username</label>
                      <input class="form-control form-control" name="username" type="text" required="" value="{{$total_user->username}}">
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Company Name</label>
                      <input class="form-control form-control" name="company_name" type="text" value="{{$total_user->company_name}}">
                    </div>
                    
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Phone</label>
                      <input class="form-control form-control" name="phone" type="text" required="" value="{{$total_user->phone}}">
                    </div>

                    <div class="form-group">
                        <label class="" for="exampleInputEmail1">Email</label>
                        <input class="form-control form-control" name="email" type="text" value="{{$total_user->email}}">
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Account Type</label>
                      <select class="form-control form-control" name="role" type="text" required="" >
                      	<option value="admin" @if($total_user->role=='admin') selected @endif>Admin</option>
                      	<option value="client" @if($total_user->role=='client') selected @endif>Client</option>
                        <option value="warehouse" @if($total_user->role=='warehouse') selected @endif>Warehouse</option>
                        <option value="staff" @if($total_user->role=='staff') selected @endif>Staff</option>
                      </select>
                    </div>                   

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Password</label>
                      <input class="form-control form-control" name="password" type="password" placeholder="Keep it empty to not change old password">
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