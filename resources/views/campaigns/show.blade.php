@extends('layouts.layout')

@section('title', 'Campaign Hourly Breakdown')

@section('header', 'Hourly Breakdown for Campaign: '.$campaign->name)

@section('content')
    <div class="container mt-5">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Hour</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stats as $stat)
                    <tr>
                        <td>{{ $stat->date }}</td>
                        <td>{{ $stat->hour }}:00</td>
                        <td>{{ number_format($stat->total_revenue, 5) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $stats->onEachSide(1)->links() }}
        </div>
        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Back to Campaigns</a>
        <a href="{{ route('publishers', $campaign) }}" class="btn btn-primary mt-3">
            View Revenue by UTM Term
        </a>
    </div>
@endsection
