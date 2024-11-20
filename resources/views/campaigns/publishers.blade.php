@extends('layouts.layout')

@section('title', 'Campaign Revenue by UTM Term')

@section('header', 'Revenue by UTM Term for Campaign: '.$campaign->name)

@section('content')
    <div class="container mt-5">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Term Name</th>
                    <th>UTM Term Code</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($terms as $term)
                    <tr>
                        <td>{{ $term->name }}</td>
                        <td>{{ $term->utm_term }}</td>
                        <td>{{ number_format($term->total_revenue, 5) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $terms->onEachSide(1)->links() }}
        </div>
        <a href="{{ route('campaign', $campaign) }}" class="btn btn-secondary mt-3">Back to Details</a>
    </div>
@endsection
