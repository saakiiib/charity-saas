@extends('admin.pages.master')
@section('title', 'Gallery')
@section('content')

<div class="container-fluid mb-3">
    <button type="button" class="btn btn-primary" id="newBtn">Add New Item</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0" id="cardTitle">Add New Gallery Item</h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Video URL <small class="text-muted">(optional)</small></label>
                                <input type="text" class="form-control" id="video" name="video" placeholder="https://youtube.com/...">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Image <span class="text-danger">*</span> <small class="text-muted">(used as thumbnail if video)</small></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <img id="previewImage" src="#" alt="" class="img-thumbnail mt-2"
                                    style="max-width:200px; display:none;">
                            </div>

                        </div>
                    </form>
                </div>
                <div class="card-footer text-end">
                    <button type="button" id="addBtn" class="btn btn-primary">Create</button>
                    <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#list" role="tab">Gallery List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#sort" role="tab">Sort Gallery</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="list" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Gallery</h4>
                </div>
                <div class="card-body">
                    <table id="galleryTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Video</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="sort" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sort Gallery</h4>
                    <small class="text-muted">Drag & drop to reorder</small>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach ($galleries as $gallery)
                                <tr data-id="{{ $gallery->id }}">
                                    <td>{{ $gallery->serial }}</td>
                                    <td>{{ $gallery->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#galleryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('gallery.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'video', name: 'video', orderable: false, searchable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $("#sortable").sortable({
        placeholder: "ui-state-highlight",
        cursor: "grab",
        opacity: 0.8,
        update: function () {
            var order = $(this).sortable('toArray', { attribute: 'data-id' });
            $.post("{{ route('gallery.updateOrder') }}", { order: order }, function (res) {
                showSuccess(res.message);
                $("#sortable tr").each(function (i) {
                    $(this).find("td:first").text(i + 1);
                });
                reloadTable('#galleryTable');
            }).fail(() => showError('Failed to update order'));
        }
    });

    $(document).on('change', '.toggle-status', function () {
        var gallery_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.post("{{ route('gallery.toggleStatus') }}", { gallery_id: gallery_id, status: status }, function (res) {
            showSuccess(res.message);
        }).fail(() => showError('Failed to update status'));
    });

    $("#newBtn").click(function () {
        clearForm();
        $("#addThisFormContainer").slideDown(300);
        $("#newBtn").hide();
    });

    $("#FormCloseBtn").click(function () {
        $("#addThisFormContainer").slideUp(300);
        setTimeout(() => $("#newBtn").show(), 300);
    });

    $(document).on('change', '#image', function (event) {
        previewImage(event, '#previewImage');
    });

    $("#addBtn").click(function () {
        var form_data = new FormData();
        form_data.append('title', $('#title').val());
        form_data.append('video', $('#video').val());
        var imageFile = document.getElementById('image');
        if (imageFile.files[0]) form_data.append('image', imageFile.files[0]);

        var isUpdate = $('#codeid').val() ? true : false;
        var url = isUpdate ? "{{ route('gallery.update') }}" : "{{ route('gallery.store') }}";
        if (isUpdate) form_data.append('codeid', $('#codeid').val());

        $.ajax({
            url: url,
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (res) {
                showSuccess(res.message);
                $("#addThisFormContainer").slideUp(300);
                setTimeout(() => $("#newBtn").show(), 300);
                reloadTable('#galleryTable');
                clearForm();
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message ?? 'Something went wrong!');
            }
        });
    });

    $(document).on('click', '.EditBtn', function () {
        var id = $(this).attr('rid');
        $.get("{{ url('admin/galleries') }}/" + id + "/edit", function (res) {
            $('#cardTitle').text('Update Gallery Item');
            $('#codeid').val(res.id);
            $('#title').val(res.title);
            $('#video').val(res.video);
            if (res.image) {
                $('#previewImage').attr('src', '/uploads/galleries/' + res.image).show();
            }
            $('#addBtn').text('Update');
            $('#addThisFormContainer').slideDown(300);
            $('#newBtn').hide();
        });
    });

    function clearForm() {
        $('#createThisForm')[0].reset();
        $('#codeid').val('');
        $('#addBtn').text('Create');
        $('#cardTitle').text('Add New Gallery Item');
        $('#previewImage').attr('src', '#').hide();
    }

});
</script>
@endsection