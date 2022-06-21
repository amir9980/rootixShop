<?php

namespace App\Jobs;

use App\Models\DiscountEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckDiscountEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function retryUntil()
    {
        return now()->addYears(5);
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (DiscountEvent::all() as $event){
            if ($event->start_date<now() && $event->expire_date>now()){
                $event->status = 'Active';
                $event->save();
            }else{
                $event->status = 'Deactive';
                $event->save();
            }
        }

        $this->release(20);
    }

}
