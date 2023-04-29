@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Products</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Products</span></li>
			</ol>
	
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
		</div>
	</header>

  <div class="row mb-5">
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
                <a data-toggle="modal" href="#addcat" class="btn btn-sm btn-info mb-2 bg-theme color-theme">Create Category</a>
               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div>
                     <table class="table table-bordered table-striped" id="datatable-default">
                        <thead align="center">
                          <tr>
                            
                            <th>Category</th>             
                            <th>Action</th>
                            
                          </tr>
                        </thead>
                        <tbody align="center">
                          @foreach($categories as $ley => $category)
                            <tr>
                              <td>{{$category->category}}</td>
                              <td  class="center">
                                <a data-toggle="modal" href="#category{{$ley}}" class="text-success"><i class="fa fa-edit"></i></a>
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

  <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addcat" class="modal fade">
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

   @foreach($categories as $ley => $category)
   <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="category{{$ley}}" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Update category</h4>
              </div>
             
              <form action="{{route('category_update')}}" method="POST" enctype="multipart/form-data">
                
                @csrf
                <div class="modal-body">
                  <input type="hidden" name="id" value="{{$category->id}}">
                  <div class="form-group">
                      <label class="" for="exampleInputEmail1">Old Category</label>
                      <input class="form-control" name="old_category" type="text" required="" value="{{$category->category}}" readonly>
                      <label class="" for="exampleInputEmail1">New Category</label>
                      <input class="form-control" name="category" type="text" required="" value="{{$category->category}}">
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


	<!-- start: page -->
	<div class="row">
      <div class="col-md-12">
         <section class="card">
            <header class="card-header bg-theme">
               <div class="card-actions">
                  <a href="#" class="card-action card-action-toggle color-theme" data-card-toggle></a>
                  <a href="#" class="card-action card-action-dismiss color-theme" data-card-dismiss></a>
               </div>
   
               <h2 class="card-title text-center color-theme">Product List</h2>
            </header>
            <div class="card-body">
                <a data-toggle="modal" href="#newCat" class="btn btn-sm btn-info mb-2 bg-theme color-theme">Add Product</a>
               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="datatable-tabletools">
						<thead align="center">
							<tr>
								
								<th>Item Code</th>
                <th>Category</th>
								<th>Descriptions</th>
								<th>Catalogue</th>								
								<th>Action</th>
								
							</tr>
						</thead>
						<tbody align="center">
							@foreach($products as $key => $product)
								<tr>
									<td>{{$product->item_code}}</td>
                  <td>{{$product->category}}</td>
									<td>{{$product->descriptions}}</td>
									<td>
                    <a data-toggle="modal" href="#image{{$key}}" class="text-success">
                    <img width="50" src="{{asset($product->catalogue)}}" alt="">
                    </a>
                  </td>
									<td  class="center">
                      <a data-toggle="modal" href="#product{{$key}}" class="text-success"><i class="fa fa-edit"></i></a>
                      <a data-confirm="This will permanently remove the product, are you sure you want to delete?" class="text-danger" href="{{url('product_delete')}}/{{$product->id}}"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Create Product</h4>
              </div>
             
              <form action="{{route('product_save')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                	  <div class="form-group">
                      <label class="" for="exampleInputEmail1">Item Code</label>
                      <input class="form-control form-control" name="item_code" type="text" required="">
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Category</label>
                      <select class="form-control form-control" name="category" type="text" required="" >
                      	<option value="admin">Select Category</option>
                        @foreach($categories as $category)
                      	<option value="{{$category->category}}">{{$category->category}}</option>
                      	@endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Descriptions</label>
                      <textarea class="form-control form-control" name="descriptions" type="text" required=""></textarea>
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Catalogue Image</label>
                      <input class="form-control form-control" name="catalogue" type="file" required="" accept=".png, .jpg, .jpeg">
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


@foreach($products as $key => $product)
	
	<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="product{{$key}}" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Update Product</h4>
              </div>
             
              <form action="{{route('product_update')}}" method="POST" enctype="multipart/form-data">
                
                @csrf
                <div class="modal-body">
                	<input type="hidden" name="id" value="{{$product->id}}">
                	<div class="form-group">
                      <label class="" for="exampleInputEmail1">Item Code</label>
                      <input class="form-control form-control" name="item_code" type="text" required="" value="{{$product->item_code}}">
                    </div>

                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Category</label>
                      <select class="form-control form-control" name="category" type="text" required="" >
                      	<option value="admin">Select Category</option>

                      @foreach($categories as $category)
                      	<option value="{{$category->category}}" @if($category->category==$product->category) selected @endif>{{$category->category}}</option>
                      	@endforeach
                      	
                      </select>
                    </div>
                    
                     <div class="form-group">
                      <label class="" for="exampleInputEmail1">Descriptions</label>
                      <textarea class="form-control form-control" name="descriptions" type="text" required="">{{$product->descriptions}}</textarea>
                    </div>
                    <div class="form-group">
                      <label class="" for="exampleInputEmail1">Catalogue Image</label>
                      <input class="form-control form-control" name="image_url" type="hidden" value="{{$product->catalogue}}">
                      <input class="form-control form-control" name="catalogue" type="file" accept=".png, .jpg, .jpeg">
                    </div>
                    <img width="50" src="{{asset($product->catalogue)}}" alt="">                

                    
                    
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



@foreach($products as $key => $product)
<!-- Modal -->
<div class="modal fade" id="image{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$key}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel{{$key}}">Item code: {{$product->item_code}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
       <img width="100%" src="{{asset($product->catalogue)}}">
      </div>
      
    </div>
  </div>
</div>
<!-- modal -->
@endforeach


@endsection