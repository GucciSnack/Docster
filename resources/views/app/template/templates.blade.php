@extends('layouts.app')
@section('content')
    <!-- begin::exiting templates -->
    <div class="float-right">
        <a href="{{ route('document.create') }}" class="btn btn-outline-primary">@lang('app.documents.add')</a>
        <a href="{{ route('template.create') }}" class="btn btn-outline-primary">@lang('app.templates.add')</a>
    </div>
    <h2>@lang('app.templates')</h2>
    <div id="templates.search.form" class="form-inline d-none">
        <input id="templates.search.input" type="text" class="form-control mt-2 mb-2 col-12 col-md-4 col-lg-3 icon-search mr-3" placeholder="@lang('app.templates.search')" />
    </div>
    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="templates-tab" data-toggle="tab" href="#templates" role="tab" aria-controls="recent" aria-selected="true">@lang('app.templates.all')</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="templates" role="tabpanel" aria-labelledby="templates-tab">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="45%" scope="col" class="border-top-0"><small>@lang('app.templates.name')</small></th>
                        <th width="30%" scope="col" class="border-top-0"><small>@lang('app.templates.modified')</small></th>
                        <th class="border-top-0"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($templates as $template)
                        <tr id="{{ $template->id }}" data-model="template">
                            <td data-action='redirect' data-href='{{ url("template/{$template->id}/edit") }}'>{{ $template->name }}</td>
                            <td data-action='redirect' data-href='{{ url("template/{$template->id}/edit") }}'>{{ date("M jS, Y - g:i A", strtotime($template->updated_at)) }}</td>
                            <td>
                                <button type="button" data-target="template" data-action="destroy" data-id="{{ $template->id }}" class="btn btn-sm btn-link p-0 m-0 mr-2">
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

    <!-- end::existing templates -->
@endsection