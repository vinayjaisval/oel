@extends('frontend.layouts.main')
@section('title', 'My Program Shortlists | Overseas Education Lane')
@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <p class="text-muted mb-1">{{ auth()->user()->hasRole('agent') ? 'Agent' : 'Sub-Agent' }}</p>
            <h1 class="h2 mb-0">My Shortlists</h1>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('check-eligible') }}">Add Programs</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('program-shortlists.index') }}" class="row g-2 mb-3">
        <div class="col-sm-8 col-md-5">
            <label class="visually-hidden" for="shortlist-search">Search shortlists</label>
            <input id="shortlist-search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search shortlists">
        </div>
        <div class="col-auto"><button class="btn btn-primary" type="submit">Search</button></div>
        @if(request('search'))
            <div class="col-auto"><a class="btn btn-outline-secondary" href="{{ route('program-shortlists.index') }}">Clear</a></div>
        @endif
    </form>

    @if($shortlists->isEmpty())
        <div class="border rounded p-4 text-center">
            <h2 class="h5">No shortlists yet</h2>
            <p class="text-muted mb-3">Select programs in the finder and save them under a name.</p>
            <a class="btn btn-primary" href="{{ route('check-eligible') }}">Browse Programs</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">Shortlist</th>
                        <th scope="col">Programs</th>
                        <th scope="col">Created</th>
                        <th scope="col">Last updated</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortlists as $shortlist)
                        <tr data-shortlist-row="{{ $shortlist->id }}">
                            <th scope="row">{{ $shortlist->name }}</th>
                            <td>{{ $shortlist->programs_count }}</td>
                            <td>{{ $shortlist->created_at->format('M j, Y') }}</td>
                            <td>{{ $shortlist->updated_at->format('M j, Y') }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a class="btn btn-sm btn-primary" href="{{ route('program-shortlists.show', $shortlist->id) }}">View Details</a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary shortlist-rename" data-url="{{ route('program-shortlists.rename', $shortlist->id) }}">Rename</button>
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('program-shortlists.export', [$shortlist->id, 'pdf']) }}">Download PDF</a>
                                    <a class="btn btn-sm btn-outline-success" href="{{ route('program-shortlists.export', [$shortlist->id, 'xlsx']) }}">Export Excel</a>
                                    <button type="button" class="btn btn-sm btn-outline-danger shortlist-delete" data-url="{{ route('program-shortlists.destroy', $shortlist->id) }}">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $shortlists->links() }}
        <p id="shortlist-list-feedback" class="small" role="status" aria-live="polite"></p>
    @endif
</div>
@endsection
@section('javascript_section')
<script>
    document.querySelectorAll('.shortlist-delete').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!window.confirm('Delete this shortlist and its saved program selections?')) return;
            button.disabled = true;
            fetch(button.dataset.url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(function (response) {
                if (!response.ok) throw new Error('The shortlist could not be deleted.');
                button.closest('tr').remove();
                document.getElementById('shortlist-list-feedback').textContent = 'Shortlist deleted.';
                if (!document.querySelector('[data-shortlist-row]')) window.location.reload();
            }).catch(function (error) {
                button.disabled = false;
                document.getElementById('shortlist-list-feedback').textContent = error.message;
            });
        });
    });
    document.querySelectorAll('.shortlist-rename').forEach(function (button) {
        button.addEventListener('click', function () {
            const row = button.closest('tr');
            const nameCell = row.querySelector('th');
            const nextName = window.prompt('Rename shortlist', nameCell.textContent.trim());
            if (nextName === null || !nextName.trim() || nextName.trim() === nameCell.textContent.trim()) return;
            button.disabled = true;
            fetch(button.dataset.url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ name: nextName.trim() })
            }).then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) throw new Error(data.errors?.name?.[0] || data.message || 'The shortlist could not be renamed.');
                    nameCell.textContent = data.name;
                    document.getElementById('shortlist-list-feedback').textContent = data.message;
                });
            }).catch(function (error) {
                document.getElementById('shortlist-list-feedback').textContent = error.message;
            }).finally(function () {
                button.disabled = false;
            });
        });
    });
</script>
@endsection
