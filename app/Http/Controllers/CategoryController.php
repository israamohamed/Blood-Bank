<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    
    public function index()
    {
        $records = Category::paginate(20);
        return view('categories.index' , compact('records'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:categories'
        ];

        $messages = [
            'name.required' => 'You should enter the name of the category'
        ];

        $this->validate($request , $rules , $messages);

        Category::create($request->all());

        return redirect(url(route('category.index')))->with('success','Category created successfully!');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $record = Category::findOrFail($id);                    //if fail return 404
        return view('categories.edit' , compact('record'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required', Rule::unique('categories')->ignore($id) ]
        ];

        $messages = [
            'name.required' => 'You should enter the name of the category' 
        ];

        $this->validate($request , $rules , $messages);

        $record = Category::findOrFail($id); 
        $record->update($request->all());
        return redirect(url(route('category.index')))->with('success','Category updated successfully!');
    }

    public function destroy($id)
    {
        $record = Category::findOrFail($id); 
        $record->delete();
        return redirect(url(route('category.index')))->with('error','Category deleted successfully!');

    }
}
