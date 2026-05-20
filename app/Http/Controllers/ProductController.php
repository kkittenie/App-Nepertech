<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $products = Product::with('category', 'images')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:255',
            'subjudul_atas'      => 'nullable|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'harga_jual'         => 'required|numeric|min:0',
            'harga_sewa_bulanan' => 'nullable|numeric|min:0',
            'harga_sewa_tahunan' => 'nullable|numeric|min:0',
            'link'               => 'nullable|url',
            'description'        => 'required|string',
            'subjudul_bawah'     => 'nullable|string|max:255',
            'deskripsi_bawah'    => 'nullable|string',
            'display_image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'gallery_images'     => 'nullable|array',
            'gallery_images.*'   => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle display image
        if ($request->hasFile('display_image')) {
            $validated['display_image'] = $request->file('display_image')->store('products', 'public');
        }

        // Handle hero image
        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('products/heroes', 'public');
        }

        // Remove gallery_images from validated data before creating product
        unset($validated['gallery_images']);

        $product = Product::create($validated);

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:255',
            'subjudul_atas'      => 'nullable|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'harga_jual'         => 'required|numeric|min:0',
            'harga_sewa_bulanan' => 'nullable|numeric|min:0',
            'harga_sewa_tahunan' => 'nullable|numeric|min:0',
            'link'               => 'nullable|url',
            'description'        => 'required|string',
            'subjudul_bawah'     => 'nullable|string|max:255',
            'deskripsi_bawah'    => 'nullable|string',
            'display_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'gallery_images'     => 'nullable|array',
            'gallery_images.*'   => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle display image
        if ($request->hasFile('display_image')) {
            if ($product->display_image) {
                Storage::disk('public')->delete($product->display_image);
            }
            $validated['display_image'] = $request->file('display_image')->store('products', 'public');
        }

        // Handle hero image
        if ($request->hasFile('hero_image')) {
            if ($product->hero_image) {
                Storage::disk('public')->delete($product->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('products/heroes', 'public');
        }

        // Remove gallery_images from validated data
        unset($validated['gallery_images']);

        $product->update($validated);

        // Handle deleting specific gallery images
        if ($request->has('delete_images')) {
            $deleteIds = $request->input('delete_images', []);
            $imagesToDelete = ProductImage::whereIn('id', $deleteIds)
                ->where('product_id', $product->id)
                ->get();

            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // Handle new gallery images
        if ($request->hasFile('gallery_images')) {
            $maxOrder = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        // Delete display image
        if ($product->display_image) {
            Storage::disk('public')->delete($product->display_image);
        }

        // Delete hero image
        if ($product->hero_image) {
            Storage::disk('public')->delete($product->hero_image);
        }

        // Delete gallery images
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}