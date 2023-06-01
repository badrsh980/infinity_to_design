@extends('layouts.emails')
@section('slot')
    <tr>
        <td class="wrapper" style="background: #fff;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    {{ __('Please click the button below to verify your email address.') }}
                </tr>
                <tr>
                    @yield('content')
                    @isset($actionText)
                        <a href="{{ $actionUrl }}" class="btn btn-custom">
                            {{ $actionText }}
                        </a>
                    @endisset
                </tr>
                <tr>
                    {{ __("If you're having trouble clicking the ':actionText' button, copy and paste the URL below into your web browser:", ['actionText' => $actionText]) }}
                </tr>
                <tr>
                    [{{ $actionUrl }}]
                </tr>
            </table>
        </td>
    </tr>
@endsection
