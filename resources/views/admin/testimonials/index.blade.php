@extends('admin.pages.master')
@section('title', 'Testimonials')
@section('content')

<div class="container-fluid mb-3">
    <button type="button" class="btn btn-primary" id="newBtn">Add New Testimonial</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0" id="cardTitle">Add New Testimonial</h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Company</label>
                                <input type="text" class="form-control" id="company" name="company">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <img id="previewImage" src="#" alt="" class="img-thumbnail rounded-circle mt-2"
                                    style="max-width:100px; display:none;">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="4"></textarea>
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
            <h4 class="card-title mb-0">Testimonials</h4>
        </div>
        <div class="card-body">
            <table id="testimonialTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Company</th>
                        <th>Photo</th>
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

    $('#testimonialTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('testimonial.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'designation', name: 'designation' },
            { data: 'company', name: 'company' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).on('change', '.toggle-status', function () {
        var testimonial_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.post("{{ route('testimonial.toggleStatus') }}", { testimonial_id: testimonial_id, status: status }, function (res) {
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
        form_data.append('name', $('#name').val());
        form_data.append('designation', $('#designation').val());
        form_data.append('company', $('#company').val());
        form_data.append('message', $('#message').val());
        var imageFile = document.getElementById('image');
        if (imageFile.files[0]) form_data.append('image', imageFile.files[0]);

        var isUpdate = $('#codeid').val() ? true : false;
        var url = isUpdate ? "{{ route('testimonial.update') }}" : "{{ route('testimonial.store') }}";
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
                reloadTable('#testimonialTable');
                clearForm();
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message ?? 'Something went wrong!');
            }
        });
    });

    $(document).on('click', '.EditBtn', function () {
        var id = $(this).attr('rid');
        $.get("{{ url('admin/testimonials') }}/" + id + "/edit", function (res) {
            $('#cardTitle').text('Update Testimonial');
            $('#codeid').val(res.id);
            $('#name').val(res.name);
            $('#designation').val(res.designation);
            $('#company').val(res.company);
            $('#message').val(res.message);
            if (res.image) {
                $('#previewImage').attr('src', '/uploads/testimonials/' + res.image).show();
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
        $('#cardTitle').text('Add New Testimonial');
        $('#previewImage').attr('src', '#').hide();
    }

});
</script>
@endsection