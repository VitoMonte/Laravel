<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Repositories\MenusRepository;

use Menu;

class SiteController extends Controller
{
    protected $keywords;
    protected $meta_desc;
    protected $title;
    //  Хранение объекта класса портфолио репозиторий (Хранение логики по работе с портфолио)
    protected $p_rep;
    //  Хранение объекта класса слайдер репозиторий (Хранение логики по работе со слайдером)
    protected $s_rep;
    //  Хранение объекта класса articles репозиторий (Хранение логики по работе со статьями блога)
    protected $a_rep;
    //  Хранение объекта класса menus репозиторий (Хранение логики по работе с пунктами меню)
    protected $m_rep;

    //Хранение имени шаблона для отображения информации на конкретной странице
    protected $template;

    //Массив передаваемых в шаблон переменных
    protected $vars=[];

    //Значения сайдбара
    protected $bar = 'no';
    protected $contentRightBar = false;
    protected $contentLeftBar = false;

    public function __construct(MenusRepository $m_rep)
    {
    	$this->m_rep = $m_rep;
    }

   	protected function renderOutput()
   	{

        $menu = $this->getMenu();

        $navigation = view(env('THEME'). '.navigation')->with('menu',$menu)->render();
        $footer = view(env('THEME'). '.footer')->render();

        if ($this->contentRightBar) {
            $rightBar = view(env('THEME').'.rightBar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars = array_add($this->vars, 'rightBar', $rightBar);
        }

        $this->vars = array_add($this->vars, 'bar', $this->bar);
        $this->vars = array_add($this->vars, 'navigation', $navigation);
        $this->vars = array_add($this->vars, 'ketwords', $this->keywords);
        $this->vars = array_add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars, 'title', $this->title);        
        $this->vars = array_add($this->vars, 'footer', $footer);


   		return view($this->template)->with($this->vars);
   	}

    protected function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu){
            foreach ($menu as $item) {
                if($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });

        //dd($mBuilder);


        return $mBuilder;
    }


    
}
