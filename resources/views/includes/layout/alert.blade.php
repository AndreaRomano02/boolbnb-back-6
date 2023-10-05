@if (session('message'))
    <div class="alert">

        <div class="container mt-5">
            <div class="alert alert-{{ session('type') ? session('type') : 'info' }} alert-dismissible fade show"
                role="alert">
                <p>{{ session('message') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
