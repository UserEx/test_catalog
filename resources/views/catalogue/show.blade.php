@extends('template')

@section('main')
	<h4 class="text-center" style="margin-bottom: 30px;">Категория товара</h4>
	
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-5 text-right">
			Идентификатор:
        </div>
        <div class="col-sm-7">
        	{{ $category->getId() }}
        </div>
	</div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-5 m-l text-right">
        	Название: 
        </div>
        <div class="col-sm-7">
        	{{ $category->getTitle() }}
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-5 text-right">
        	Путь:
        </div>
        <div class="col-sm-7">
        	@php
        		$path = '';
        		$node = $category->getParent();
        		
        		while ($node) {
        			$href = route('showCategoryBySlug', array('slug' => $node->getSlug()), false);
        			$path = '/<a href="' . $href . '">' . $node->getTitle() . '</a>' . $path;
        			$node = $node->getParent();
        		}
        	@endphp
        	{!! $path !!}
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-5 text-right">
        	Подкатегории:
        </div>
        <div class="col-sm-7">
        	<ul>
            	@foreach ($category->getChildren() as $child) 
            		<li>
            			<a href="{{ route('showCategoryBySlug', array('slug' => $child->getSlug()->getSlug()), false) }}">{{ $child->getTitle() }}</a>
        			</li>
            	@endforeach
        	</ul>
        </div>
    </div>
    <div class="text-center" style="margin-top: 30px;">
    	<a class="btn btn-primary" href="{{ route('index') }}" style="color: white;">Вернуться в каталог</a>
    	
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection
