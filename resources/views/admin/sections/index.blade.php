@extends('admin.pages.master')
@section('title', 'Section List')
@section('content')

<div class="container-fluid">
    @foreach($sections as $page => $pageSections)
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1 text-capitalize">{{ $page }} Page</h5>
            <small class="text-muted">Drag & drop to reorder</small>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Section</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="sortable" data-page="{{ $page }}">
                    @foreach($pageSections as $section)
                    <tr data-id="{{ $section->id }}">
                        <td>{{ $section->sl }}</td>
                        <td class="text-capitalize">{{ str_replace('_', ' ', $section->name) }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input toggle-status"
                                    id="switch{{ $section->id }}" data-id="{{ $section->id }}"
                                    {{ $section->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="switch{{ $section->id }}"></label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function () {
    $('.sortable').sortable({
        placeholder: 'ui-state-highlight',
        cursor: 'grab',
        opacity: 0.8,
        update: function () {
            var order = $(this).sortable('toArray', { attribute: 'data-id' });
            $.post("{{ route('sections.updateOrder') }}", {
                _token: '{{ csrf_token() }}',
                order: order
            }, function (res) {
                showSuccess(res.message);
                $('.sortable').each(function () {
                    $(this).find('tr').each(function (i) {
                        $(this).find('td:first').text(i + 1);
                    });
                });
            });
        }
    });

    $(document).on('change', '.toggle-status', function () {
        var id   = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        $.post("{{ route('sections.toggleStatus') }}", {
            _token: '{{ csrf_token() }}',
            id: id,
            status: status
        }, function (res) { showSuccess(res.message); });
    });
});
</script>
@endsection