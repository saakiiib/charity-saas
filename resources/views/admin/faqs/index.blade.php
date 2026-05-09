@extends('admin.pages.master')
@section('title', 'FAQs')
@section('content')

<div class="container-fluid mb-3">
    <button type="button" class="btn btn-primary" id="newBtn">Add New FAQ</button>
</div>

<div class="container-fluid" id="addThisFormContainer" style="display:none;">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0" id="cardTitle">Add New FAQ</h4>
                </div>
                <div class="card-body">
                    <form id="createThisForm">
                        @csrf
                        <input type="hidden" id="codeid" name="codeid">
                        <div class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label">Question <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="question" name="question">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Answer <span class="text-danger">*</span></label>
                                <textarea class="summernote" id="answer" name="answer"></textarea>
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
            <a class="nav-link active" data-bs-toggle="tab" href="#list" role="tab">FAQ List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#sort" role="tab">Sort FAQs</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="list" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">FAQs</h4>
                </div>
                <div class="card-body">
                    <table id="faqTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Question</th>
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
                    <h4 class="card-title mb-0">Sort FAQs</h4>
                    <small class="text-muted">Drag & drop to reorder</small>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Question</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach ($faqs as $faq)
                                <tr data-id="{{ $faq->id }}">
                                    <td>{{ $faq->serial }}</td>
                                    <td>{{ $faq->question }}</td>
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

    $('#faqTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('faq.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'question', name: 'question' },
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
            $.post("{{ route('faq.updateOrder') }}", { order: order }, function (res) {
                showSuccess(res.message);
                $("#sortable tr").each(function (i) {
                    $(this).find("td:first").text(i + 1);
                });
                reloadTable('#faqTable');
            }).fail(() => showError('Failed to update order'));
        }
    });

    $(document).on('change', '.toggle-status', function () {
        var faq_id = $(this).data('id');
        var status = $(this).prop('checked') ? 1 : 0;
        $.post("{{ route('faq.toggleStatus') }}", { faq_id: faq_id, status: status }, function (res) {
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

    $("#addBtn").click(function () {
        var isUpdate = $('#codeid').val() ? true : false;
        var url = isUpdate ? "{{ route('faq.update') }}" : "{{ route('faq.store') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                codeid:   $('#codeid').val(),
                question: $('#question').val(),
                answer:   $('#answer').summernote('code'),
            },
            success: function (res) {
                showSuccess(res.message);
                $("#addThisFormContainer").slideUp(300);
                setTimeout(() => $("#newBtn").show(), 300);
                reloadTable('#faqTable');
                clearForm();
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message ?? 'Something went wrong!');
            }
        });
    });

    $(document).on('click', '.EditBtn', function () {
        var id = $(this).attr('rid');
        $.get("{{ url('admin/faqs') }}/" + id + "/edit", function (res) {
            $('#cardTitle').text('Update FAQ');
            $('#codeid').val(res.id);
            $('#question').val(res.question);
            $('#answer').summernote('code', res.answer ?? '');
            $('#addBtn').text('Update');
            $('#addThisFormContainer').slideDown(300);
            $('#newBtn').hide();
        });
    });

    function clearForm() {
        $('#createThisForm')[0].reset();
        $('#codeid').val('');
        $('#addBtn').text('Create');
        $('#cardTitle').text('Add New FAQ');
        $('#answer').summernote('code', '');
    }

});
</script>
@endsection