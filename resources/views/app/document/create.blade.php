@extends('layouts.app')
@section('content')
    <!-- begin::create document -->
    <form method="POST" action="{{ route('document.store') }}">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <!-- begin::variable options -->
                <div id="variables-column" class="col-md-2 @if($edit ?? false) @else d-none @endif">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            @lang('app.variables.fields')
                        </div>
                        <div id="variables-field-container">
                            @if($edit ?? false)
                                @foreach($document->getVariables() as $variable => $data)
                                    <div>
                                        <div class="p-2">
                                            <small>
                                                {{ $variable }}
                                                @if($data->signature_field)
                                                    <br />@lang('app.variables.signature_field_info')
                                                @endif
                                            </small>
                                        </div>
                                        <input type="{{ ($data->signature_field) ? 'email' : 'text' }}" name="variables[{{ $variable }}]" data-type="variable" data-variable="{{ $variable }}" data-signature='{{ $data->signature_field }}' value="{{ $data->value }}" class="form-control p-3 border-left-0 border-right-0 border-top-0 border-bottom" placeholder="{{ $variable }}" requried />
                                        <input type="hidden" name="signature[{{ $variable }}]" value="{{ $data->signature_field }}" />
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- end::variable options -->
                <!-- begin::document editor -->
                <div id="document-column" class="@if($edit ?? false) col-md-10 border-left @else col-md-12 @endif border-primary">
                    <button type="submit" href="#" class="btn btn-primary float-right">
                        @if($edit ?? false)
                            <input type="hidden" name="document_id" value="{{ $document->id }}" />
                            @lang('app.documents.save_c')
                        @else
                            @lang('app.documents.save')
                        @endif
                    </button>
                    <h2>@lang('app.documents.document')</h2>
                    <ul class="nav nav-tabs border-0" id="right-section" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="recent" aria-selected="true">@lang('app.documents.document')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="preview-tab" data-toggle="tab" href="#preview" role="tab" aria-controls="recent" aria-selected="true">@lang('app.documents.preview')</a>
                        </li>
                    </ul>
                    <div class="tab-content py-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                            <select id="document-template-selection" class="form-control mb-3">
                                <option value="0">@lang('app.templates.select_one')</option>
                                <option value="-1">@lang('app.templates.clear')</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="template_id" value="{{ old('template_id') ?? $template_id ?? 0 }}" />
                            <input type="text" class="form-control p-4 mb-3" name="name" placeholder="@lang('app.documents.input.name')" value="{{ old('name') ?? $document->name ?? '' }}" />
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            @include('includes.tinymce', ['name'=>'content', 'content'=> old('content') ?? $content ?? $document->content ?? ''])
                            @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="preview" role="tabpanel" aria-labelledby="preview-tab">
                            <div id="preview-container" class="border p-5"></div>
                        </div>
                    </div>
                </div>

                <!-- end::document editor -->
            </div>
        </div>
    </form>
    @php
       $variables = (!empty(old('template_id'))) ? \App\Template::find(old('template_id'))->variables : [];
    @endphp

    <!-- end::create document -->
@endsection
@section('scripts')
    <script>
        var variableValues = {
            @foreach($variables as $variable)
                {{ $variable->variable }}: "{{ old("variables.{$variable->variable}") }}",
            @endforeach
        };
        var templateId = 0;

        "use strict";

        var Document_Create = function() {

            var loadPreview = function (){
                var variables = {};
                $("[data-type='variable']").each(function(i, variable){
                    variables[$(variable).data('variable')] = {
                        value: $(variable).val(),
                        signature_field: $(variable).data('signature')
                    };
                });

                $.post('/document/preview', {
                    content: tinyMCE.activeEditor.getContent(),
                    variable_values: variables
                }, function(html){
                    $("#preview-container").html(html);
                });
            };

            var onVariablesChanged = function(){
                $("[data-type='variable']").keyup(function(){
                    console.log('loading');
                    loadPreview();
                });
            };

            var onPreviewClicked = function(){
                $('#preview-tab').click(function(){
                    loadPreview();
                });
            };

            var setVariableEnabled = function(enable){
                if(enable){
                    $("#variables-column").removeClass('d-none');
                    $("#document-column").addClass('col-md-10 border-left').removeClass('col-md-12');
                } else {
                    $("#variables-column").addClass('d-none');
                    $("#document-column").removeClass('col-md-10 border-left').addClass('col-md-12');
                }
            };

            var loadOldTemplateId = function(){
                templateId = $('input[name="template_id"]').val().trim();
                if(templateId == '0' || templateId == '-1') return;
                $("#document-template-selection").val(templateId).change();
            };

            var onSelectTemplate = function () {
                $("#document-template-selection").change(function(){
                    var selectedValue = $(this).val();

                    if(selectedValue.trim() == '0') return;

                    // set template_id value
                    $('input[name="template_id"]').val(selectedValue);

                    if(selectedValue.trim() != '-1'){
                        // load template
                        $.get(`/template/${selectedValue}`, function (response) {
                            tinyMCE.activeEditor.setContent(response.content);

                            // output variables
                            if(response.variables.length > 0){
                                setVariableEnabled(true);
                                $("#variables-field-container").html('');
                                $.each(response.variables, function(i, variable){
                                    var signatureHelpNotice = (variable.signature_field == 1) ? "<br />{{ __('app.variables.signature_field_info') }}" : '';
                                    var type = (variable.signature_field == 1) ? 'email' : 'text';
                                    var variableVariable = variable.variable;
                                    var value = (variableValues[variableVariable] != null) ? variableValues[variableVariable] : '';
                                    var errorMsg = (value == '' && templateId != 0) ? `<br /><span style="color:red">${variable.name} {{ __('app.variables.is_required') }}</span>` : '';
                                    $("#variables-field-container").append(`
                                        <div>
                                            <div class="p-2">
                                                <small>
                                                    ${variable.name}${signatureHelpNotice}${errorMsg}
                                                </small>
                                            </div>
                                            <input type="${type}" name="variables[${variable.variable}]" data-type="variable" data-variable="${variable.variable}" data-signature='${variable.signature_field}' value="${value}" class="form-control p-3 border-left-0 border-right-0 border-top-0 border-bottom" placeholder="${variable.name}" requried />
                                            <input type="hidden" name="signature[${variable.variable}]" value="${variable.signature_field}" />
                                        </div>
                                    `);
                                });
                                onVariablesChanged();
                            } else {
                                setVariableEnabled(false);
                            }
                        });
                    } else {
                        tinyMCE.activeEditor.setContent('');
                        setVariableEnabled(false);
                        $("#variables-field-container").html('');
                    }

                    $(this).val(0).change();
                });
            };

            return {
                // public functions
                init: function(){
                    onSelectTemplate();
                    loadOldTemplateId();
                    onPreviewClicked();
                },
            };
        }();

        $(function(){
            Document_Create.init();
        });
    </script>
@endsection