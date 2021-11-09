<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use App\Http\Requests\ShortLinkRequest;
use App\Services\ShortLink\ShortLinkServiceInterface;

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
        $this->timer         = date('Y-m-d G:i:s',strtotime("+15 minutes"));
        $this->timeNow       = date('Y-m-d G:i:s',strtotime("now"));

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $shortLinks = ShortLink::latest()->having('date_del', '>', $this->timeNow)->get();
   
        return view('welcome', compact('shortLinks'));
    }
     
    /**
     * Add new link
     *
     * @return success link
     */
    public function store(ShortLinkRequest $request)
    {
        $linkAdd = $this->shortkService->addLink($request,$this->timer);

        return redirect('/')
             ->with('success', 'Shorten Link Generated Successfully!');
    }
   
    /**
     * Makes a substitute link to redirect to the added page.
     *
     * @return redirect link 
     */
    public function shortenLink($code)
    {
      
         $checkLink = $this->shortkService->showLinkAndAddStats($code,$this->timer);

        return  $checkLink;
    }
}
