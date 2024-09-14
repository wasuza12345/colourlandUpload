<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class FlowerController extends Controller
{
    public function index()
    {
        $show_product = DB::table("products")->get();
        return view('content.products.product', compact('show_product'));
    }
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'unit' => 'required|string',
                'profile_pic' => 'required|image',
                'detail' => 'required|string',
            ]);

            // Initialize $filePath to store the path of the uploaded file
            $filePath = null;

            // Handling file upload
            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/flowers', $filename, 'public');
                Log::info('File uploaded successfully', ['filename' => $filename]);
            }

            // Inserting data into the database
            DB::table('products')->insert([
                'image' => $filePath, // This will be null if no file was uploaded
                'name' => $request->input('name'),
                'type' => $request->input('unit'), // Assuming 'unit' corresponds to 'type' in your database
                'description' => $request->input('detail'),
                'price' => $request->input('price'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Data saved to database', ['name' => $request->input('name')]);

            return back()->with('success', 'Flower added successfully!');
        } catch (\Exception $e) {
            // Log error information
            Log::error('Error adding new flower', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to add new flower');
        }
    }
    public function delete($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect('productAdmin')->with('success');
    }
}