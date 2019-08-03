@extends('layouts.app')
@section('content')
    <h2>@lang('app.files.images')</h2>
    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="recent" aria-selected="true">@lang('app.files.all')</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="files" role="tabpanel" aria-labelledby="files-tab">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="45%" scope="col" class="border-top-0"><small>@lang('app.files.name')</small></th>
                    <th width="30%" scope="col" class="border-top-0"><small>@lang('app.files.created')</small></th>
                    <th class="border-top-0"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr id="{{ $file->id }}" data-model="file">
                        <td><img src="{{ asset('storage/app/public/' . $file->file_path) }}" style="max-height: 50px" /></td>
                        <td class="align-middle">{{ date("M jS, Y - g:i A", strtotime($file->created_at)) }}</td>
                        <td class="align-middle">
                            <button type="button" data-target="file" data-action="destroy" data-id="{{ $file->id }}" class="btn btn-sm btn-link p-0 m-0 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48" style=" fill:#000000;">
                                    <path fill="#F44336" d="M21.5 4.5H26.501V43.5H21.5z" transform="rotate(45.001 24 24)"></path>
                                    <path fill="#F44336" d="M21.5 4.5H26.5V43.501H21.5z" transform="rotate(135.008 24 24)"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection