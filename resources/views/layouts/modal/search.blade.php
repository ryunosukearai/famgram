<div class="modal fade" id="search-all">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header border-secondary">
                <input type="search" class="form-control" value="@if (isset($search)) {{ $search }} @endif">
                <button class="btn btn-primary">search</button>
            </div>
            <div class="modal-body">
                {{-- Recent <span class="fw-bold">{{ $user->name }}</span> --}}
            </div>
            <div class="modal-footer border-0">
                {{-- {{ $user}} --}}
            </div>
        </div>
    </div>
</div>
