@extends('layouts.full_view')
@section('content')
    <form method="POST" action="?" class="card">
        @csrf
        <div class="card-header">
            <h1>@lang('installer.installer')</h1>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                Hello, <br /><br />
                We wanted a document system that allowed our clients and new hires to sign documents
                electronically from anywhere. We though to share our resource and intend to build upon it.
                So thank you for your purchase of Docster!

                <hr />

                To install, you'll just need to enter the name of your application, domain URL, database and emailing details.
            </div>

            @if ($logs ?? false)
                <div class="p-2 border">
                    @foreach ($logs as $log)
                        {{ $log }} <br />
                    @endforeach
                </div>
            @endif

            <h3>@lang('installer.application.title')</h3>

            <label>@lang('installer.application')</label>
            <input name="APP_NAME" class="form-control" value="{{ old('APP_NAME') ?? env('APP_NAME') ?? "Docster" }}">
            @if ($errors->has('APP_NAME'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('APP_NAME') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.domain')</label>
            <input name="APP_URL" class="form-control" value="{{ old('APP_URL') ?? env('APP_URL') ?? "https://" }}">
            @if ($errors->has('APP_URL'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('APP_URL') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <hr />

            <h3>@lang('installer.database.title')</h3>

            <label>@lang('installer.database_host')</label>
            <input name="DB_HOST" class="form-control" value="{{ old('DB_HOST') ?? env('DB_HOST') ?? "localhost" }}">
            @if ($errors->has('DB_HOST'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('DB_HOST') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.database_database')</label>
            <input name="DB_DATABASE" class="form-control" value="{{ old('DB_DATABASE') ?? env('DB_DATABASE') ?? "" }}">
            @if ($errors->has('DB_DATABASE'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('DB_DATABASE') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div

            <label>@lang('installer.database_user')</label>
            <input name="DB_USERNAME" class="form-control" value="{{ old('DB_USERNAME') ?? env('DB_USERNAME') ?? "" }}">
            @if ($errors->has('DB_USERNAME'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('DB_USERNAME') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.database_password')</label>
            <input type="password" name="DB_PASSWORD" class="form-control" value="{{ old('DB_PASSWORD') ?? env('DB_PASSWORD') ?? "" }}">
            @if ($errors->has('DB_PASSWORD'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('DB_PASSWORD') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <hr />

            <h3>@lang('installer.email.title')</h3>

            <label>@lang('installer.email_driver')</label>
            <input name="MAIL_DRIVER" class="form-control" value="{{ old('MAIL_DRIVER') ?? env('MAIL_DRIVER') ?? "smtp" }}">
            @if ($errors->has('MAIL_DRIVER'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_DRIVER') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.email_host')</label>
            <input name="MAIL_HOST" class="form-control" value="{{ old('MAIL_HOST') ?? env('MAIL_HOST') ?? "" }}">
            @if ($errors->has('MAIL_HOST'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_HOST') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.email_port')</label>
            <input name="MAIL_PORT" class="form-control" value="{{ old('MAIL_PORT') ?? env('MAIL_PORT') ?? "587" }}">
            @if ($errors->has('MAIL_PORT'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_PORT') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.email_username')</label>
            <input name="MAIL_USERNAME" class="form-control" value="{{ old('MAIL_USERNAME') ?? env('MAIL_USERNAME') ?? "" }}">
            @if ($errors->has('MAIL_USERNAME'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_USERNAME') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.email_password')</label>
            <input type="password" name="MAIL_PASSWORD" class="form-control" value="{{ old('MAIL_PASSWORD') ?? env('MAIL_PASSWORD') ?? "" }}">
            @if ($errors->has('MAIL_PASSWORD'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_PASSWORD') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.email_encryption')</label>
            <input name="MAIL_ENCRYPTION" class="form-control" value="{{ old('MAIL_ENCRYPTION') ?? env('MAIL_ENCRYPTION') ?? "tls" }}">
            @if ($errors->has('MAIL_ENCRYPTION'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_ENCRYPTION') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.email_system_from_address')</label>
            <input name="MAIL_FROM_ADDRESS" class="form-control" value="{{ old('MAIL_FROM_ADDRESS') ?? env('MAIL_FROM_ADDRESS') ?? "example@example.com" }}">
            @if ($errors->has('MAIL_FROM_ADDRESS'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_FROM_ADDRESS') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.email_system_from_name')</label>
            <input name="MAIL_FROM_NAME" class="form-control" value="{{ old('MAIL_FROM_NAME') ?? env('MAIL_FROM_NAME') ?? "Example Company" }}">
            @if ($errors->has('MAIL_FROM_NAME'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('MAIL_FROM_NAME') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <hr />

            <h3>@lang('installer.account.title')</h3>

            <label>@lang('installer.account_name')</label>
            <input name="username" class="form-control" value="{{ old('username') ?? "Admin" }}">
            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.account_username')</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') ?? "admin@example.com" }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <div class="mb-2"></div>

            <label>@lang('installer.account_password')</label>
            <input type="password" name="password" class="form-control" value="{{ old('password') ?? "" }}">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <div class="mb-5"></div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">@lang('installer.submit')</button>
            </div>
        </div>
    </form>
@endsection