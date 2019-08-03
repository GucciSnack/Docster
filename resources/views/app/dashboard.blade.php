@extends('layouts.app')
@section('content')
    <!-- begin::document templates -->
    <div class="row mb-5">
        <div class="col-md-12">
            <a href="{{ route('template.create') }}" class="btn btn-outline-primary float-right">@lang('app.templates.add')</a>
            <h2>
                @lang('app.templates')
            </h2>
            <div class="list-group list-group-horizontal overflow-hidden">
                @foreach($templates as $template)
                    <a href="{{ route('document.create', ['template_id'=>$template->id]) }}">
                        <div class="mr-3 p-2 preview text-center text-dark" style="background-image:url({{ $template->thumbnail() }});background-size:cover;">
                            <h6 class="mt-5"><b>{{ $template->name }}</b></h6>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 d-none">
            <h2>@lang('app.templates.community')</h2>
        </div>
    </div>

    <!-- end::document templates -->
    <hr />
    <!-- begin::exiting documents -->
    <a href="{{ route('document.create') }}" class="btn btn-outline-primary float-right">@lang('app.documents.add')</a>
    <h2>@lang('app.documents')</h2>
    <div id="documents.search.form" class="form-inline d-none">
        <input id="document.search.input" type="text" class="form-control mt-2 mb-2 col-12 col-md-4 col-lg-3 icon-search mr-3" placeholder="@lang('app.documents.search')" />
    </div>
    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="recent-tab" data-toggle="tab" href="#recent" role="tab" aria-controls="recent" aria-selected="true">@lang('app.documents.recent')</a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" id="pinned-tab" data-toggle="tab" href="#pinned" role="tab" aria-controls="pinned" aria-selected="false">@lang('app.documents.pinned')</a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" id="my_documents-tab" data-toggle="tab" href="#my_documents" role="tab" aria-controls="my_documents" aria-selected="false">@lang('app.documents.my_documents')</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="recent" role="tabpanel" aria-labelledby="recent-tab">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="70%" scope="col" class="border-top-0"><small>@lang('app.documents.name')</small></th>
                    <th width="30%" scope="col" class="border-top-0"><small>@lang('app.documents.modified')</small></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        <tr id="{{ $document->id }}" data-model="document">
                            <td data-action='redirect' data-href='{{ url("document/{$document->id}") }}'>{{ $document->name }}</td>
                            <td data-action='redirect' data-href='{{ url("document/{$document->id}") }}'>{{ date("M jS, Y - g:i A", strtotime($document->updated_at)) }}</td>
                            <td>
                                <button type="button" data-target="document" data-action="destroy" data-id="{{ $document->id }}" class="btn btn-sm btn-link p-0 m-0 mr-2">
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
        <div class="tab-pane fade" id="pinned" role="tabpanel" aria-labelledby="pinned-tab">
            <table class="table">
                <thead>
                <tr>
                    <th width="70%" scope="col" class="border-top-0"><small>@lang('app.documents.name')</small></th>
                    <th width="30%" scope="col" class="border-top-0"><small>@lang('app.documents.modified')</small></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="my_documents" role="tabpanel" aria-labelledby="my_documents-tab">
            <table class="table">
                <thead>
                <tr>
                    <th width="70%" scope="col" class="border-top-0"><small>@lang('app.documents.name')</small></th>
                    <th width="30%" scope="col" class="border-top-0"><small>@lang('app.documents.modified')</small></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- end::existing documents -->
@endsection