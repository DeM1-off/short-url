<?php

namespace App\Services\ShortLink;

use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkService implements ShortLinkServiceInterface
{

    /**
     * @param url $request
     * @return true
     */
    public function addLink($request,$timer)
    {
        $short = new ShortLink();
        $short->code = Str::random(6);
        $short->link = $request->link;
        $short->date_del = $timer;
        $short->save();

        return true;

    }

    /**
     * @param str $code
     * @return redirect $find->link
     */
    public function showLinkAndAddStats($code,$timer)
    {
        $find = ShortLink::where('code', $code)->first();
            // Checks if a link exists
        if(  $find == Null){
            return redirect('/')
            ->with('error', 'This link not valid');
        }
            // Checks if a link is out of date
        if($find->date_del > $timer OR  $find->stats > 15){
            return $this->deleteLink($timer);
        }
            // adds a counter
        $UpdateStats = ShortLink::where('code', '=',$code)
        ->update([
            'stats' => $find->stats+1,
        ]);

          return redirect($find->link);
    
      }

    /**
     * Removes all old links
     * 
     * @param datetime $timer
     * @return redirect /
     */
    public function deleteLink($timer)
    {
        
    $UpdateStats = ShortLink::where('date_del', '>',$code)->delete();
    
     return redirect('/')
            ->with('error', 'This link no longer exists.');;
    }


}
