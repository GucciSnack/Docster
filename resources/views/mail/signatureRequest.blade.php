<div>
    Hello,
    <br />
    <br />
    We are pleased to notify you that your document is ready and available to sign.
    For your convenience, this document is being delivered in a format that allows for you to review and sign the document electronically through {{ config('app.name', 'Docster') }}.
    <br />
    <br />
    Enter the code: <b>{{ $auth_code }}</b>
    <br />
    <br />
    <a href="{{ url('sign-document/' . $signer_id ) }}">Sign Document</a>
</div>