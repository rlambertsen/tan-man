<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\VideoImage;
use Illuminate\Support\Facades\DB;
use Exception;

class SearchController extends Controller {

    public function search(Request $request) {


        if ($request->search == trim($request->search) && strpos($request->search, ' ') !== false) {
            $results = VideoImage::whereRaw('MATCH(text) AGAINST(? IN BOOLEAN MODE) > 12', [$request->search])->get();
        } else {
            $lists = VideoImage::where('text', 'like', '%' . $request->search . '%')
                //->limit(75)
                ->get()
                //->chunk(5)
                ->groupBy('number')
                ->toArray();
            $results = [];
            forEach($lists as $list){
                array_push($results, current($list));
            }
        }

        return response()->json($results);
    }

}
