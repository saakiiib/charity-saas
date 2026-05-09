@extends('admin.pages.master')
@section('title', 'Services')
@section('content')

<div class="container-fluid mb-3">
    <button type="button" class="btn btn-primary" id="newBtn">Add New Service</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0" id="cardTitle">Add New Service</h4>
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
                                <label class="form-label">Content</label>
                                <textarea class="summernote" id="content" name="content"></textarea>
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
            <a class="nav-link active" data-bs-toggle="tab" href="#list" role="tab">Service List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#sort" role="tab">Sort Services</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="list" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Services</h4>
                </div>
                <div class="card-body">
                    <table id="serviceTable" class="table table-bordered table-striped">
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

        <div class="tab-pane fade" id="sort" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sort Services</h4>
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
                            @foreach ($services as $service)
                                <tr data-id="{{ $service->id }}">
                                    <td>{{ $service->serial }}</td>
                                    <td>{{ $service->title }}</td>
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

    $('#serviceTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('service.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
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
            $.post("{{ route('service.updateOrder') }}", { order: order }, function (res) {
                showSuccess(res.message);
                $("#sortable tr").each(function (i) {
                    $(this).find("td:first").text(i + 1);
                });
                reloadTable('#serviceTable');
            }).fail(() => showError('Failed to update order'));
        }
    });

    $(document).on('change', '.toggle-status', function () {
        var service_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.post("{{ route('service.toggleStatus') }}", { service_id: service_id, status: status }, function (res) {
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
        form_data.append('content', $('#content').summernote('code'));
        var imageFile = document.getElementById('image');
        if (imageFile.files[0]) form_data.append('image', imageFile.files[0]);

        var isUpdate = $('#codeid').val() ? true : false;
        var url = isUpdate ? "{{ route('service.update') }}" : "{{ route('service.store') }}";
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
                reloadTable('#serviceTable');
                clearForm();
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message ?? 'Something went wrong!');
            }
        });
    });

    $(document).on('click', '.EditBtn', function () {
        var id = $(this).attr('rid');
        $.get("{{ url('admin/services') }}/" + id + "/edit", function (res) {
            $('#cardTitle').text('Update Service');
            $('#codeid').val(res.id);
            $('#title').val(res.title);
            $('#short_description').val(res.short_description);
            $('#content').summernote('code', res.content ?? '');
            if (res.image) {
                $('#previewImage').attr('src', '/uploads/services/' + res.image).show();
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
        $('#cardTitle').text('Add New Service');
        $('#previewImage').attr('src', '#').hide();
        $('#content').summernote('code', '');
    }

});
</script>
@endsection