@extends('head')
@section('maincontent')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Thank You</h2>
	
		<div class="right-wrapper text-right">
			<ol class="breadcrumbs">
				<li>
					<a href="{{route('dashboard')}}">
						<i class="fas fa-home"></i>
					</a>
				</li>
				<li><span>Pages</span></li>
				<li><span>Thank You</span></li>
			</ol>
	
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
		</div>
	</header>

	<!-- start: page -->
	<div class="row">
      <div class="col-md-12">
         <section class="card">
           <div class="jumbotron text-center">
              <h1>
			  
			  <!-- First Message-->

			  <?php
				$thankyou = DB::table('welcome_text')->where('id',2)->first();
				$thankyou2 = DB::table('welcome_text')->where('id',3)->first();
                $thankyou3 = DB::table('welcome_text')->where('id',4)->first();
                $promotext = $thankyou3->texts;
			  ?>

			  {{$thankyou->texts}}
			  
			  <!-- End of First Message-->
			  
			  </h1>
              <p class="lead"><strong>
			  
			  <!-- Second Message-->

			  {{$thankyou2->texts}}
			  
			  <!-- End of Second Message-->

			  <br>
			  <br>


			  <?php
                echo $promotext;
            ?>

			  </strong></p>
              <hr>
              
              <p class="lead">
                <a class="btn btn-primary btn-sm" href="{{route('dashboard')}}" role="button">Continue shopping</a>
              </p>
            </div>
         </section>
      </div>
    </div>
	
	<!-- end: page -->
</section>


@endsection