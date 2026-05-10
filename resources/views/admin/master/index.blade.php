@extends('admin.pages.master')
@section('title', 'Master')
@section('content')

<div class="container-fluid mb-3">
    <button class="btn btn-primary" id="newBtn">Add New</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0" id="cardTitle">Add New</h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">

                        {{-- Basic Info --}}
                        <h6 class="text-muted fw-semibold mb-3">Basic Info</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Page <span class="text-danger">*</span>
                                    <small class="text-muted">(e.g. home, about, contact)</small>
                                </label>
                                <input type="text" class="form-control" id="page" name="page">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span>
                                    <small class="text-muted">(e.g. hero, about, team)</small>
                                </label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Short Title</label>
                                <input type="text" class="form-control" id="short_title" name="short_title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Long Title</label>
                                <input type="text" class="form-control" id="long_title" name="long_title">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Short Description</label>
                                <textarea class="summernote" id="short_description" name="short_description"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Long Description</label>
                                <textarea class="summernote" id="long_description" name="long_description"></textarea>
                            </div>
                        </div>

                        {{-- Images --}}
                        <h6 class="text-muted fw-semibold mb-3">Images</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Image 1</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <img id="previewImage" src="#" class="img-thumbnail mt-2" style="max-width:200px; display:none;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Image 2</label>
                                <input type="file" class="form-control" id="image2" name="image2" accept="image/*">
                                <img id="previewImage2" src="#" class="img-thumbnail mt-2" style="max-width:200px; display:none;">
                            </div>
                        </div>

                        {{-- Dynamic Content (JSON) --}}
                        <h6 class="text-muted fw-semibold mb-2">Extra Content
                            <small class="text-muted fw-normal">(key/value pairs)</small>
                        </h6>
                        <div id="contentRows" class="mb-3"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addContentRow">
                            <i class="ri-add-line"></i> Add Row
                        </button>

                        {{-- SEO --}}
                        <h6 class="text-muted fw-semibold mb-3">SEO</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Meta Image</label>
                                <input type="file" class="form-control" id="meta_image" name="meta_image" accept="image/*">
                                <img id="previewMetaImage" src="#" class="img-thumbnail mt-2" style="max-width:200px; display:none;">
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
            <h4 class="card-title mb-0">All Masters</h4>
        </div>
        <div class="card-body">
            <table id="masterTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Page</th>
                        <th>Name</th>
                        <th>Short Title</th>
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

    // DataTable
    const table = $('#masterTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'page', name: 'page' },
            { data: 'name', name: 'name' },
            { data: 'short_title', name: 'short_title' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Image previews
    $(document).on('change', '#image',      function(e){ previewImage(e, '#previewImage'); });
    $(document).on('change', '#image2',     function(e){ previewImage(e, '#previewImage2'); });
    $(document).on('change', '#meta_image', function(e){ previewImage(e, '#previewMetaImage'); });

    // Add content row
    $('#addContentRow').click(function () {
        addContentRow();
    });

    function addContentRow(key = '', shortDesc = '', longDesc = '') {
        var index = $('#contentRows .content-row').length;
        var html = `
            <div class="card border mb-3 content-row">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <label class="form-label">Key <small class="text-muted">(e.g. feature_1, stat_title)</small></label>
                            <input type="text" class="form-control" name="content_key[]" value="${key}" placeholder="key">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Short Description</label>
                            <textarea class="form-control" name="content_short_desc[]" rows="2" placeholder="short description">${shortDesc}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Long Description</label>
                            <textarea class="form-control" name="content_long_desc[]" rows="3" placeholder="long description">${longDesc}</textarea>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-outline-danger removeContentRow">
                            <i class="ri-delete-bin-line"></i> Remove
                        </button>
                    </div>
                </div>
            </div>`;
        $('#contentRows').append(html);
    }

    $(document).on('click', '.removeContentRow', function () {
        $(this).closest('.content-row').remove();
    });

    // Show form
    $('#newBtn').click(function () {
        clearForm();
        $('#addThisFormContainer').slideDown(300);
        $('#newBtn').hide();
    });

    $('#FormCloseBtn').click(function () {
        $('#addThisFormContainer').slideUp(300);
        setTimeout(() => $('#newBtn').show(), 300);
    });

    // Save
    $('#addBtn').click(function () {
        var form_data = new FormData();
        form_data.append('codeid',           $('#codeid').val());
        form_data.append('page',             $('#page').val());
        form_data.append('name',             $('#name').val());
        form_data.append('short_title',      $('#short_title').val());
        form_data.append('long_title',       $('#long_title').val());
        form_data.append('short_description', $('#short_description').summernote('code'));
        form_data.append('long_description', $('#long_description').summernote('code'));
        form_data.append('meta_title',       $('#meta_title').val());
        form_data.append('meta_keywords',    $('#meta_keywords').val());
        form_data.append('meta_description', $('#meta_description').val());

        // Images
        if ($('#image')[0].files[0])      form_data.append('image',      $('#image')[0].files[0]);
        if ($('#image2')[0].files[0])     form_data.append('image2',     $('#image2')[0].files[0]);
        if ($('#meta_image')[0].files[0]) form_data.append('meta_image', $('#meta_image')[0].files[0]);

        // Content rows - FIXED
        var hasContent = false;
        $('input[name="content_key[]"]').each(function (i) {
            var key = $(this).val();
            var shortDesc = $($('textarea[name="content_short_desc[]"]')[i]).val();
            var longDesc = $($('textarea[name="content_long_desc[]"]')[i]).val();
            
            form_data.append('content_key[]', key);
            form_data.append('content_short_desc[]', shortDesc);
            form_data.append('content_long_desc[]', longDesc);
            
            if (key) hasContent = true;
        });
        
        // Add a flag to indicate if we should process content
        form_data.append('has_content_field', '1');

        var isUpdate = $('#codeid').val() ? true : false;
        var url = isUpdate ? "{{ route('master.update') }}" : "{{ route('master.store') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (res) {
                showSuccess(res.message);
                $('#addThisFormContainer').slideUp(300);
                setTimeout(() => $('#newBtn').show(), 300);
                table.ajax.reload(null, false);
                clearForm();
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message ?? 'Something went wrong!');
            }
        });
    });

    // Edit
    $(document).on('click', '.EditBtn', function () {
        var id = $(this).data('id');
        $.get("{{ url('admin/master') }}/" + id + "/edit", function (res) {
            $('#cardTitle').text('Update Master');
            $('#codeid').val(res.id);
            $('#page').val(res.page).prop('readonly', true);
            $('#name').val(res.name);
            $('#short_title').val(res.short_title);
            $('#long_title').val(res.long_title);
            $('#short_description').summernote('code', res.short_description ?? '');
            $('#long_description').summernote('code', res.long_description ?? '');
            $('#meta_title').val(res.meta_title);
            $('#meta_keywords').val(res.meta_keywords);
            $('#meta_description').val(res.meta_description);

            if (res.image)      $('#previewImage').attr('src', '/uploads/masters/' + res.image).show();
            if (res.image2)     $('#previewImage2').attr('src', '/uploads/masters/' + res.image2).show();
            if (res.meta_image) $('#previewMetaImage').attr('src', '/uploads/meta_image/' + res.meta_image).show();

            // Load content rows
            $('#contentRows').empty();
            if (res.content && res.content.length) {
                res.content.forEach(function (item) {
                    addContentRow(item.key, item.short_desc, item.long_desc);
                });
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
        $('#cardTitle').text('Add New');
        $('#page').prop('readonly', false);
        $('#short_description').summernote('code', '');
        $('#long_description').summernote('code', '');
        $('#previewImage').attr('src', '#').hide();
        $('#previewImage2').attr('src', '#').hide();
        $('#previewMetaImage').attr('src', '#').hide();
        $('#contentRows').empty();
    }

    // Copy
    $(document).on('click', '.CopyBtn', function () {
        var id = $(this).data('id');
        
        if (confirm('Are you sure you want to copy this record?')) {
            $.ajax({
                url: "{{ url('admin/master') }}/" + id + "/copy",
                type: 'POST',
                success: function (res) {
                    showSuccess(res.message);
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    showError(xhr.responseJSON?.message ?? 'Failed to copy!');
                }
            });
        }
    });

});
</script>
@endsection