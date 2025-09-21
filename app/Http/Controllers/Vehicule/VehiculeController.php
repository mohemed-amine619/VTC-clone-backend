<?php

namespace App\Http\Controllers\Vehicule;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VehiculeController extends Controller
{
    //
    public function getVehicule(Request $request)
    {
        $data = Vehicule::paginate(10);
        return response($data, 200);
    }

    // 
    public function addImage(Request $request)
    {
        $fields = $request->all();
        $errors = Validator::make($fields, [
            'id' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);
        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all(),
            ], 422);
        }
        if ($request->hasFile('image')) {
            $PreviousImage = Vehicule::where('id', $fields['id'])->first('image');
            $image = $request->file('image');
            $input['file'] = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')
                ->put('/images/' . $input['file'], file_get_contents($image));

            $image = File::delete(public_path(str_replace(url('/'), '', $PreviousImage->image)));
            $imageUrl = url('/') . '/storage/images/' . $input['file'];

            Vehicule::where('id', $fields['id'])->update([
                'image' => $imageUrl
            ]);

            return response([
                'message' => 'vehicule image updloaded successfully'
            ], 200);
        }
    }

    //
    public function store(Request $request)
    {
        $fields = $request->all();
        $errors = Validator::make($fields, [
            'name' => 'required',
            'model' => 'required',
            'price' => 'required'
        ]);
        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all()
            ], 422);
        }
        Vehicule::create([
            'name' => $fields['name'],
            'model' => $fields['model'],
            'price' => $fields['price'],
        ]);
        return response([
            'message' => 'vehicule created with success',
        ]);
    }

    //
    public function update(Request $request)
    {
        $fields = $request->all();
        $errors = Validator::make($fields, [
            'id' => 'required',
            'name' => 'required',
            'model' => 'required',
            'price' => 'required'
        ]);
        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all()
            ], 422);
        }
        Vehicule::where('id', $fields['id'])->update([
            'name' => $fields['name'],
            'model' => $fields['model'],
            'price' => $fields['price'],
        ]);
        return response([
            'message' => 'vehicule Updated with success',
        ], 200);
    }

    //
    public function destroy(Request $request)
    {
        $fields = $request->all();
        $errors = Validator::make($fields, [
            'id' => 'required',
        ]);
        if ($errors->fails()) {
            return response([
                'errors' => $errors->errors()->all()
            ], 422);
        }
        Vehicule::where('id', $fields['id'])->delete();
        return response([
            'message' => 'vehicule deleted with success',
        ], 200);
    }
}
