<link rel="stylesheet" href="{{ asset('searchAjax/css/list.css')}}">
@foreach($locations as $location)
<div class="media">
    <div class="media-body">
        <h6 class="media-heading search-item-location" data-name="{{ $location }}">{{ $location}}</h6>
    </div>
</div>
@endforeach
