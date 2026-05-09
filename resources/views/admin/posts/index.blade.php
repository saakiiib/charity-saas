@extends('admin.pages.master')
@section('title', 'Posts')
@section('content')

<div class="container-fluid mb-3">
    <button type="button" class="btn btn-primary" id="newBtn">Add New Post</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0" id="cardTitle">Add New Post</h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">
                        <div class="row g-3">

                            <div class="col-md-8">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <img id="previewImage" src="#" alt="" class="img-thumbnail mt-2"
                                    style="max-width:200px; display:none;">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Short Description</label>
                                <textarea class="form-control" id="short_description" name="short_description" rows="3"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Long Description</label>
                                <textarea class="summernote" id="long_description" name="long_description"></textarea>
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
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Posts</h4>
        </div>
        <div class="card-body">
            <table id="postTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#postTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('post.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).on('change', '.toggle-status', function () {
        var post_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.post("{{ route('post.toggleStatus') }}", { post_id: post_id, status: status }, function (res) {
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
        form_data.append('short_description', $('#short_description').val());
        form_data.append('long_description', $('#long_description').summernote('code'));
        var imageFile = document.getElementById('image');
        if (imageFile.files[0]) form_data.append('image', imageFile.files[0]);

        var isUpdate = $('#codeid').val() ? true : false;
        var url = isUpdate ? "{{ route('post.update') }}" : "{{ route('post.store') }}";
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
                reloadTable('#postTable');
                clearForm();
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message ?? 'Something went wrong!');
            }
        });
    });

    $(document).on('click', '.EditBtn', function () {
        var id = $(this).attr('rid');
        $.get("{{ url('admin/posts') }}/" + id + "/edit", function (res) {
            $('#cardTitle').text('Update Post');
            $('#codeid').val(res.id);
            $('#title').val(res.title);
            $('#short_description').val(res.short_description);
            $('#long_description').summernote('code', res.long_description ?? '');
            if (res.image) {
                $('#previewImage').attr('src', '/uploads/posts/' + res.image).show();
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
        $('#cardTitle').text('Add New Post');
        $('#previewImage').attr('src', '#').hide();
        $('#long_description').summernote('code', '');
    }

});
</script>
@endsection