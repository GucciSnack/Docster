@extends('layouts.app')
@section('content')
    <!-- begin::create template -->
    <form method="POST" action="{{ route('template.store') }}">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <!-- begin::variable options -->
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            @lang('app.variables')
                        </div>
                        <div>
                            <button type="button" class="btn btn-block btn-light p-3 m-0" data-target="template" data-action="inject-variable" data-content="document_name" data-signature="0">
                                @lang('app.variables.variable.document_name')
                            </button>
                            <button type="button" class="btn btn-block btn-light p-3 m-0" data-target="template" data-action="inject-variable" data-content="document_id" data-signature="0">
                                @lang('app.variables.variable.document_id')
                            </button>
                            <div id="template.variables">
                            </div>
                            <button type="button" class="btn btn-block btn-secondary p-2" data-toggle="modal" data-target="#template\.variable-modal">
                                @lang('app.variables.manage')
                            </button>
                        </div>
                    </div>
                </div>

                <!-- end::variable options -->
                <!-- begin::template editor -->
                <div class="col-md-10 border-left border-primary">
                    <button type="submit" href="#" class="btn btn-primary float-right">
                        @if($edit ?? false)
                            <input type="hidden" name="template_id" value="{{ $template->id }}" />
                            @lang('app.templates.save_c')
                        @else
                            @lang('app.templates.save')
                        @endif
                    </button>
                    <h2>@lang('app.templates.template')</h2>
                    <ul class="nav nav-tabs border-0" id="right-section" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="templates-tab" data-toggle="tab" href="#templates" role="tab" aria-controls="recent" aria-selected="true">@lang('app.templates.template')</a>
                        </li>
                    </ul>
                    <div class="tab-content py-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="templates" role="tabpanel" aria-labelledby="templates-tab">
                            <input type="text" class="form-control p-4" name="name" placeholder="@lang('app.templates.input.name')" value="{{ old('name') ?? $template->name ?? '' }}" />
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            <div class="mb-3"></div>

                            @include('includes.tinymce', ['name'=>'content', 'content'=> old('content') ?? $template->content ?? ''])
                            @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- end::template editor -->
            </div>
        </div>
    </form>

    <!-- end::create template -->

    <!-- begin::variable modals -->
    <div id="template.variable-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    @lang('app.variables')
                </div>
                <div class="modal-body px-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 border-right border-primary">
                                <select id="variable.input-type" class="form-control mb-2" placeholder="@lang('app.variables.name')">
                                    <option value="0">@lang('app.variables.type.normal')</option>
                                    <option value="1">@lang('app.variables.type.signature')</option>
                                </select>
                                <input id="variable.input-field" type="text" class="form-control p-4 mb-2" placeholder="@lang('app.variables.name')" />
                                <button id="variable.add-variable" type="button" class="btn btn-lg btn-primary btn-block">@lang('app.variables.save')</button>
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th width="90%">@lang('app.variables.name')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variable.table">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end::variables modal -->
@endsection
@section('scripts')
    <script>
        "use strict";

        var Template_Create = function(){
            var variables = [];

            var pushValues = function(fieldValue, fieldVariableValue, isSignatureField){
                variables.push({
                    name: fieldValue,
                    variable: fieldVariableValue,
                    signature_field: isSignatureField,
                    icon: (isSignatureField == 1) ?
                        `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>
                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" id="Path-57" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                    </g>
                </svg>` : ''
                });

                calculateVariables();
            }

            var onVariableClicked = function(parent) {
                parent = (parent != null && parent.trim() != '') ? parent : '';

                $(`${parent} [data-target='template'][data-action='inject-variable']`).click(function(){
                    var varable = $(this).attr('data-content');
                    tinymce.activeEditor.execCommand('mceInsertContent', false, `{${varable}}`);
                });
            };

            var calculateVariables = function() {
                var variableTable = $('#variable\\.table');
                var templateVariableOptionContainer = $('#template\\.variables');

                variableTable.html('');
                templateVariableOptionContainer.html('');
                $.each(variables, function(i, variable){
                    variableTable.append(`
                <tr id="variable.table-variable-${i}">
                    <td>
                        <button type="button" data-target="variable" data-action="destroy" data-id="${i}" class="btn btn-sm btn-link p-0 m-0 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="22" height="22" viewBox="0 0 48 48" style=" fill:#000000;">
                                <path fill="#F44336" d="M43,33c0,5.523-4.477,10-10,10s-10-4.477-10-10s4.477-10,10-10S43,27.477,43,33"></path>
                                <path fill="#FFF" d="M31.5 27H34.5V39H31.5z" transform="rotate(134.999 33 33)"></path>
                                <path fill="#FFF" d="M31.501 27H34.501000000000005V38.999H31.501z" transform="rotate(-134.999 33 33)"></path>
                                <path fill="#1976D2" d="M19.896 19.086c-2.9-2.899-2.889-7.63.025-10.544l1.452-1.451c2.914-2.914 7.644-2.926 10.544-.025 2.878 2.878 2.929 7.521.119 10.572l-1.509 1.511C27.418 22.016 22.773 21.964 19.896 19.086zM29.088 9.894c-1.34-1.34-3.533-1.329-4.887.025l-1.452 1.451c-1.354 1.354-1.365 3.547-.024 4.888 1.354 1.354 3.566 1.357 5.033.005l1.393-1.395C30.445 13.46 30.443 11.249 29.088 9.894zM7.168 31.814c-2.9-2.9-2.889-7.631.024-10.544l1.452-1.452c2.914-2.914 7.644-2.925 10.544-.024 2.877 2.877 2.929 7.521.119 10.572l-1.509 1.511C14.688 34.744 10.045 34.691 7.168 31.814zM16.36 22.622c-1.341-1.341-3.533-1.329-4.888.024l-1.452 1.452c-1.354 1.354-1.365 3.547-.024 4.887 1.355 1.355 3.566 1.358 5.033.006l1.393-1.395C17.718 26.188 17.715 23.977 16.36 22.622z"></path>
                                <path fill="#42A5F5" d="M13.531,25.449c-0.781-0.78-0.781-2.047,0-2.828l9.192-9.192c0.781-0.781,2.047-0.781,2.829,0c0.78,0.781,0.78,2.048,0,2.828l-9.193,9.192C15.579,26.23,14.313,26.23,13.531,25.449z"></path>
                            </svg>
                        </button>
                    </td>
                    <td><span class="mr-2">${variable.icon}</span> ${variable.name}</td>
                </tr>
            `);
                    templateVariableOptionContainer.append(`
                <div id="variable.variable-option-${i}">
                    <button type="button" class="btn btn-block btn-light p-3 m-0" data-target="template" data-action="inject-variable" data-content="${variable.variable}" data-signature="${variable.signature_field}">
                        <span class="mr-2">${variable.icon}</span> ${variable.name}
                    </button>
                    <input type="hidden" name="variables[${variable.variable}]" value="${variable.name}" />
                    <input type="hidden" name="signatures[${variable.variable}]" value="${variable.signature_field}" />
                </div>
            `);
                });
                onDestroyVariable();
                onVariableClicked('#template\\.variables');
            };

            var onDestroyVariable = function() {
                $("[data-target='variable'][data-action='destroy']").click(function(){
                    var variableId = $(this).attr('data-id');

                    variables.splice(variableId, 1);
                    calculateVariables();
                });
            };

            var onStoreNewVariable = function(){
                var variableInputField = $('#variable\\.input-field');

                var storeInput = function(){
                    var fieldValue = variableInputField.val().trim();
                    var fieldVariableValue = fieldValue.replace(/\s+/g, "_").toLowerCase();
                    var isSignatureField = $('#variable\\.input-type').val();
                    variableInputField.val('');

                    if(fieldValue == "") return;

                    // make sure value doesn't already exist
                    var valueFound = $.grep(variables, function( variable, i ) {
                        return variable.variable == fieldVariableValue;
                    });
                    if(valueFound.length) return;

                    pushValues(fieldValue, fieldVariableValue, isSignatureField);
                };

                $("#variable\\.add-variable").click(function(){
                    storeInput();
                });
                variableInputField.keyup(function(e){
                    if(e.which === 13){
                        storeInput();
                    }
                });
            };

            return {
                // public functions
                init: function(){
                    onStoreNewVariable();
                    onDestroyVariable();
                    onVariableClicked();
                },

                importVariable: function(fieldValue, fieldVariableValue, isSignatureField){
                    pushValues(fieldValue, fieldVariableValue, isSignatureField);
                },

                variables: variables,
            };
        }();

        $(function(){
            Template_Create.init();
        });
    </script>
    @if($edit ?? false)
        <script>
            $(function(){
                setTimeout(function(){
                    $.get('/template/{{ $template->id }}/variables', function(variables){
                        $(variables).each(function(i, variable){
                            Template_Create.importVariable(variable.name, variable.variable, variable.signature_field);
                        });
                    });
                }, 1000);
            });
        </script>
    @endif
@endsection