<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreateItemResource;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $item = Item::select('id', 'name', 'price', 'image')->get();
        return response(['data' => $item]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'price' => 'required|integer',
            'image_file' => 'nullable|mimes:png,jpg'
        ]);

        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '_' . $fileName;
            Storage::disk('public')->putFileAs('items', $file, $newName);
            // return $newName;
            $request['image'] = $newName;
        }
        $item = Item::create($request->all());
        return new CreateItemResource($item);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'price' => 'required|integer',
            'image_file' => 'nullable|mimes:png,jpg'
        ]);

        $item = Item::findOrFail($id);

        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '_' . $fileName;

            // menghapus gambar lama jika ada
            if ($item->image) {
                Storage::disk('public')->delete('items/' . $item->image);
            }

            // menyimpan gambar baru
            Storage::disk('public')->putFileAs('items', $file, $newName);

            $request['image'] = $newName;
        }

        $item->update($request->all());

        return new CreateItemResource($item);
    }
}
