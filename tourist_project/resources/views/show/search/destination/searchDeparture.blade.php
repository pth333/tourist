<link rel="stylesheet" href="{{ asset('searchAjax/css/list.css')}}">
@foreach($departures as $departure)
<div class="media">
    <div class="media-body">
        <h6 class="media-heading search-item" data-name="{{ $departure }}">{{ $departure}}</h6>
    </div>
</div>
@endforeach

