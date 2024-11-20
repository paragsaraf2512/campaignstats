@extends('layouts.layout')

@section('title', 'Campaigns List')

@section('header', 'Campaigns Dashboard')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Campaign Name</th>
                    <th>UTM Campaign Code</th>
                    <th>Total Revenue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign->name }}</td>
                    <td>{{ $campaign->utm_campaign }}</td>
                    <td>{{ number_format($campaign->total_revenue, 5) }}</td>
                    <td>
                        <a href="{{ route('campaign', $campaign) }}" class="btn btn-sm btn-info">
                            View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $campaigns->onEachSide(1)->links() }}
    </div>
@endsection
