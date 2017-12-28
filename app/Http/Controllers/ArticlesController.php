<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\PortfoliosRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CommentsRepository;
use Corp\Category;

class ArticlesController extends SiteController
{


    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep)
    {
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;
        $this->c_rep = $c_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
        //dd($this->p_rep );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cat_alias=false)
    {


        $articles = $this->getArticles($cat_alias);
        $comments =$this->getComments(config('settings.recent_comments'));
        $portfolios =$this->getPortfolios(config('settings.recent_portfolios'));

        $content = view(env('THEME').'.articles_content')->with('articles', $articles)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $this->contentRightBar = view(env('THEME').'.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();

        $this->keywords = 'Публикации';
        $this->meta_desc = 'Публикации';
        $this->title = 'Блог';
        return $this->renderOutput();
    }

    public function getComments($take = false) 
    {
        $comments = $this->c_rep->get(['text','name','email','site','article_id','user_id'], $take);

        if ($comments) {
            $comments->load('article','user');
        }

        return $comments;
    }


    public function getPortfolios($take = false) 
    {
        $portfolios = $this->p_rep->get(['title','text','alias','customer','img','filter_alias'], $take);

        return $portfolios;
    }


    public function getArticles($alias = false) 
    {
        $where = false;

        if ($alias) {
            //WHERE `alias` = $alias
            $id = Category::select('id')->where('alias',$alias)->first()->id;
            //WHERE `category_id` = $id
            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get(['id','title','alias','created_at','img','desc','user_id','category_id', 'keywords', 'meta_desc'],false,true,$where );

        if ($articles) {
            $articles->load('user','category','comments');
        }

        return $articles;
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
    public function show($alias=false)
    {
        //
        $article = $this->a_rep->one($alias, ['comments'=>true]);

        if ($article) {
            $article->img = json_decode($article->img);
        }

        //dd($article);

        $content = view(env('THEME') . '.article_content')->with('article', $article)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $comments =$this->getComments(config('settings.recent_comments'));
        $portfolios =$this->getPortfolios(config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME').'.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();

        $this->keywords = ($article->keywords) ? strip_tags($article->keywords) : $this->getKeyWords($article->text);
        $this->meta_desc = $article->meta_desc ? strip_tags($article->meta_desc) : strip_tags($article->desc);
        $this->title = strip_tags($article->title);

        //dd($article->keywords);

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
