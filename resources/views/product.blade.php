@extends('layouts.master')

@section('title','Triwikrama | Product')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="box col-md-6">
                <div class="forSearch">
                    <span class="icon"><i class="fa fa-search fa-1x"></i></span>
                    <input type="search" name="search" id="search" placeholder="search">
                </div>
            </div>

            <div class="col-md-6">
                <button type="button" class="btn float-right text-white" name="btnAddTop" id="btnAddTop"><img src="{{ asset('img/IconTriwikramaAppAdmin/white/add2.png') }}" width="20px" height="20px" alt="" class="mr-1">Add Product</button>
            </div>
        </div>

        <div class="row mt-5" id="tampil">
            @foreach($product as $row)
                <div class="col-md-12 mt-2" id="show_product_{{ $row->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="card-img-top" height="260px" width="260px" src="{{ asset('img/contoh/ListUser.png') }}" alt="image 1">
                                </div>

                                <div class="col-md-6">
                                    <div class="card-header" id="card-header">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h3>{{ $row->nama_product }}</h3>                                
                                            </div>
                                            <div class="col-md-4">
                                                <a href="#" id="delete" class="delete btn ml-3 rounded-circle" data-id="{{ $row->id }}" style="height:50px;width:50px;background:#D91E18;color:white">
                                                    <img src="{{ asset('img/IconTriwikramaAppAdmin/white/rubbish-bin2.png') }}" class="mt-2" width="20px" height="20px" alt="">
                                                </a>
    
                                                <a href="#" id="edit" class="edit btn ml-2 rounded-circle" data-id="{{ $row->id }}" name="edit" style="height:50px;width:50px;background:#550E99;color:white">
                                                    <img  class="mt-2" src="{{ asset('img/IconTriwikramaAppAdmin/white/pencil-edit-button2.png') }}" width="20px" height="20px" alt="">
                                                </a>
                                            </div>
                                        </div>                                    
                                    </div>                                
                                    <p>{{ $row->deskripsi }}</p>                                
                                </div>
                            </div>
                        </div>
                    </div>                        
                </div>                                    
            @endforeach    
        </div>
    </div>

        <!-- Modal For Add/Edit Client -->

        <div class="modal fade" id="modalAddEditProduct" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ADD PRODUCT</h4>
                        <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <form action="post" id="form_add" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="">
                            <div class="row">
                                <div class="col-md-7">                                
                                    <div class="form-group">
                                        <label for="nama_product">Product Name</label>
                                        <input  class="form-control mt-3 rounded border-0" style="background-color:#EFF2F4;" type="text" name="nama_product" id="nama_product">
                                    </div>

                                    <div class="form group">
                                        <label for="deskripsi">Description</label>                                        
                                        <textarea class="form-control pb-5 pt-5 mt-3 rounded border-0" style="background-color:#EFF2F4;height:218px;" type="text" name="deskripsi" id="deskripsi"></textarea>
                                    </div>                                                                        
                                </div>  

                                <div class="col-md-5">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <button class="my-float2">
                                                <img src="{{ asset('img/IconTriwikramaAppAdmin/white/photo2.png') }}" width="20px" height="20px">
                                            </button>
                                        </div>                                        
                                    </div>
                                    <hr class="">   
                                    <div class="row float-right mr-3 mt-5">
                                        <button class="btn btn-link text-dark mr-3" data-dismiss="modal">CANCEL</button>
                                        <input type="hidden" name="action" id="action">
                                        <input type="hidden" name="hidden_id" id="hidden_id">
                                        <input type="submit" name="action_button" id="action_button" class="btn pl-4 pr-4" style="border-radius:100px;background:#550E99;color:white" value="ADD">
                                    </div>
                                </div>
                            </div>
                        </form>        
                    </div>                    
                </div>
            </div>
        </div>
    <!-- end of modal -->
    
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });                        

            $('#btnAddTop').click(function(){
                $('.modal-title').text("ADD PRODUCT");
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#modalAddEditProduct').modal('show');
            });

            $('#form_add').on('submit', function(event){
                event.preventDefault();
                if($('#action').val() == 'Add')
                {
                    $.ajax({
                        url: "{{ route('product.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success:function(data){
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                for(var count = 0; count < data.errors.length; count++)
                                {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if(data.success)
                            {
                                html = '<div class="alert alert-success">' + data.success + '</div>'
                                $('#form_add')[0].reset();
                                $('#modalAddEditProduct').modal('hide');
                                $("#show_product_").append(data);
                            }
                            $('#form_result').html(html);                            
                        },
                        error:function(xhr){
                            console.log(xhr.responseText);
                        }
                    })
                }

                if($('#action').val() == 'Edit')
                {
                    $.ajax({
                        url: "{{ route('product.update') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success:function(response){
                            var html='';
                            if(response.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                for(var count = 0; count < response.errors.length; count++)
                                {
                                    html += '<p>' + response.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if(response.success)
                            {
                                html = '<div class="alert alert-success">' + response.success + '</div>';
                                $('#form_add')[0].reset();
                                $('#modalAddEditProduct').modal('hide');
                                $("#show_product_").append(response);
                            }
                            $('#form_result').html(tampil);
                        },
                        error:function(xhr){
                            console.log(xhr.responseText);
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var mid = $(this).data('id');
                $('#form_result').html('');
                $.ajax({
                    url: "/product/"+mid+"/edit",
                    dataType: 'json',
                    success:function(html){
                        console.log(html);
                        $('#nama_product').val(html.data.nama_product);
                        $('#deskripsi').val(html.data.deskripsi);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text('Edit Data Product');
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#modalAddEditProduct').modal('show');
                    },
                    error:function(xhr){
                        console.log(xhr.responseText);
                    }
                })
            });

            $('body').on('click', '#delete', function(event){
                event.preventDefault();
                var mid = $(this).data('id');
                var conf = confirm("Are You sure want to delete ?");

                if(conf == true){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('product') }}" + '/' + mid,
                        data: {id:mid},
                        dataType: "json",
                        success:function(response){
                            console.log(response);
                            $('#show_product_' + mid).remove();
                        },
                        error:function(xhr){
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>

@endsection