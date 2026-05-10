@extends('admin.pages.master')
@section('title', 'Charities')
@section('content')

<div class="container-fluid" id="newBtnSection">
    <div class="row mb-3">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" id="newBtn">
                Add New Charity
            </button>
        </div>
    </div>
</div>

<div class="container-fluid" id="addThisFormContainer">
    <div class="row justify-content-center">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1" id="cardTitle">Add New Charity</h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Charity Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Domain <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="domain" name="domain" placeholder="e.g. helpcharity.com">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" id="addBtn" class="btn btn-primary" value="Create">Create</button>
                    <button type="button" id="FormCloseBtn" class="btn btn-light">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" id="contentContainer">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">All Charities</h4>
        </div>
        <div class="card-body">
            <table id="tenantTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Domain</th>
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
    $("#addThisFormContainer").hide();

    $('#tenantTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('tenant.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'domain_link', orderable: false, searchable: false },
            { data: 'status', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).on('change', '.toggle-status', function () {
        var tenant_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.ajax({
            url: "{{ route('tenant.status') }}",
            method: 'POST',
            data: { tenant_id, status, _token: "{{ csrf_token() }}" },
            success: function (d) { reloadTable('#tenantTable'); showSuccess(d.message); },
            error: function () { showError('Failed to update status'); }
        });
    });

    $(document).on('click', '.cloneBtn', function () {
        if (!confirm('Clone this tenant and all its data?')) return;
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/tenants/' + id + '/clone',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function (res) {
                showSuccess(res.message);
                reloadTable('#tenantTable');
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message ?? 'Failed to clone tenant.');
            }
        });
    });

    $("#newBtn").click(function () {
        clearform();
        $("#newBtn").hide(100);
        $("#addThisFormContainer").show(300);
    });

    $("#FormCloseBtn").click(function () {
        $("#addThisFormContainer").hide(200);
        $("#newBtn").show(100);
        clearform();
    });

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var url   = "{{ route('tenant.store') }}";
    var upurl = "{{ route('tenant.update') }}";

    $("#addBtn").click(function () {
        var form_data = new FormData();
        form_data.append('name',   $("#name").val());
        form_data.append('domain', $("#domain").val());

        var isCreate = $(this).val() == 'Create';
        if (!isCreate) form_data.append('codeid', $("#codeid").val());

        $.ajax({
            url: isCreate ? url : upurl,
            method: 'POST',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (d) {
                showSuccess(d.message);
                $("#addThisFormContainer").slideUp(300);
                setTimeout(() => $("#newBtn").show(200), 300);
                reloadTable('#tenantTable');
                clearform();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let firstError = Object.values(xhr.responseJSON.errors)[0][0];
                    showError(firstError);
                } else {
                    showError(xhr.responseJSON?.message ?? 'Something went wrong!');
                }
            }
        });
    });

    $("#contentContainer").on('click', '#EditBtn', function () {
        var id = $(this).attr('rid');
        $.get(url + '/' + id + '/edit', {}, function (d) {
            $("#cardTitle").text('Update Charity');
            $("#name").val(d.name);
            $("#domain").val(d.domain);
            $("#codeid").val(d.id);
            $("#addBtn").val('Update').html('Update');
            $("#addThisFormContainer").show(300);
            $("#newBtn").hide(100);
            pagetop();
        });
    });

    function clearform() {
        $('#createThisForm')[0].reset();
        $("#addBtn").val('Create').html('Create');
        $("#cardTitle").text('Add New Charity');
        $("#codeid").val('');
    }
});
</script>
@endsection