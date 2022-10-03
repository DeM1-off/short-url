<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\ShortLink;
use App\Http\Requests\ShortLinkRequest;
use App\Services\ShortLink\ShortLinkServiceInterface;
use Illuminate\Routing\Redirector;

class ShortLinkController extends Controller
{


    /**
     * @var ShortLinkServiceInterface
     */
    private $shortkService;

    private $timer;
    private $timeNow;


    /**
     * CompanyController constructor.
     * @param ShortLinkServiceInterface $shortkService
     */
    public function __construct(ShortLinkServiceInterface $shortkService)
    {
        $this->shortkService = $shortkService;
        $this->timer = date('Y-m-d G:i:s', strtotime("+15 minutes"));
        $this->timeNow = date('Y-m-d G:i:s', strtotime("now"));

    }

    /**
     * isplay a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $shortLinks = ShortLink::latest()->having('date_del', '>', $this->timeNow)->get();

        return view('welcome', compact('shortLinks'));
    }


    /**
     * Add new link
     *
     * @param ShortLinkRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ShortLinkRequest $request)
    {
        $this->shortkService->addLink($request, $this->timer);

        return redirect('/')
            ->with('success', 'Shorten Link Generated Successfully!');
    }


    /**
     * Makes a substitute link to redirect to the added page.
     *
     * @param $code
     * @return mixed
     */
    public function shortenLink($code)
    {
        return $this->shortkService->showLinkAndAddStats($code, $this->timer);
    }
}
