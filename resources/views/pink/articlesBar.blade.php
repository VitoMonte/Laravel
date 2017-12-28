<!-- START SIDEBAR -->





    
    <div class="widget-first widget recent-posts">
        <h3>{{ Lang::get('ru.latest_projects') }}</h3>
        <div class="recent-post group">
			@if(!$portfolios->isEmpty())				
				@foreach($portfolios as $portfolio)
				<div class="hentry-post group">
                	<div class="thumb-img">
                		<img src="{{  asset(env('THEME')) }}/images/projects/{{ $portfolio->img->mini }}" alt="{{ $portfolio->title }}" title="{{ $portfolio->title }}" />
                	</div>
	                <div class="text">
	                    <a href="{{ route('portfolios.show', ['alias' =>$portfolio->alias]) }}" title="Section shortcodes &amp; sticky posts!" class="title">{{ $portfolio->title }}</a>
	                    <p>{!! str_limit($portfolio->text, 110) !!}</p>
	                    <a class="read-more" href="{{ route('portfolios.show', ['alias' =>$portfolio->alias]) }}">&rarr; {{ Lang::get('ru.read_more') }}</a>
	                </div>
            	</div>
				@endforeach
			@endif

        </div>
    </div>
    

    
    <div class="widget-last widget recent-comments">
        <h3>{{ Lang::get('ru.recent_comments') }}</h3>
        <div class="recent-post recent-comments group">
        @if(!$comments->isEmpty())                
            @foreach($comments as $comment)
            <div class="the-post group">
                <div class="avatar">
                @set($hash, isset($comment->user->email) ? md5($comment->user->email) : md5($comment->email))       
                    <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=55 " class="avatar" />   
                </div>
                <span class="author"><strong><a href="mailto:{{ $comment->user->email or $comment->email }}">{{ isset($comment->user) ? $comment->user->name : $comment->name }}</a></strong> in</span> 
                <a class="title" href="{{route('articles.show', ['alias' => $comment->article->alias]) }}">{{ $comment->article->title }}</a>
                <p class="comment">
                    {!! str_limit($comment->text, 110) !!} <a class="goto" href="{{route('articles.show', ['alias' => $comment->article->alias]) }}">&#187;</a>
                </p>
            </div>

            @endforeach
        @endif
        </div>
    </div>
    

<!-- END SIDEBAR -->