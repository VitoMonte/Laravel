<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\PortfoliosRepository;

class PortfolioController extends SiteController
{

    public function __construct(PortfoliosRepository $p_rep)
    {
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->p_rep = $p_rep;

        $this->template = env('THEME') . '.portfolios ';
        //dd($this->p_rep );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';
        $this->title = 'Портфолио';

        $portfolios = $this->getPortfolios();

        $content = view(env('THEME').'.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);



        return $this->renderOutput();
    }

    public function getPortfolios($take=false, $paginate=true)
     {
        $portfolios = $this->p_rep->get('*', $take, $paginate);

        if ($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
     } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        //
        $portfolio = $this->p_rep->one($alias);

        if ($portfolio) {
            $portfolio->img = json_decode($portfolio->img);
        }



        $portfolios =$this->getPortfolios(config('settings.other_portfolios'), false);

        $this->keywords = ($portfolio->keywords) ? strip_tags($portfolio->keywords) : trim($this->getKeyWords($portfolio->text));
        $this->meta_desc = $portfolio->meta_desc ? strip_tags($portfolio->meta_desc) : str_limit(trim(strip_tags($portfolio->text)), 180);
        $this->title = trim(strip_tags($portfolio->title));

        $content = view(env('THEME') . '.portfolio_content')->with(['portfolio'=> $portfolio, 'portfolios'=> $portfolios])->render();
        $this->vars = array_add($this->vars, 'content', $content);
        

        



        //dd($content);



        

        
        //dd($portfolios);

        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
