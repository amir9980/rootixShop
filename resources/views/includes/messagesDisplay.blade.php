@if($errors->any())
    <div class="alert alert-danger col-sm-12 col-lg-6">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>

@endif

@if(session('message'))
    <div class="alert alert-success col-sm-12 col-lg-6">
        <ul class="list-inline">
            <li>
                <button type="button" class="close float-left" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </li>
            <li>{{session('message')}}</li>

        </ul>
    </div>

@endif