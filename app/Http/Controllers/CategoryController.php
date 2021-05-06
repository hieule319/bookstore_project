<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::getListCategory();
        return view('admin.category.index')->with(compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $query = category::insertOrUpdateCategory($params);
        if ($query == 'success') {
            return back()->with('success', 'Thêm danh mục thành công');
        } else if ($query == 'existscategory'){
            return back()->with('fail', 'Đã tồn tại danh mục');
        }else{
            return back()->with('fail', 'Đã xảy ra sự cố');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCategoryById($id)
    {
        $category = category::find($id);
        return response()->json($category);
    }

    public function updateCategory(Request $request)
    {
        $param['category_name'] = $request->category_name_edit;
        $query = category::insertOrUpdateCategory($param,$request->id);

        if ($query == 'success') {
            return back()->with('success', 'Chỉnh sửa danh mục thành công');
        } else if ($query == 'existscategory'){
            return back()->with('fail', 'Đã tồn tại danh mục');
        }else{
            return back()->with('fail', 'Đã xảy ra sự cố');
        }
    }

    public function deleteCategory($id)
    {
        $category = category::find($id);
        if(isset($category))
        {
            $query = category::deleteCategory($id);
            if ($query == 'success') {
                return back()->with('success', 'Xóa danh mục thành công');
            }else{
                return back()->with('fail', 'Đã xảy ra sự cố');
            }
        }
    }

    public function updateStatusCategory($id,$status)
    {
        $param['status'] = $status;
        $query = category::insertOrUpdateCategory($param,$id);

        if ($query == 'success') {
            return back();
        } 
    }
}
