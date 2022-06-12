<?php

namespace App\Http\Controllers;

use App\Models\DiscountToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscountTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'access'=>'nullable|string|in:public,private',
            'percentage'=>'nullable|numeric'
        ]);

        $tokens = DiscountToken::query();

        if ($request->has('access') && !empty($request->access)){
            $tokens->where('access','=',$request->access);
        }

        if ($request->has('percentage') && !empty($request->percentage)){
            $tokens->where('percentage','=',$request->percentage);
        }

        if ($request->has('start_date') && !empty($request->start_date)){
            $tokens->where('start_date','>',\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->start_date) . ' 00:00:00'));
        }

        if ($request->has('expire_date') && !empty($request->expire_date)){
            $tokens->where('expire_date','<',\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->expire_date) . ' 00:00:00'));
        }


        $tokens = $tokens->latest('id')->paginate(15);
        $iteration = ($tokens->currentPage() - 1) * $tokens->perPage();
        return view('admin.discountTokens.index', ['iteration' => $iteration, 'tokens' => $tokens]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.discountTokens.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'access' => 'required|string|in:public,private',
            'user_id' => 'nullable|numeric',
            'percentage' => 'required|numeric|max:100',
            'count' => 'required|numeric',
            'usage_count' => 'required|numeric',
        ]);

        try {
            $tokens = [];

            for ($i = $request->count; $i > 0; $i--) {
                $tokens[] = [
                    'user_id' => $request->user_id,
                    'access' => $request->access,
                    'percentage' => $request->percentage,
                    'usage_count'=>$request->usage_count,
                    'token' => Str::random(10),
                    'start_date' =>  \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->start_date) . ' 00:00:00'),
                    'expire_date' => \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->expire_date) . ' 23:59:59'),
                ];
            }

//            dd($tokens);

            DiscountToken::insert($tokens);
            return redirect()->route('discountToken.index')->with('message','shod');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
