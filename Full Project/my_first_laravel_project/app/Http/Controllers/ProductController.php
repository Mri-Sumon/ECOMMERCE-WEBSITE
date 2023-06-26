<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Category হল মডেল, আর all() দিয়ে মডেল এর মাধ্যমে categories টেবিলের সকল ডাটা চলে আসবে।
        $categories = Category::all();
        //dd($categories);
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
            //dd($request->all());
            // $request->validate([
            //     'name'=>['required'],
            //     'description'=>['required'],
            //     //category_id
            //     'category'=>['required'],
            //     'price'=>['required'],
            //     //এখানে অবশ্যই ইমেজ দিতে হবে।
            //     'image'=>['required','mimes:jpg,png,jpeg', 'min:50', 'max:1000'],
            // ]);

            //Take image Extension
            //request ডাটা আসছে file, ফাইলের ভীতরে আছে image, সেই image এর এক্সটেনশন পাবো getClientOriginalExtension() এর মাধ্যমে।
            //$ext = $request->file('image')->getClientOriginalExtension();
            //সময় এর সাথে image Extension আসবে।
            //$fileName = time().".".$ext;
            //dd($fileName);

            //storeAs()/store(), Upload করা ইমেজটাকে লোকালি কোনো জায়গায় স্টোর করা। $fileName = যে নামে লোকাল ফোল্ডারে যাবে।
            //$request->file('image')->storeAs('public/products'.$fileName);
            
            //Form এর ডাটা Product এর মাধ্যমে ডাটা বেসে চলে যাবে।
        try{
            Product::create([
                'name'=>$request->name,
                'category_id'=>$request->category,
                'description'=>$request->description,
                'price'=>$request->price,
                //$fileName = যে নামে লোকাল ডাটাবেসে যাবে আর image এর রিকুয়েষ্ট ডাটা উপরে রিসিভ করেছি।
                //$request->file('image'), রিকুয়েষ্ট হতে একটা file পাবো, file এর ভীতর একটা image পাবো এবং সেটা uploadImage() ফাংশন কে দিবো।
                'image'=>$this->uploadImage(request()->file('image'))
            ]);
            return redirect()->route('products.list')->withMessage("Product Successfully Created!");
        }catch(\Throwable $th){
            Log::error($th->getMessage());
            return redirect()->back()->withInput()->withErrors("Something worng please contact with web developer");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //dd($product);
        return view('backend.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //edit পেজে Category গুলোকে দেখানোর জন্য, Category মডেল এর মাধ্যমে ক্যাটাগরি টেবিল থেকে ডাটা নিয়ে আসছি।
        $categories = Category::all();
        return view('backend.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //dd('calling');
        //validation
        // $request->validate([
        //     'name'=>['required'],
        //     'description'=>['required'],
        //     //category_id
        //     'category'=>['required'],
        //     'price'=>['required'],
        //     //এখানে নতুন ইমেজ আপলোড না করেই ডাটা আপলোড করা যাবে।
        //     'image'=>['mimes:jpg,png,jpeg', 'min:50', 'max:1000'],
        // ]);
        
        try{
                $requestData = [
                'name'=>$request->name,
                'category_id'=>$request->category,
                'description'=>$request->description,
                'price'=>$request->price,
                ];
                            
                //যদি request এর ভীতরে image ফাইল থাকে, তাহলে বডি এক্সেস হবে।
                if ($request->hasFile('image')){
                    $requestData['image'] = $this->uploadImage(request()->file('image'));
                }
                
                //UPDATE এ ক্লিক করার পর, $requestData তে যা যা আসবে তা নিচের $product বা PRODUCT ID ধরে, ডাটাবেস কে update() ফাংশন দারা আপডেট করে দিবে।
                $product->update($requestData);

                return redirect()->route('products.list')->withMessage("Product Successfully Updated!");
                
        }catch(\Throwable $th){
            Log::error($th->getMessage());
            return redirect()->back()->withInput()->withErrors("Something worng please contact with web developer");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // try{
            $product->delete();
            return redirect()->route('products.list')->withMessage("Products Successfully Deleted!");
        // } catch(\Throwable $th){
        //     Log::error($th->getMessage());
        //     return redirect()->back()->withInput()->withErrors('Some thing went worng contuct with developer');
        // }
    }

    //uploadImage() ফাংশন থেকে পাঠানো ইমেজ এখানে রিসিভ করবো $file এর মাধ্যমে।
    public function uploadImage($file){ 
        //এক্সটেনশন সহকারে Image file এর নাম দেয়া। এখানে time()হল ফাইলের নতুন নাম, $file আগত ইমেজ ফাইল এবং getClientOriginalExtension() সেই ফাইলের এক্সটেনশন।
        $fileName = time().'.'.$file->getClientOriginalExtension();
        //resize() ইমেজকে resize করার জন্য, save() হল আপলোডেড ইমেজটা লোকালি কোথায় সেভ করতে চাই তা, storage_path() দিয়ে সরাসরি storage এ চলে যাবে, /app/public/products/ দিয়ে storage এর ভীতরে app এ যাবে, 
        Image::make($file)->resize(300, 200)->save(storage_path().'/app/public/products/'.$fileName);
        //$fileName টা ima এ যাবে। 
        return $fileName;
    }

    public function trash(){
        //dd('Calling');
        //Product = model, onlyTrashed()->get() = শুধুমাত্র trash এর Data গুলো দেখাবে।
        $trashData = Product::onlyTrashed()->get();
        //dd($trashData);
        return view('backend.product.trast', compact('trashData'));
    }

    public function restore($id){

        //Product=model, onlyTrashed() = শুধুমাত্র Trash এর ডাটা, findOrFail($id) = Fail বা Delete করা ডাটা গুলোর id খুজে বের করবে।
        $restore = Product::onlyTrashed()->findOrFail($id);
        //$restore() ফাংশনটি ডাটা রি-স্টোর করার কাজে ব্যবহার করা হয়।
        $restore->restore();
        return redirect()->route('products.trashed')->withMessage('Product Successfully Restore!');
    }

    public function delete($id)
    {
        try{
            $delete = Product::onlyTrashed()->findOrFail($id);
            $delete->forceDelete();
            return redirect()->route('products.trashed')->withMessage("Product Successfully Permanently deleted!");
        }catch(\Throwable $th){
            Log::error($th->getMessage());
            return redirect()->back()->withInput()->withErrors("Something worng please contact with web developer");
        }
    }
}
