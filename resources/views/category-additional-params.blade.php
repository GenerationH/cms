<div>
    @foreach($getRecord()['additional_params'] as $key => $value)
        {{$value['name']}}:{{$value['type']}}<br />
    @endforeach
</div>
