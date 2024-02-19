@extends('app')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-center">
                <h1 class="mt-4">Verse's</h1>
                <p class="mt-4">Count: {{ $verses->count() }}</p>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Verse's</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Verse's
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Select Language
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($languages as $item)
                                    <li>
                                        <a class="dropdown-item" href="{{ url('') . '/verse/' . $id . '/' . $item->id }}">
                                            {{ $item->language }}
                                        </a>
                                    </li>
                                @endforeach
                                {{-- @for ($index = 0; $index < count($languages); $index++)
                                    <li>
                                        <a class="dropdown-item" href="{{ url('') . '/verse/' . $id . '/' . $languages[$index]->id }}">
                                            {{ $languages[$index] }}
                                        </a>
                                    </li>
                                @endfor --}}
                            </ul>
                        </div>

                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-dark"
                            style="height: fit-content;padding: 0.7rem .5rem;">Add
                            Verse</button>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Add Verse</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form method="post" action="{{ route('storeverse') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body" id="modal_body_create">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Surah Name</label>
                                            <select class="form-select" name="surah_id" id="surah_id"
                                                aria-label="Default select example" required>
                                                <option disabled selected>Select Parent Category</option>
                                                @foreach ($surah as $item)
                                                    <option value="{{ $item->id }}">{{ $item->surah }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Surah Name</label>
                                            <select class="form-select" name="language_id[]" id="language_id"
                                                aria-label="Default select example" required>
                                                <option disabled selected>Select Parent Category</option>
                                                {{-- <option selected value="0">Arabic</option> --}}
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}">{{ $language->language }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Verse Number</label>
                                            <input type="text" name="verse_number" class="form-control" id="Verse_number"
                                                placeholder="Enter Number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Verse</label>
                                            <input type="text" name="verse[]" class="form-control" id="Verse"
                                                placeholder="Enter Verse" required>
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
                                    <h5 class="modal-title" id="updateModalLabel">Update Verse</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('updateverse') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="verse_hidden" class="form-control" id="verse_hidden"
                                            placeholder="Enter Number" required>
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Verse Name</label>
                                            <select class="form-select" name="surah_id" id="edit_surah_id"
                                                aria-label="Default select example" required disabled>
                                                <option disabled>Select Surah</option>
                                                @foreach ($surah as $item)
                                                    <option value="{{ $item->id }}" selected>{{ $item->surah }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="category_id" class="form-label">Language</label>
                                            <select class="form-select" name="language_id" id="surah_id"
                                                aria-label="Default select example" required>
                                                <option disabled selected>Select Language</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}">{{ $language->language }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <input type="hidden" name="language_id" value="" id="language_id_hidden">
                                        <input type="hidden" name="surah_id" value="" id="surah_id_hidden">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Verse Number</label>
                                            <input type="text" name="verse_number" class="form-control"
                                                id="edit_verse_number" placeholder="Enter Number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Verse</label>
                                            <input type="text" name="verse" class="form-control" id="edit_verse"
                                                placeholder="Enter Verse" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Audio Start Time</label>
                                            <input type="text" name="startTime" class="form-control" id="startTime"
                                                placeholder="Enter Verse" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Audio End Time</label>
                                            <input type="text" name="endTime" class="form-control" id="endTime"
                                                placeholder="Enter Verse" required>
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
                                    <h5 class="modal-title" id="NotifyModel">Verse Notifications </h5>
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
                                                {{-- <option value="{{ $book->id }}">{{ $book->name }}</option> --}}
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
                                            <label for="notify_wallpaper_image_url" class="form-label">Verse Image
                                                Url</label>
                                            <input type="text" name="wallpaper_image_url" class="form-control"
                                                id="notify_wallpaper_image_url" placeholder="Enter Verse imageurl">
                                        </div>
                                        <div class="mb-3">
                                            <label for="wallpaper_image" class="form-label">Verse Image</label>
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
                                <th>Verse No.</th>
                                <th>Verse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($verses as $key => $verse)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $verse->verse->verse_number }}</td>
                                    <td>
                                        <audio id="audio{{ $key }}"
                                            src="{{ asset('assets/fullQuran/' . $verse->verse->audio) }}" controls
                                            oncanplay="playAudioWithTime({{ $key }}, {{ $verses[$key]->verse->startTime }}, {{ $verses[$key]->verse->endTime }})">
                                        </audio>
                                    </td>
                                    <td style="font-size: 1.5rem;">
                                        {{ $verse->verse->verse }}
                                        <br>
                                        <span style="font-size: 1rem;">
                                            {{ $verse->verse->translate }}
                                        </span>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm" onclick="editCategory({{ $verse->id }})">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a onclick="notify({{ $verse->verse->id }})" class="btn btn-sm">
                                            <i class="fas fa-bell"></i>
                                        </a>
                                        <a href="{{ url('verse/delete/' . $verse->verse->id) }}"
                                            class="btn delete btn-sm">
                                            <i class="fas fa-trash-alt"></i>
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
        var languages = @json($languages);

        function playAudioWithTime(index, startTime, endTime) {
            var audio = document.getElementById('audio' + index);
            if (audio) {
                // Set the currentTime to the startTime
                audio.currentTime = startTime;

                // When the audio reaches the endTime, pause it
                audio.addEventListener("timeupdate", function() {
                    if (audio.currentTime >= endTime) {
                        audio.pause();
                        startNextAudio(index)
                    }
                });
            }
        }



        function pauseAllAudio() {
            var audios = document.querySelectorAll('audio');
            audios.forEach(function(audio) {
                audio.pause();
            });
        }

        function startNextAudio(nextIndex) {
            var nextAudio = document.getElementById('audio' + (nextIndex + 1));
            if (nextAudio) {
                nextAudio.play();
            }
        }





        // When the audio ends, pause it
        // audio.addEventListener("timeupdate", function() {
        //     if (audio.currentTime >= endTime) {
        //         audio.pause();
        //     }
        // });
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $("#wallpaper_edit").on('change', function(e) {
            $("#wallpaperImage_edit").attr("src", URL.createObjectURL(e.target.files[0]));
        })

        function editCategory(id) {
            console.log(id);
            $.ajax({
                url: "{{ url('verse/edit/') }}" + "/" + id,
                success: function(data) {
                    console.log(data)
                    $("#edit_surah_id").val(data.surah_id);
                    $("#surah_id_hidden").val(data.surah_id);
                    $("#edit_verse_number").val(data.verse_number)
                    $("#edit_verse").val(data.verse);
                    $("#verse_hidden").val(data.id);
                    $("#language_id_hidden").val(data.language_id);
                    $("#startTime").val(data.startTime);
                    $("#endTime").val(data.endTime);
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
