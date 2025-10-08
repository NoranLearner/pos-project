<!-- Delete Confirmation Modal -->
{{-- https://flowbite.com/docs/components/modal/ --}}

<div class="modal" id="deleteAllModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">@lang('site.confirm_delete')</h5>
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-lg w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-dismiss="modal" aria-label="Close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                {{-- <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg> --}}
                <h3 class="mb-5 text-lg font-normal text-gray-500 ">@lang('site.delete_all_warning')</h3>
                {{-- <input type="text" id="delete_select_id" name="delete_select_id" value=''> --}}
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal"
                    class="py-2.5 px-5 ms-3 text-lg font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                    @lang('site.cancel')
                </button>

                {{-- {{ LaravelLocalization::localizeURL(route('dashboard.users.deleteAll')) }} --}}
                <form action="{{ route('dashboard.clients.deleteAll') }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete_select_id" name="delete_select_id" value=''>
                    <button type="submit"
                        class="btn !text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-lg inline-flex items-center px-5 py-2.5 text-center">
                        @lang('site.yes')
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
