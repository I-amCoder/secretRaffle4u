<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\RaffleCategory;
use App\Models\ScratchCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class RaffleCategoryController extends Controller
{

    public function getCategoryList(Request $request){
        $category = RaffleCategory::where('status',1)->orderBy('id','asc')->get();
        $pageTitle = 'Raffle Draw Category';
        $emptyMessage = 'Category not found';
        return view('admin.raffle.category.index', compact('pageTitle','category','emptyMessage'));
    }

    public function getCategoryEdit($id)
    {
        $category = RaffleCategory::findOrFail($id);
        $pageTitle = 'Update Raffle Category : ' . $category->name;
        return view('admin.raffle.category.edit', compact('pageTitle', 'category'));
    }

    public function categoryUpdate(Request $request,$id){
    	$request->validate([
    		'title'=>'required',
    		'name'=>'required',
    	]);
    	$category = RaffleCategory::find($id);

    	$photo = $category->photo;
    	if ($request->hasFile('photo')) {
            $path = imagePath()['category']['path'];
            $size = imagePath()['category']['size'];
            $old = $category->photo;
    		try {
                if (File::exists($path.$category->photo)) {
                    File::delete($path.$category->photo);
                }
    			$photo = uploadImage($request->photo,$path,$size,$old);

         		} catch (\Exception $e) {
    			$notify[] = ['error','Image Could Not be uploaded'];
    			return back()->withNotify($notify);
    		}
    	}


    	$category->update([
    		'name'=>$request->name,
    		'title'=>$request->title,
    		'home_title'=>$request->home_title,
    		'is_show_on_home_page'=> $request->is_show_on_home_page ? 1 : 0,
    		'photo'=>$photo,
    		'status'=>$request->status ? 1 : 0,
    	]);
    	$notify[] = ['success','Raffle Category Updated Successfully'];


        return redirect()->route('admin.raffle.category')->withNotify($notify);
    }

	public function getscratchCategoryList(Request $request){
        $category = ScratchCategory::where('status',1)->orderBy('id','asc')->get();
        $pageTitle = 'SCRATCH Card Category';
        $emptyMessage = 'Category not found';
        return view('admin.scratch.category.index', compact('pageTitle','category','emptyMessage'));
    }

    public function getscratchCategoryEdit($id)
    {
        $category = ScratchCategory::findOrFail($id);
        $pageTitle = 'Update SCRATCH Card Category : ' . $category->name;
        return view('admin.scratch.category.edit', compact('pageTitle', 'category'));
    }

    public function scratchcategoryUpdate(Request $request,$id){
    	$request->validate([
    		'title'=>'required',
    		'name'=>'required',
    	]);
    	$category = ScratchCategory::find($id);

    	$photo = $category->photo;
    	if ($request->hasFile('photo')) {
            $path = imagePath()['category']['path'];
            $size = imagePath()['category']['size'];
            $old = $category->photo;
    		try {
                if (File::exists($path.$category->photo)) {
                    File::delete($path.$category->photo);
                }
    			$photo = uploadImage($request->photo,$path,$size,$old);

         		} catch (\Exception $e) {
    			$notify[] = ['error','Image Could Not be uploaded'];
    			return back()->withNotify($notify);
    		}
    	}


    	$category->update([
    		'name'=>$request->name,
    		'title'=>$request->title,
    		'home_title'=>$request->home_title,
    		'is_show_on_home_page'=> $request->is_show_on_home_page ? 1 : 0,
    		'photo'=>$photo,
    		'status'=>$request->status ? 1 : 0,
    	]);
    	$notify[] = ['success','SCRATCH Card Category Updated Successfully'];


        return redirect()->route('admin.scratch.category')->withNotify($notify);
    }

}