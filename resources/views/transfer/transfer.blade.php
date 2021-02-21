@extends('base.base')
@section('main-content')
    <main class="register-main mt-5">
        <div class="container mt-5">
            <div class="row h-100 d-flex justify-content-between">
                <div class="col-6 col-md-6 col-sm-6 col-xs-6 div-center">
                    <div class="card auth-card" style="margin: 100px 0 0 0;">
                        <div class="form-side login-form div-center">
                            <h1 class="mb-4"><b>{{ __('demo.demo_account_card_heading') }}</b></h1>
                            <div class="mb-4 errorElement alert alert-danger d-none"></div>
                            <div class="mb-4 successElement alert alert-success d-none"></div>
                            <form>
                                @csrf
                                <div class="inline-form-fields">

                                    <label class="form-group has-float-label mb-4 w-100 mr-2">
                                        <select id="inputState" class="form-control" name="transfer_from">
                                            @foreach($users as $user)
                                                <option data-currency="{{ $user->currency }}"
                                                        value="{{ $user->id }}"> {{ $user->user_name }}</option>
                                            @endforeach
                                        </select>
                                        <span>{{ __('demo.transfer_from') }}</span>
                                    </label>

                                    <label class="form-group has-float-label mb-4 w-100 ml-2">
                                        <input type="number" min="0" class="form-control" name="amount"/>
                                        <span>{{ __('demo.amount') }}</span>
                                    </label>

                                </div>
                                <div class="inline-form-fields">

                                    <label class="form-group has-float-label mb-4 w-100 mr-2">
                                        <select id="inputState" class="form-control" name="transfer_to">
                                            @foreach($users as $key => $user)
                                                @if($key <> 0)
                                                    <option value="{{ $user->id }}"> {{ $user->user_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span>{{ __('demo.transfer_to') }}</span>
                                    </label>


                                    <label class="form-group has-float-label mb-4 w-100 ml-2">
                                        <input class="form-control" name="currency"/>
                                        <span>{{ __('demo.currency') }}</span>
                                    </label>

                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <button class="btn btn-primary btn-lg btn-shadow w-100 demo-account"
                                            type="submit">{{ __('demo.submit_button') }}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        let requestDemoURL = '{{ route('transfer_amount') }}';
        $( function() {

            let errorElement = $( '.errorElement' );
            let successElement = $( '.successElement' );

            function showLoaderOrNot( loaderShow = true ) {
                let submitElement = $( '.demo-account' );
                if ( loaderShow ) {
                    $( submitElement ).attr( 'disabled', 'disabled' ).prepend( '<span class="spinner-border spinner-border-sm"></span> ' );
                } else {
                    $( submitElement ).removeAttr( 'disabled' );
                    $( submitElement ).find( 'span.spinner-border' ).remove();
                }
            }

            function getMetaContent() {
                return $( 'meta[name="csrf-token"]' ).attr( 'content' );
            }

            function prepareJSONData( formElement = 'form' ) {
                let object = {};
                $( formElement + " :input" ).each( function( key, value ) {
                    let input = $( value );
                    object[ $( input ).attr( 'name' ) ] = $( input ).val();
                } );
                return object;
            }

            function parseSuccess( res ) {
                $( errorElement ).addClass( 'd-none' ).html( '' );
                $( successElement ).removeClass( 'd-none' ).fadeIn( 1000 ).html( res.message );
                $( 'form' ).fadeOut( 'slow' ).slideUp( 'slow' );
            }

            function parseErrors( errorsArray, errorMessages ) {
                let shouldRemove = null;
                $( successElement ).addClass( 'd-none' );
                // show error alert
                $( errorElement ).removeClass( 'd-none' ).html( errorMessages );
                $.each( errorsArray.errors, function( key, value ) {
                    $.each( value, function( key2, value2 ) {
                        shouldRemove = true;
                        $( errorElement ).append( '<br />' ).append( value2 );
                    } );
                } );

                // shouldRemove ? $( errorElement ).removeClass( 'd-none' ) : ($( errorElement ).hasClass( 'd-none' ) ? null : $( errorElement ).addClass( 'd-none' ))
            }

            function removeAllMessages() {
                $( errorElement ).hasClass( 'd-none' ) ? null : $( errorElement ).addClass( 'd-none' );
                $( successElement ).hasClass( 'd-none' ) ? null : $( successElement ).addClass( 'd-none' );
            }

            function RequestForDemoAccount() {
                let errorCode = null;
                removeAllMessages();
                fetch( requestDemoURL, {
                    method: 'POST',
                    body: JSON.stringify( prepareJSONData() ),
                    headers: {
                        'X-CSRF-TOKEN': getMetaContent(),
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    }
                } ).then( res => {
                    errorCode = res.status;
                    return res.json();
                } ).then( res => {
                    switch ( errorCode ) {
                        case 422:
                            parseErrors( res, res.message )
                            break;
                        case 200:
                            parseSuccess( res );
                            break;
                    }
                } ).catch( () => {
                } ).finally( () => {
                    showLoaderOrNot( false );
                } )
            }

            function setCurrencyInputValue() {
                $( 'input[name=currency]' ).val( $( 'select[name=transfer_from]' ).find( ':selected' ).attr( 'data-currency' ) );
            }

            setCurrencyInputValue();

            // on click request for demo
            $( document ).on( 'click', '.demo-account', function( e ) {
                e.preventDefault();
                showLoaderOrNot();
                RequestForDemoAccount();
            } );

            $( document ).on( 'change', 'select[name=transfer_from]', function() {
                setCurrencyInputValue();
            } );

        } );
    </script>
@endsection
