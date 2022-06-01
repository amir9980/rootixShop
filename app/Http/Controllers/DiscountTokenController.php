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
    public function index()
    {
        $tokens = DiscountToken::orderBy('id', 'DESC')->paginate(15);
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
        ]);

        try {
            $tokens = [];

            for ($i = $request->count; $i > 0; $i--) {
                $tokens[] = [
                    'user_id' => $request->user_id,
                    'access' => $request->access,
                    'percentage' => $request->percentage,
                    'token' => Str::random(10),
                    'start_date' =>  \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->start_date) . ' 00:00:00'),
                    'expire_date' => \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->expire_date) . ' 00:00:00'),
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
