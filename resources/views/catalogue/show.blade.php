@extends('template')

@section('main')
	<h2 class="text-center" style="margin-bottom: 30px;">Категория товара</h2>
	
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-4 text-right">
			Идентификатор:
        </div>
        <div class="col-sm-8">
        	{{ $category->getId() }}
        </div>
	</div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-4 m-l text-right">
        	Название: 
        </div>
        <div class="col-sm-8">
        	{{ $category->getTitle() }}
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-4 text-right">
        	Путь:
        </div>
        <div class="col-sm-8">
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
        <div class="col-sm-4 text-right">
        	Подкатегории:
        </div>
        <div class="col-sm-8">
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
    	<button type="button" class="btn btn-primary"><a href="{{ route('index') }}" style="color: white;">Вернуться в каталог</a></button>
    	
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection
