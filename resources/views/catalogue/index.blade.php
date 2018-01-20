@extends('template')

@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div id="catalogue">
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
	var catalog = {!! $json_nodes !!};

	$('#catalogue').treeview({data: catalog, enableLinks: true});
</script>
@endsection
