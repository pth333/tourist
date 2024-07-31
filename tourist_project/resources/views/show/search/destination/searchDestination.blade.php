<link rel="stylesheet" href="{{ asset('searchAjax/css/list.css')}}">
@foreach($destinations as $destination)
<div class="media">
    <div class="media-body">
        <h6 class="media-heading search-item-destination" data-name="{{ $destination }}">{{ $destination}}</h6>
    </div>
</div>
@endforeach
