@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Return & Exchange</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Return/Exchange</span></li>
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
   
               <h2 class="card-title text-center color-theme">Return/Exchange List</h2>
            </header>
            <div class="card-body">
                <a data-toggle="modal" href="#newCat" class="btn btn-sm btn-info mb-2 bg-theme color-theme">Create</a>
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
                            <th>Action</th>
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
            									<td data-title="Action" class="center">
                                  <a data-toggle="modal" href="#newCat{{$key}}" class="text-success"><i class="fa fa-edit"></i></a>
                                  <a data-confirm="Are you sure you want to archive?" class="text-success" href="{{url('complete_task')}}/{{$task->id}}"><i class="fa fa-check"></i></a>
                                  <a data-confirm="This will permanently remove the order, are you sure you want to delete?" class="text-danger" href="{{url('task_delete')}}/{{$task->id}}"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Create Task</h4>
              </div>
             
              <form action="{{route('task_save')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">

                	  <div class="form-group">
                      <label class="" for="exampleInputEmail1">Date</label>
                      <input class="form-control form-control" name="dates" type="date">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Method</label>
                      <select class="form-control" name="method">
                        <option value="exchange">exchange</option>
                        <option value="return">return</option>
                        <option value="send">send</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Company Name</label>
                      <input class="form-control form-control" name="company_name" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Return Item</label>
                      <input class="form-control form-control" name="return_item" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Exchange Item</label>
                      <input class="form-control form-control" name="exchange" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Invoice</label>
                      <input class="form-control form-control" name="invoice" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Received Good?</label>
                      <input class="form-control form-control" name="received" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">On Rack</label>
                      <input class="form-control form-control" name="on_rack" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Good's Condition</label>
                      <input class="form-control form-control" name="good_condition" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">A/P Credit Memo</label>
                      <input class="form-control form-control" name="memo" type="text">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Comment</label>
                      <textarea class="form-control" name="comment"></textarea>
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


@foreach($tasks as $key => $task)
	
	<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="newCat{{$key}}" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Update User</h4>
              </div>
             
              <form action="{{route('task_update')}}" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                <div class="modal-body">
                	<input type="hidden" name="id" value="{{$task->id}}">
                	<div class="form-group">
                      <label class="" for="exampleInputEmail1">Date</label>
                      <input class="form-control" name="dates" type="text" value="{{$task->dates}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Method</label>
                      <select class="form-control" name="method">
                        <option value="exchange" @if($task->method=='exchange') selected @endif>exchange</option>
                        <option value="return" @if($task->method=='return') selected @endif>return</option>
                        <option value="send" @if($task->method=='send') selected @endif>send</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Company Name</label>
                      <input class="form-control form-control" name="company_name" type="text" value="{{$task->company_name}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Return Item</label>
                      <input class="form-control form-control" name="return_item" type="text" value="{{$task->return_item}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Exchange Item</label>
                      <input class="form-control form-control" name="exchange" type="text" value="{{$task->exchange}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Invoice</label>
                      <input class="form-control form-control" name="invoice" type="text" value="{{$task->invoice}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Received Good?</label>
                      <input class="form-control form-control" name="received" type="text" value="{{$task->received}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">On Rack</label>
                      <input class="form-control form-control" name="on_rack" type="text" value="{{$task->on_rack}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Good's Condition</label>
                      <input class="form-control form-control" name="good_condition" type="text" value="{{$task->good_condition}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">A/P Credit Memo</label>
                      <input class="form-control form-control" name="memo" type="text" value="{{$task->memo}}">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Comment</label>
                      <textarea class="form-control" name="comment">{{$task->comment}}</textarea>
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