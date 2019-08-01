@extends('layouts.full_view')
@section('content')
    @if ($signer->signature_data === '')
        <div class="alert alert-warning">
            <h2>
                @lang('app.signer.no_signature')
                <br />
                <small class="text-muted">
                    @lang('app.signer.no_signature_info')
                </small>
            </h2>
        </div>
    @endif
    <div class="border p-5">
        {!! $signer->document->processedDocument() !!}
    </div>
    @if ($signer->signature_data === '')
        <div id="signature-pad" class="p-2 border mt-3">
            <canvas class="zindex-modal" width="664" height="373" style="touch-action: none;"></canvas>
            <div class="row col-12">
                <div class="text-center border-top position-absolute w-100" style="margin-top: -100px">
                    <div class="text-muted">@lang('app.signer.sign_above')</div>
                </div>
            </div>
            <br />
            <div class="text-center">
                <button id="signature-clear" type="button" class="btn btn-secondary">@lang('app.signer.clear_signature')</button>
                <button id="signature-save" type="button" class="btn btn-primary">@lang('app.signer.save_signature')</button>
                <form id="signature-form" method="POST" action="{{ route('signer.store') }}" class="d-none">
                    @csrf
                    <input type="hidden" name="document_id" value="{{ $signer->document->id }}" />
                    <input type="hidden" name="signer_id" value="{{ $signer->id }}" />
                    <input id="signature-field" type="hidden" name="signature" value="" />
                </form>
            </div>
        </div>
    @endif
@endsection
@section('header')
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script>
        $(function(){
            var wrapper = document.getElementById("signature-pad");
            var canvas = wrapper.querySelector("canvas");
            var signaturePad = new SignaturePad(canvas, {
                // It's Necessary to use an opaque color when saving image as JPEG;
                // this option can be omitted if only saving as PNG or SVG
                backgroundColor: 'rgb(255, 255, 255)'
            });

            // Adjust canvas coordinate space taking into account pixel ratio,
            // to make it look crisp on mobile devices.
            // This also causes canvas to be cleared.
            function resizeCanvas() {
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);

                // This part causes the canvas to be cleared
                canvas.width = wrapper.offsetWidth - 50;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);

                // This library does not listen for canvas changes, so after the canvas is automatically
                // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
                // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
                // that the state of this library is consistent with visual state of the canvas, you
                // have to clear it manually.
                signaturePad.clear();
            }

            // On mobile devices it might make more sense to listen to orientation change,
            // rather than window resize events.
            window.onresize = resizeCanvas;
            resizeCanvas();

            $('#signature-clear').click(function(){
                signaturePad.clear();
            });

            $('#signature-save').click(function(){
                const data = signaturePad.toDataURL();
                $("#signature-field").val(JSON.stringify(data));
                $("#signature-form").submit();
            });
        });
    </script>
@endsection