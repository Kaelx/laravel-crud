<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $products =[
        //     ['id' => 12202025, 'name' => 'Apple', 'price' => 100, 'stock' => 50],
        //     ['id' => 12212025, 'name' => 'Banana', 'price' => 150, 'stock' => 30],
        //     ['id' => 12222025, 'name' => 'Cherry', 'price' => 200, 'stock' => 20],
        // ];

        // return view('products.index',['products'=>$products]);

        // $products = Product::all();
        // $products = Product::Paginate(10);

        $query = Product::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort products
        $sortBy = $request->get('sort_by', 'created_at'); // Default: newest first
        $sortOrder = $request->get('sort_order', 'desc'); // desc or asc
        $query->orderBy($sortBy, $sortOrder);

        // $products = $query->paginate(10);

        // Paginate and keep query parameters
        $products = $query->simplePaginate(10)->appends($request->query());

        // return view('products.index',['products'=>$products]);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $name = $request->input('name');
        // $price = $request->input('price');
        // $stock = $request->input('stock');

        // Product::create([
        //     'name' => $name,
        //     'price' => $price,
        //     'stock' => $stock
        // ]);


        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['user_id'] = Auth::id();

        Product::create($validated);
        return redirect('/products')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $products =[
        //     ['id' => 12202025, 'name' => 'Apple', 'price' => 100, 'stock' => 50],
        //     ['id' => 12212025, 'name' => 'Banana', 'price' => 150, 'stock' => 30],
        //     ['id' => 12222025, 'name' => 'Cherry', 'price' => 200, 'stock' => 20],
        // ];

        // $product = collect($products)->firstwhere('id',$id);
        // return view('products.info',['product'=>$product]);

        $product = Product::findorfail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // if ($product->user_id !== Auth::id()) {
        //     abort(403, 'You are not authorized!');
        // }
        $product = Product::findorfail($id);
        $category = Category::all();
        return view('products.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findorfail($id);

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }
        $product->update($validated);

        return redirect('/products')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // if ($product->user_id !== Auth::id()) {
        //     abort(403, 'You are not authorized!');
        // }

        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $product = Product::findorfail($id);

        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect('/products')->with('success', 'Product deleted successfully!');
    }
}
