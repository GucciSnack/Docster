@extends('layouts.app')
@section('content')
    <div class="form-inline float-left">
        <a href="{{ route('document.edit', ['document'=>$document->id]) }}" class="btn btn-outline-secondary mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                    <rect id="Rectangle" fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                </g>
            </svg>
            <span class="ml-2">@lang('app.documents.edit')</span>
        </a>
        <form method="POST" action="{{ route('viewlink.store') }}">
            @csrf
            <input type="hidden" name="document_id" value="{{ $document->id }}" />
            <button type="submit" class="btn btn-outline-secondary mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                        <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" id="Shape" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" id="Path" fill="#000000" opacity="0.3"/>
                    </g>
                </svg>
                <span class="ml-2">@lang('app.documents.generate_view_link')</span>
            </button>
        </form>
        <a href="{{ route('document.download', ['document'=>$document->id]) }}" target="_blank" class="btn btn-outline-secondary mx-2">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                    <rect id="Rectangle" fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                    <rect id="Rectangle-Copy" fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
                </g>
            </svg>
            <span class="ml-2">@lang('app.documents.download_pdf')</span>
        </a>
    </div>
    <form method="POST" action="{{ route('signer.store') }}">
        @csrf
        <input type="hidden" name="document_id" value="{{ $document->id }}" />
        <button type="submit" class="btn btn-outline-primary float-right">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                    <path d="M11,3 L11,11 C11,11.0862364 11.0109158,11.1699233 11.0314412,11.2497543 C10.4163437,11.5908673 10,12.2468125 10,13 C10,14.1045695 10.8954305,15 12,15 C13.1045695,15 14,14.1045695 14,13 C14,12.2468125 13.5836563,11.5908673 12.9685588,11.2497543 C12.9890842,11.1699233 13,11.0862364 13,11 L13,3 L17.7925828,12.5851656 C17.9241309,12.8482619 17.9331722,13.1559315 17.8173006,13.4262985 L15.1298744,19.6969596 C15.051085,19.8808016 14.870316,20 14.6703019,20 L9.32969808,20 C9.12968402,20 8.94891496,19.8808016 8.87012556,19.6969596 L6.18269936,13.4262985 C6.06682778,13.1559315 6.07586907,12.8482619 6.2074172,12.5851656 L11,3 Z" id="Combined-Shape" fill="#000000"/>
                    <path d="M10,21 L14,21 C14.5522847,21 15,21.4477153 15,22 L15,23 L9,23 L9,22 C9,21.4477153 9.44771525,21 10,21 Z" id="Rectangle-2" fill="#000000" opacity="0.3"/>
                </g>
            </svg>
            <span class="ml-2">@lang('app.documents.send_sign_requests')</span>
        </button>
    </form>
    <div id="preview-container" class="border p-5 mt-5">
        @if (count($document->viewLinks) > 0)
            <div class="row">
                <div class="col-md-5">
                    <h4>@lang('app.documents.view_links')</h4>
                    @foreach ($document->viewLinks as $viewlink)
                        <div id="{{ $viewlink->id }}" class="p-2 border" data-model="view-link">
                            <button type="button" class="btn btn-danger" data-target="view-link" data-action="destroy" data-id="{{ $viewlink->id }}">@lang('app.documents.delete_link')</button>
                            <a href="{{ url('view-document/' . $viewlink->fake_path) }}">{{ url('view-document/' . $viewlink->fake_path) }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr />
        @endif
        {!! $document->processedDocument() !!}
    </div>
@endsection
@section('header')
@endsection
@section('scripts')
@endsection