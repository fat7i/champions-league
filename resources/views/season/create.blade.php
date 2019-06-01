@extends('layout.default')

@section('content')

    <div class="row">
        <div class="col-12">
            <h2>Create New Season</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

        <form action="{{ route('store_season') }}" method="post" class="form-row">
            @csrf
            <div class="card-body">

                <div class="form-group row">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-label">Season Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control form-control-lg @if($errors->first('name')) is-invalid @endif" placeholder="2018/19">
                            <p class="form-text text-danger">{{ $errors->first('name') }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-ft">Create!</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection
