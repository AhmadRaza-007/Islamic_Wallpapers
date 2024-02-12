@extends('app')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-center">
                <h1 class="mt-4">Surah's</h1>
                {{-- <p class="mt-4">Count: {{ $verse_count }}</p> --}}
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Surah's</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Surah's
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            class="btn btn-dark">Add Surah</button>
                    </div>
                    @error('*')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Surah</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form method="post" action="{{ route('storesurah') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category Name</label>
                                            <select class="form-select" name="book_id" id="book_id"
                                                aria-label="Default select example" required>
                                                <option disabled selected>Select Parent Category</option>
                                                {{-- @foreach ($categories as $category) --}}
                                                <option value="{{ $book->id }}">{{ $book->name }}</option>
                                                {{-- @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Surah Number</label>
                                            <input type="text" name="surah_number" class="form-control" id="surah_number"
                                                placeholder="Enter Number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Surah Name</label>
                                            <input type="text" name="surah" class="form-control" id="surah"
                                                placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <div class="add_field">
                                            <button type="button" class="btn btn-success" onclick="addField()">Add</button>
                                        </div>
                                        <div class="buttons">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
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
                                <form method="post" action="{{ route('updatesurah') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="surah_hidden" class="form-control" id="surah_hidden"
                                            placeholder="Enter Number" required>
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category Name</label>
                                            <select class="form-select" name="book_id" id="edit_book_id"
                                                aria-label="Default select example" required>
                                                <option disabled selected>Select Parent Category</option>
                                                {{-- @foreach ($categories as $category) --}}
                                                <option value="{{ $book->id }}">{{ $book->name }}</option>
                                                {{-- @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Surah Number</label>
                                            <input type="text" name="surah_number" class="form-control"
                                                id="edit_surah_number" placeholder="Enter Number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Surah Name</label>
                                            <input type="text" name="surah" class="form-control" id="edit_surah"
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
                    <!-- Modal3 Push Notification -->
                    <div class="modal fade" id="NotifyModel" tabindex="-1" aria-labelledby="NotifyModel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="NotifyModel">Surah Notifications </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{ route('send.web-notification') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="wallpaper_category" class="form-label">Category Name</label>
                                            <select class="form-select" name="category_id" id="wallpaper_category"
                                                aria-label="Default select example" required>
                                                <option>Select Parent Category</option>
                                                {{-- @foreach ($book as $category) --}}
                                                <option value="{{ $book->id }}">{{ $book->name }}</option>
                                                {{-- @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="notify_title_edit" class="form-label">Title </label>
                                            <input type="text" name="title" class="form-control"
                                                id="notify_title_edit" placeholder="Enter Title">
                                            <input name="wallpaper_id" type="hidden" id="notify_wallpaper_id">
                                        </div>
                                        <div class="mb-3">
                                            <label for="notify_wallpaper_image_url" class="form-label">Surah Image
                                                Url</label>
                                            <input type="text" name="wallpaper_image_url" class="form-control"
                                                id="notify_wallpaper_image_url" placeholder="Enter Surah imageurl">
                                        </div>
                                        <div class="mb-3">
                                            <label for="wallpaper_image" class="form-label">Surah Image</label>
                                            <input class="form-control" name="wallpaper_image" type="file"
                                                id="wallpaper_edit">
                                            <img src="" id="NotifywallpaperImage_edit" height="100"
                                                width="100">
                                        </div>
                                        <hr>
                                        <h5 class="text-center">Tooltips in a modal</h5>
                                        <div class="mb-3">
                                            <label for="notify_title" class="form-label">Notification Title </label>
                                            <input type="text" name="notify_title" class="form-control"
                                                id="notify_title" placeholder="Enter Notification Title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="notify_body" class="form-label">Notification Body </label>
                                            <textarea type="text" name="body" class="form-control" id="notify_body" placeholder="Enter Notification Body"
                                                required></textarea>
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

                                <th>No.</th>
                                <th>Surah No.</th>
                                <th>Surah</th>
                                <th>Actions</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($book->surah as $key => $surah)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $surah->surah_number }}</td>
                                    <td style="font-size: 1.5rem;">{{ $surah->surah }}</td>
                                    <td>
                                        <a class="btn btn-sm" onclick="editCategory({{ $surah->id }})">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a onclick="notify({{ $surah->id }})" class="btn btn-sm">
                                            <i class="fas fa-bell"></i>
                                        </a>
                                        <a href="{{ url('surah/delete/' . $surah->id) }}" class="btn delete btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <a href="{{ url('verse/' . $surah->id . '/1') }}" class="btn delete btn-sm">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
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
    <script script>
        var quranCategories = @json($book);
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $("#wallpaper_edit").on('change', function(e) {
            $("#wallpaperImage_edit").attr("src", URL.createObjectURL(e.target.files[0]));
        })

        function editCategory(id) {
            $.ajax({
                url: "{{ url('surah/edit/') }}" + "/" + id,
                success: function(data) {
                    console.log(data)
                    $("#edit_book_id").val(data.book_id);
                    $("#edit_surah_number").val(data.surah_number)
                    $("#edit_surah").val(data.surah);
                    $("#surah_hidden").val(data.id);
                    $("#updateModalLabel").modal("show");
                }
            })
        }

        function notify(id) {
            $.ajax({
                url: "{{ url('NotifyDetail/edit') }}" + "/" + id,
                success: function(data) {
                    console.log(data)
                    $("#notify_wallpaper_id").val(data.id);
                    $("#wallpaper_category").val(data.category_id)
                    $("#notify_title_edit").val(data.title);
                    $("#notify_wallpaper_image_url").val(data.wallpaper_image_url);
                    $("#NotifywallpaperImage_edit").attr("src", data.wallpaper_image);
                    $("#NotifyModel").modal("show");
                }
            })
        }
    </script>
@endsection
