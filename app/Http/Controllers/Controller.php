<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Foundation\Testing\RefreshDatabase;

// DB
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use RefreshDatabase;

    public function fill()
    {

        DB::table('comment')->truncate();
        DB::table('comment')->insert([
            ['name' => 'Name 0', 'parent_id' => null, 'comment' => 'First comment'],            
            ['name' => 'Name 1', 'parent_id' => null, 'comment' => 'Second'],
            ['name' => 'Name 2', 'parent_id' => 1, 'comment' => 'child from 1'],
            ['name' => 'Name 3', 'parent_id' => 2, 'comment' => 'My parent is 2'],
            ['name' => 'Name 4', 'parent_id' => 3, 'comment' => 'Im a second level from 3'],
            ['name' => 'Name 5', 'parent_id' => null, 'comment' => 'Im root again!'],    
            
            ['name' => 'Name 6', 'parent_id' => 5, 'comment' => 'Third level!'],
            ['name' => 'Name 7', 'parent_id' => 1, 'comment' => 'Seconde with parent is 2'],
            ['name' => 'Name 8', 'parent_id' => 6, 'comment' => 'Im a second level from 3'],
            ['name' => 'Name 9', 'parent_id' => null, 'comment' => 'Im other root again!'] 
        ]);
    }

    public function index()
    {

    /*******
     * 
     * Using LEFT JOIN with fix max levels we need only 1 query
     * but the approach with 3 simple querys expend similar effort and is better to generate json rewponse
     * SELECT
            p0.comment_id as l0_id,
            p0.name as l0_name,
            p0.comment as l0_message,

            p1.comment_id as l1_id,
            p1.name as l1_name,
            p1.comment as l1_message,

            p2.comment_id as l2_id,
            p2.name as l2_name,
            p2.comment as l2_message,
            
            p3.comment_id as l3_id,
            p3.name as l3_name,
            p3.comment as l3_message
            
        FROM        
            comment p0
        LEFT JOIN   
            comment p1 on p1.parent_id = p0.comment_id 
        LEFT JOIN   
            comment p2 on p2.parent_id = p1.comment_id 
        LEFT JOIN   
            comment p3 on p3.parent_id = p2.comment_id 
        WHERE
            p0.parent_id IS NULL;

     */

// I used Hand made SELECT here! in the other classes, uses insert/update from DB::table

        $root = DB::select('SELECT comment_id as id, name, comment as message from comment WHERE parent_id IS NULL;');

        foreach ($root as $i => $r)
        {
            $root[$i] = (array)$r;
            // select level 2
            $level1 = DB::select('SELECT comment_id as id, name, comment as message from comment WHERE parent_id = ?;', [$r->id]);
            if ($level1)
            {                
                foreach ($level1 as $j => $l1)
                {
                    $level1[$j] = (array)$l1;
                    // select level 2
                    $level2 = DB::select('SELECT comment_id as id, name, comment as message from comment WHERE parent_id = ?;', [$l1->id]);
                    if ($level2)
                    {

                        foreach ($level2 as $k => $l2)
                        {
                            $level2[$k] = (array)$l2;
                            // select level 2
                            $level3 = DB::select('SELECT comment_id as id, name, comment as message from comment WHERE parent_id = ?;', [$l2->id]);
                            if ($level3)
                            {           
                                $level3[0]->comments = [];
                                $level2[$k]["comments"] = $level3;
                            }
                            else
                            {
                                $level2[$k]["comments"] = [];
                            }
                        }
                        $level1[$j]["comments"] = $level2;
                    }
                    else
                    {
                        $level1[$j]["comments"] = [];
                    }
                }

                $root[$i]["comments"] = $level1;

            }
            else
            {
                $root[$i]["comments"] = [];
            }

        }

        return response()->json($root, JsonResponse::HTTP_OK);

    }
    public function store(Request $request)
    {

        $r = DB::table('comment')->insert(
        ['name' => $request->name, 'parent_id' => $request->parent_id, 'comment' => $request->comment]);

        if ($r) return response()->json(["route"=>"create a comment"], 200); // 200 OK or 204 no content

        return response()->json(["route"=>"create a comment"], 404);
    }
    public function update(Request $request, $id)
    {
        $r = DB::table('comment')->update(
            ['name' => $request->name, 'parent_id' => $request->parent_id, 'comment' => $request->comment]);

        if ($r) return response()->json(["route"=>"update a comment"], 200);

        return response()->json(["route"=>"update a comment"], 404);
    }
    public function destroy($id)
    {
        $r = DB::delete('DELETE FROM comment WHERE comment_id = ?', [$id]);
        if ($r) return response()->json(["route"=>"delete a comment"], 204);

        return response()->json(["route"=>"delete a comment"], 404);
    }
}
