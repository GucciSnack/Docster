@extends('layouts.full_view')
@section('content')
    <form method="POST" action="{{ route('signer.requestAccess', ['signer'=>$signer->id]) }}" class="border p-5 text-center">
        @csrf
        <input type="hidden" name="signer" value="{{ $signer->id }}" />
        <h2>
            @lang('app.signer.enter_code')
            <br />
            <small class="text-muted">
                @lang('app.signer.enter_code_info')
            </small>
        </h2>
        <div class="my-5 form-inline">
            <input type="text" name="code" size="5" class="form-control p-4 mx-auto text-center text-uppercase" style="font-size: 30px;" autocomplete="off" />
        </div>
        <button type="submit" class="btn btn-primary btn-lg">
            @lang('app.signer.submit')
        </button>
    </form>
@endsection
@section('header')
@endsection
@section('scripts')
@endsection