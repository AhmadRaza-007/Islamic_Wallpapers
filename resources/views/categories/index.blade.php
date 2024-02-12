@extends('app')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Categories</h1>

            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Categories
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            class="btn btn-dark">Add Category</button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{ route('storecategory') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category Name</label>
                                            <input type="text" name="name" class="form-control" id="category"
                                                placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal2 -->
                    <div class="modal fade" id="updateModalLabel" tabindex="-1" aria-labelledby="updateModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel">Update Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{ route('updatecategory') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="category_edit" class="form-label">Category Name</label>
                                            <input type="text" name="name" class="form-control" id="category_edit"
                                                placeholder="Enter Name" required>
                                            <input name="category_id" type="hidden" id="category_id">

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Actions</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="row1" data-id="{{ $category->id }}">
                                    <td>{{ $category->name }}</td>
                                    <td><a class="btn btn-sm" onclick="editCategory({{ $category->id }})"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="{{ url('category/delete/' . $category->id) }}" class="btn delete btn-sm"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
@section('script')
@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#table").DataTable();
            // this is need to Move Ordera accordin user wish Arrangement
            $("#datatablesSimple").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var order = [];
                var token = $('meta[name="csrf-token"]').attr('content');
                //   by this function User can Update hisOrders or Move to top or under
                $('tr.row1').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });
                // the Ajax Post update
                $.ajax({
                    type: "POST",
                    url: "{{ url('/Custom-sortable') }}",
                    data: {
                        order: order,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                    }
                });
            }
        });
    </script>
    <script>
        function editCategory(id) {
            $.ajax({
                url: "{{ url('category/edit/') }}" + "/" + id,
                success: function(data) {
                    $("#category_edit").val(data.name);
                    $("#category_id").val(data.id);
                    $("#updateModalLabel").modal("show");
                }
            });
        }
    </script>

@endsection
