<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">@lang('site.confirm_delete')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>@lang('site.delete_warning') <strong>{{ $user->name }}</strong></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn bg-gray-300" data-dismiss="modal">@lang('site.cancel')</button>

                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        @lang('site.yes')
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
