<?php

namespace App\Http\Controllers;

use App\Jobs\SendDiscountEventEmail;
use App\Mail\NewDiscountEvent;
use App\Models\DiscountEvent;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DiscountEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dates are in jalali:
        $request['start_date'] = convert($request->start_date);
        $request['expire_date'] = convert($request->expire_date);

        $request->validate([
            'percentage'=>'nullable|numeric',
            'start_date' => 'nullable|regex:/....\/..\/../',
            'expire_date' => 'nullable|regex:/....\/..\/../',
        ]);

        $events = DiscountEvent::query();

        if ($request->has('percentage') && !empty($request->percentage)) {
            $events = $events->where('percentage', '=', $request->percentage);
        }
        if ($request->has('start_date') && !empty($request->start_date)) {
            $events = $events->where('start_date', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $request->start_date . ' 00:00:00'));
        }
        if ($request->has('expire_date') && !empty($request->expire_date)) {
            $events = $events->where('expire_date', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $request->expire_date . ' 23:59:59'));
        }

        $events = $events->orderBy('id','DESC')->paginate(15);
        $iteration = ($events->currentPage() - 1) * $events->perPage();
        return view('admin.discountEvents.index',compact('events','iteration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discountEvents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'=>'required|string|max:250',
            'description'=>'required|string|max:1000',
            'percentage'=>'required|numeric|max:100',
            'start_date'=>'required',
            'expire_date'=>'required',
        ]);

        $request['start_date'] =\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->start_date) . ' 00:00:00');
        $request['expire_date'] =\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->expire_date) . ' 23:59:59');


        //event validation
        if ($request->start_date < now()->addDays(-1) || $request->expire_date < $request->start_date){
            return back()->withInput()->withErrors(['???????? ?????????? ???????????? ?????? ?????????????? ??????!']);
        }
        $events = DiscountEvent::query()->where('status','=','Active')->get();
        foreach ($events as $event){
            if ($event->start_date >= $request->start_date){
                if ($request->expire_date >= $event->start_date){
                    return back()->withInput()->withErrors(['???? ???????? ?????????? ???????????? ?????? ?????????????? ?????????? ???????? ????????!']);
                }
            }elseif($event->expire_date >= $request->start_date){
                return back()->withInput()->withErrors(['???? ???????? ?????????? ???????????? ?????? ?????????????? ?????????? ???????? ????????!']);
            }
        }
        // end of event validation

        $newEvent = DiscountEvent::create($request->all());

        if ($newEvent->start_date <= now()){
            $newEvent->status = 'Active';
            foreach (user::all() as $user) {
                    SendDiscountEventEmail::dispatch($user,$newEvent);
            }
        }else{
            foreach (user::all() as $user) {
                SendDiscountEventEmail::dispatch($user,$newEvent)->delay($newEvent->start_date);
            }
        }
        $newEvent->save();
        return redirect(route('discountEvent.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiscountEvent  $discountEvent
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountEvent $discountEvent)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiscountEvent  $discountEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountEvent $discountEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiscountEvent  $discountEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscountEvent $discountEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiscountEvent  $discountEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountEvent $discountEvent)
    {
        $discountEvent->status = 'Deactive';
        $discountEvent->save();
        return redirect(route('discountEvent.index'));
    }
}
