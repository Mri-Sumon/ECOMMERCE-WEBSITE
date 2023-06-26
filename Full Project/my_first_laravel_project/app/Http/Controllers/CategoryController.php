<?php

namespace App\Http\Controllers;

use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(){
        
        //যদি request এর মধ্যে keyword নামের কোনো ডাটা থাকে তাহলে সার্সিং এর কাজ করবে।
        if (request('keyword')){
            // dd(request('keyword'));
            // 'title', 'LIKE'.'%'.request('keyword') = যদি  request হিসাবে keyword এর কোনো ডাটা আসে, তাহলে তা title এর যার সাথে মিলে যাবে তাকে দেখাবে।
            $categories = Category::latest()->where('title', 'LIKE', '%'.request('keyword').'%')->paginate(10);
            //dd($categories);
        }else{
            $categories = Category::latest()->paginate(10);
        }
        
        //CALL Category MODEL AND ASSIGN IN VARIABLE, Category::all() ডাটাবেস টেবিল হতে সকল ডাটা তুলে এনে $categories এ রাখবে।
        // $categories = Category::latest()->get();
        
        //paginate(10) প্রতিটি পেজে 10টি করে ডাটা আসবে।

        //dd($categories);
            //$categories ভ্যারিয়েবলে কী ডাটা আসছে তা দেখার জন্য dd($categories) এই কমান্ডটি চালাতে হবে।
            //এখানে dd অর্থ Dump and Die.
            //dd($categories);
        //$categories এ ডাটাবেস থেকে যে ডাটাগুলি আসছে সেগুলি Array আকারে index পেজে পাঠাবো।
        return view('backend.category.index', ['categories'=>$categories]);
    }

    public function create(){

        //create পেজ এ এক্সেস অনুমতি আছে  কীনা সেটি চেক করবে।
        $this->authorize('create-category');
        return view('backend.category.create');
    }

    //এখানে Request একটি Helper Class, Request $request ব্যবহার করা হয়েছে try এর ভীতরের $request এর জন্য।
    public function store(CategoryRequest $request){
        
        //সঠিকেোড গুলো সব try এর ভীতর রাখতে হবে।
        try{
            //যে request ডাটাগুলি আসবে, সেগুলি ভ্যালিডেট হবে।
            // $request->validate([
            //     //required=অবশ্যই টেক্সট ফিল্ড দিতে হবে, min:5 মিনিমাম 5 ক্যারেক্টার হবে, 'unique' একি নাম দুইবার এন্ট্রি নিবেনা।
            //     'title' => ['required', 'min:5', 'max:25', Rule::unique ('categories', 'title')],
            //     'description' => 'required | min:5 | max:100',
            // ]);
            
            //CHECK IS DATA GOING TO store FILE OR NOT
            //dd('Calling');

            //Category মডেল ও create() ফাংশনের মাধ্যমে ডাটা, ডাটাবেসে চলে যাবে।
            Category::create([
                'title'=>$request->title,   //title টেক্সফিল্ড হতে আসা, ডাটা requestটি create() ফাংশনের মাধ্যমে Category মডেল এর সাহায্য ডাটাবেস এ চলে যাবে।
                'description'=>$request->description,
                //'image'=>$request->image,
            ]);

            //ডাটাবেসে ডাটা store হওয়ার পর আবার list পেজে চলে যাবে, এবং Successfull ম্যাসেজ দেখাবে, এখানে message এর ভীতর "Category Successfully Created!" এ্যাসাইন হবে, এবং message, session এ স্টোর হবে। 
            return redirect()->route('categories.list')->withMessage("Category Successfully Created!");
        } catch(\Throwable $th){
            Log::error($th->getMessage());  //এখন যা কিছু এ্যারর আসবে তা Log ফাইলে স্টোর হবে (Storage>>logs>>laravel.log)
            // try এর ভীতর যে সকল কোড আছে, সেগুলিতে যদি কোনো ভূল হয়, তাহলে getMessage() ফাংশন তা রিসিভ করবে এবং dd() ফাংশন সেই এ্যারর দেখাবে।
            //dd($th->getMessage());
            //এ্যারর পাওয়ার পর তা কোন পেজে দেখাবে তা redirect করে দিতে পারবো, আর back() দিয়ে যে পেজ এ ছিলাম সেই পেজে withInput() ইনপুট ফিল্ডের টেক্সট ও withErrors() এ্যারর ম্যাসেজটা ব্যাক করাবে এবং $th->getMessage() এর দারা এ্যারর ম্যাসেজটা দেখাবে।
            //return redirect()->back()->withInput()->withErrors($th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    //Category, Model এ Category ফাইলের ক্লাস, $category আসছে routes>>web.php থেকে।
    public function show(Category $category){

        //index.blade.php থেকে প্রাপ্ত id’র সাথে database এর যে id match করবে, সেই id’র সকল ডাটা ‘Category’ Model এর মাধ্যমে database হতে নিয়ে আসবে। তারপর সেটি $category ভ্যারিয়েবলে রেখে দিবে।
        //$category = Category::find($id);
        //এখন দেখবো ডাটাবেস হতে আইডি আসতেছে কীনা
        //dd($category);

        return view('backend.category.show',['key'=>$category]);
    }

    public function edit(Category $category){
        return view ('backend.category.edit', compact('category'));
    }


    // Store Function এর কোড গুলো কপি করে update function এ নিয়ে আসবো। নিয়ে আসার পর প্রয়োজনীয় পরিবর্তন করবো।
    //Category = Model,  $category = index.blade.php হতে আগত id. Category মডেল এর কাজ হল, আমরা এখানে যে id’র ডাটা update করবো সেই update data সেই id তে ডাটাবেসে পাঠায় দিবে।
    public  function update(CategoryRequest $request, Category $category){
        try{
            // $request->validate([
            //     // ignore($category->id)] টাইটেল ঠিক রেখে Description update করতে পারবো।
            //     'title' => ['required', 'min:5', 'max:25', Rule::unique ('categories', 'title')->ignore($category->id)],
            //     'description' => 'required | min:5 | max:100',
            // ]);
            
            //এখানে update ফাংশন থেকে যে ডাটা insert করবো, তা index.blade.php থেকে যে id($category) পেয়েছি সেই আইডির আন্ডারে ডাটাবেসে চলে যাবে।
            $category->update([
                'title'=>$request->title,
                'description'=>$request->description,
            ]);

            return redirect()->route('categories.list')->withMessage("Category Successfully Updated!");
        } catch(\Throwable $th){
            Log::error($th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function destroy(Category $category){
        try{
            //index.blade.php ফাইল থেকে আগত id'র ডাটা ডিলিট হয়ে যাবে।
            $category->delete();
            return redirect()->route('categories.list')->withMessage("Category Successfully Deleted!");
        } catch(\Throwable $th){
            Log::error($th->getMessage());
            return redirect()->back()->withInput()->withErrors('Some thing went worng contuct with developer');
        }
    }

    //FOR PDF FILE
    public function categoryPdf(){
        
        //CATEGORIES TABLE এর সবগুলি ডাটা নিয়ে আসবো।
        $categories = Category::all();
        //pdf ফাইল গুলো যে নামে দেখাবে তা নির্ধারন করবো।
        $fileName = 'categories.pdf';
        //render() এর মাধ্যমে view('backend.category.pdf') রুটটি String এ convert হয়ে $html ভ্যরিয়েবলে এ্যাসাইন হবে।
        $html = view('backend.category.pdf', compact('categories'))->render();
        $mpdf = new \Mpdf\Mpdf();
        //$html যে pdf ফাইলটি থাকবে সেটি WriteHTML() এ দেখাবে।
        $mpdf->WriteHTML($html);
        //fileName = আউটপুট এ পিডিএফ ফাইলের যে নাম আসবে তা, I = বাটনে ক্লিক করলে পিডিএফ ফাইলটি দেখাবে। I এর জায়গায় D লিখলে পিডিএফ বাটনে ক্লিক করলে পিডিএফ ফাইল ডাউনলোড হয়ে যাবে।
        $mpdf->Output($fileName, '');
    }

    //FOR EXCEL FILE
    public function export() 
    {
        //এখানে CategoriesExport আসছে আমরা যে CategoriesExport ক্লাস ক্রিয়েট করেছি সেখান থেকে, categories.xlsx = Download করা ফাইলের নাম হবে categories.xlsx।
        return Excel::download(new CategoriesExport, 'categories.xlsx');
    }
}