<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Traits\UploadTrait;

class ClientController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware('permission:clients_read', ['only' => ['index']]);
        $this->middleware('permission:clients_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:clients_update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:clients_delete', ['only' => ['destroy', 'restore', 'forceDelete', 'deleteAll']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::withTrashed()->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%')
                    ->orWhere('phones', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(8);
        return view('dashboard.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|min:2|max:30',
            'phones' => 'required|array|min:1',
            'phones.*' => 'string|max:20',
            'address' => 'required|string|min:2|max:50',
        ]);

        $validatedData['phones'] = array_filter($validatedData['phones']);

        $newClient = Client::create($validatedData);

        if ($request->hasFile('image')) {
            $this->verifyAndStoreImage($request, 'image', 'clients', 'upload_image', $newClient->id, Client::class);
        }

        Alert::toast(__('site.added_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|min:2|max:30',
            'phones' => 'nullable|array|min:1',
            'phones.*' => 'nullable|string|max:20',
            'address' => 'nullable|string|min:2|max:50',
        ]);

        $validatedData['phones'] = array_filter($validatedData['phones']);

        $client->update($validatedData);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($client->image) {
                $old_image = $client->image->file;
                $this->Delete_attachment('upload_image', 'clients/' . $old_image, $client->id);
            }
            // Store new image
            $this->verifyAndStoreImage($request, 'image', 'clients', 'upload_image', $client->id, Client::class);
        }

        Alert::toast(__('site.updated_successfully'), 'success')->timerProgressBar();

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        Alert::toast(__('site.change_status_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.clients.index');
    }

    public function restore($id)
    {
        $client = Client::withTrashed()->findOrFail($id);
        $client->restore();

        Alert::toast(__('site.change_status_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.clients.index');
    }

    public function forceDelete($id)
    {

        $client = Client::withTrashed()->findOrFail($id);

        if ($client->image && $client->image->file) {
            $old_image = $client->image->file;
            $this->Delete_attachment('upload_image', 'clients/' . $old_image, $client->id);
        }

        $client->forceDelete();

        Alert::toast(__('site.delete_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.clients.index');
    }

    public function deleteAll(Request $request)
    {

        // dd($request->delete_select_id);

        $ids = explode(",", $request->delete_select_id);

        foreach ($ids as $category_id) {

            $client = Client::findOrFail($category_id);

            if ($client->image && $client->image->file) {
                $old_image = $client->image->file;
                $this->Delete_attachment('upload_image', 'clients/' . $old_image, $client->id);
            }

            $client->forceDelete();
        }

        Alert::toast(__('site.delete_successfully'), 'warning')->timerProgressBar();
        return redirect()->route('dashboard.clients.index');

    }
}
