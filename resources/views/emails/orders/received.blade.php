@extends('layouts.emails')

@section('slot')
    <h1>{{ __('You have new order') }}</h1>
    <table>
        <tr>
            <th>{{ __('اسم المستخدم') }}</th>
            <td>{{ $order->user->name }}</td>
        </tr>
        <tr>
            <th>{{ __('الخدمة') }}</th>
            <td>{{ $order->gig->title }}</td>
        </tr>
    </table>
@endsection
