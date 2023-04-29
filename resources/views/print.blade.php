<!DOCTYPE html>
<html>
<head>
  <title>Print Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <style type="text/css">
    .alert-danger,.alert-success{
        display: none;
      }
  </style>
</head>
<body>
  <div class="row">
      <div class="col-md-12">
         <section class="card">
            
            <div class="card-body">
               
               <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
                    <i class="fa fa-fw fa-check-circle"></i>
                    <strong> Success ! </strong> <span class="success-message">Order has been updated successfully. </span>
                    Click <a href="{{url('/print')}}">here</a> before click on print button
                  </div>
                  <div class="alert icon-alert with-arrow alert-danger form-alter" role="alert">
                    <i class="fa fa-fw fa-times-circle"></i>
                    <strong> Note !</strong> <span class="warning-message"> Empty list cant be ordered </span>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th align="left" colspan="4">Driver Name: </th>
                            <th align="center" colspan="2">{{date("M d Y")}}</th>
                          </tr>
                          <tr align="center">
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Invoice No.</th>
                            <th>Reasons/Other</th>
                            <th>Accepted Goods</th>
                            <th>Delivered</th>
                          </tr>
                        </thead>
                        <tbody style="cursor: all-scroll;" align="center" id="post_list">
                          
                          @foreach($print_ids as $key => $print_id)
                          <?php $order = DB::table('orders')->where('id',$print_id->order_id)->first();?>
                          <input type="hidden" name="order_id[]" value="{{$order->id}}">
                            <tr data-post-id={{$order->id}}>
                              <td>{{$order->company_name}}</td>
                              <td>{{$order->address}}, {{$order->city}}, {{$order->province}}, {{$order->zip}}</td>
                              <td>{{$order->invoice_no}}</td>
                              <td></td>
                              <td></td>
                              <td></td>
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
  <!-- Vendor -->
    <script src="{{asset('owner/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('owner/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
    <script src="{{asset('owner/vendor/popper/umd/popper.min.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('owner/vendor/common/common.js')}}"></script>
    <script src="{{asset('owner/vendor/nanoscroller/nanoscroller.js')}}"></script>
    <script src="{{asset('owner/vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>
    <script src="{{asset('owner/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
    
    <!-- Specific Page Vendor -->
    <script src="{{asset('owner/vendor/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('owner/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
    <script src="{{asset('owner/vendor/select2/js/select2.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>
    <script src="{{asset('owner/vendor/jquery-maskedinput/jquery.maskedinput.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
    <script src="{{asset('owner/vendor/fuelux/js/spinner.js')}}"></script>
    <script src="{{asset('owner/vendor/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-markdown/js/markdown.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-markdown/js/to-markdown.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-markdown/js/bootstrap-markdown.js')}}"></script>
    <script src="{{asset('owner/vendor/codemirror/lib/codemirror.js')}}"></script>
    <script src="{{asset('owner/vendor/codemirror/addon/selection/active-line.js')}}"></script>
    <script src="{{asset('owner/vendor/codemirror/addon/edit/matchbrackets.js')}}"></script>
    <script src="{{asset('owner/vendor/codemirror/mode/javascript/javascript.js')}}"></script>
    <script src="{{asset('owner/vendor/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{asset('owner/vendor/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>
    <script src="{{asset('owner/vendor/codemirror/mode/css/css.js')}}"></script>
    <script src="{{asset('owner/vendor/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('owner/vendor/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
    <script src="{{asset('owner/vendor/ios7-switch/ios7-switch.js')}}"></script>
    <!-- Specific Page Vendor -->
    <script src="{{asset('owner/vendor/select2/js/select2.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/media/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js')}}"></script>
    <script src="{{asset('owner/vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js')}}"></script>
    <script src="{{asset('owner/vendor/pnotify/pnotify.custom.js')}}"></script>


    <!--(remove-empty-lines-end)-->
    
    <!-- Theme Base, Components and Settings -->
    <script src="{{asset('owner/js/theme.js')}}"></script>
    
    <!-- Theme Custom -->
    
    
    <!-- Theme Initialization Files -->
    <script src="{{asset('owner/js/theme.init.js')}}"></script>

    <!-- Examples -->
    <script src="{{asset('owner/js/examples/examples.advanced.form.js')}}"></script>
    <!-- Examples -->
    <script src="{{asset('owner/js/examples/examples.datatables.default.js')}}"></script>
    <script src="{{asset('owner/js/examples/examples.datatables.row.with.details.js')}}"></script>
    <script src="{{asset('owner/js/examples/examples.datatables.tabletools.js')}}"></script>
     <script src="{{asset('owner/js/jscolor.js')}}"></script>
     <script src="{{asset('owner/js/modified_jquery.isotope.min_v2.js')}}"></script>
     
     <!-- <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script> -->

    @if (Session::has('message'))
    <script type="text/javascript">

      new PNotify({
        title: 'Success!',
        text: '{{Session::get('message')}}',
        type: 'success'
      });
    </script>
    @endif


    @if (Session::has('error'))
    <script type="text/javascript">

      new PNotify({
        title: 'Error!',
        text: '{{Session::get('error')}}',
        type: 'error'
      });
    </script>
    @endif

    <!-- <script>
      tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak code',
        toolbar_mode: 'code',
        menubar: "tools"
      });
    </script> -->
    
    <script type="text/javascript">
            $(document).on('click', ':not(form)[data-confirm]', function(e){
          if(!confirm($(this).data('confirm'))){
              e.stopImmediatePropagation();
              e.preventDefault();
            }
        });
      </script>
       <script>
    $(document).ready(function(){
      $("#btn1").click(function(){
        $("#weapon_add").append('<input type="text" name="car_code[]" class="form-control" placeholder="Task Step" required>');
      });
      
    });
    </script>

    <script>
    $(document).ready(function(){
      $("#btn3").click(function(){
        $("#weapon_add2").append('<input type="text" name="car_code[]" class="form-control" placeholder="Task Step" required><a title="Click here if you want to add more!" class="btn2" style="font-size:20px;" href="#"><i class="fas fa-minus-circle"></i></a>');
      });
      
    });
    </script>

    <script>
    $(document).ready(function(){
      $(".btn2").click(function(){
        $(this).prev().remove();
        $(this).remove();
      });
      
    });
    </script>

    <script>
      $(function () {
        $('[data-toggle="popover"]').popover()
      })
    </script>

    <script>
      // search feature for product search
      $("#search_product").keyup(function(){
        var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById("search_product");
          filter = input.value.toUpperCase();
          ul = document.getElementById("products_container");
          li = ul.getElementsByClassName("product-item");
          for (i = 0; i < li.length; i++) {
              a = li[i].getElementsByTagName("span")[0];
              txtValue = a.textContent || a.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  li[i].style.display = "";
            li[i].style.opacity = "1";
              } else {
                  li[i].style.display = "none";
            li[i].style.opacity = "0";
              }
          }
      });


      // init Isotope
      // var $grid = $('#products_container').isotope({
      //  itemSelector: '.product-item',
      //  layoutMode: 'fitRows'
      // });
      // filter items on button click
      // $('.controls').on( 'click', 'a', function() {
      //  var filterValue = $(this).attr('data-filter');
      //  $grid.isotope({ filter: filterValue });
      // });
    </script>

    <script>
      // search feature for product search
      $("#search_product2").keyup(function(){
        var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById("search_product2");
          filter = input.value.toUpperCase();
          ul = document.getElementById("products_container");
          li = ul.getElementsByClassName("product-item");
          for (i = 0; i < li.length; i++) {
              a = li[i].getElementsByTagName("h6")[0];
              txtValue = a.textContent || a.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  li[i].style.display = "";
              } else {
                  li[i].style.display = "none";
              }
          }
      });
    </script>

    <script>
      $('.control').on( 'click', function() {
        var filterValue = $(this).attr('data-filter');
        $("."+filterValue).css("display", "block");
        $('.product-item').not("."+filterValue).css("display", "none");
        
      });
    </script>

    <script>
      // doesnot allow space
      $(function() {
          $('input[name=category]').on('keypress', function(e) {
              if (e.which == 32)
                  return false;
          });
      });
    </script>

  <script type="text/javascript">
   $(document).ready(function(){
       $( "#post_list" ).sortable({
             placeholder : "ui-state-highlight",
             update  : function(event, ui)
             {
               var post_order_ids = new Array();
               $('#post_list tr').each(function(){
                 post_order_ids.push($(this).data("post-id"));
               });
               $.ajax({
             
                   type:"get",
                   url: "{{url('sortable')}}",
                   data: {post_order_ids:post_order_ids},
                   success:function(data)
                   {
                      if(data){
                       $(".alert-danger").hide();
                       $(".alert-success ").show();
                      }else{
                       $(".alert-success").hide();
                       $(".alert-danger").show();
                      }
                   }
               });
             }
       });
   });
</script>
</body>
</html>