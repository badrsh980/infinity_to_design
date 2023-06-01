@extends('layouts.emails')

@section('slot')
    <h1>{{ __('Your gig has been approved') }}</h1>
    <table>
        <tr>
            <th>{{ __('الخدمة') }}</th>
            <td>{{ $gig->title }}</td>
        </tr>
    </table>
@endsection
