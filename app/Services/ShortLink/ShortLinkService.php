<?php

namespace App\Services\ShortLink;

use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkService implements ShortLinkServiceInterface
{

    /**
     * @param $request
     * @param $timer
     * @return bool
     */
    public function addLink($request, $timer)
    {
        $short = new ShortLink();
        $short->code = Str::random(6);
        $short->link = $request->link;
        $short->date_del = $timer;
        $short->save();

        return true;

    }


    /**
     * @param $code
     * @param $timer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showLinkAndAddStats($code, $timer)
    {
        $find = ShortLink::where('code', $code)->first();
        // Checks if a link exists
        if (!$find) {
            return redirect('/')
                ->with('error', 'This link not valid');
        }
        // Checks if a link is out of date

        $this->deleteOldLink($find, $timer);
        // adds a counter
        ShortLink::where('code', '=', $code)
            ->update([
                'stats' => $find->stats + 1,
            ]);

        return redirect($find->link);

    }

    /**
     * @param $timer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteLink($timer)
    {

        $UpdateStats = ShortLink::where('date_del', '>', $timer)->delete();

        return redirect('/')
            ->with('error', 'This link no longer exists.');;
    }

    /**
     * @param $find
     * @param $timer
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function deleteOldLink($find, $timer)
    {
        if ($find->date_del > $timer or $find->stats > 15) {
            return $this->deleteLink($timer);
        }
        return false;
    }


}
