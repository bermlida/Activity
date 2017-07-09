
    @if (!is_null(session('message_type')) && !is_null(session('message_body')))
        <div class="alert alert-{{ session('message_type') }}" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            {{ session('message_body') }}
        </div>
        <!-- /.alert-message -->
    @endif