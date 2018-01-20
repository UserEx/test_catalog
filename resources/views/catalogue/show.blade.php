@extends('template')

@section('main')
	<h3>Категория товара</h3>
	<div class="row">
		<div class="col-sm-4">
			Идентификатор
        </div>
        <div class="col-sm-8">
        	{{ $category->getId() }}
        </div>
	</div>
    <div class="row">
        <div class="col-sm-4">
        	Название 
        </div>
        <div class="col-sm-8">
        	{{ $category->getTitle() }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
        	Путь 
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
    <div class="row">
        <div class="col-sm-4">
        	Подкатегории
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
@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection
