@extends('layouts.app')

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <div class="statsContainer" data-id="{{ $id }}">
    <canvas id="views"></canvas>
    <canvas id="msgs"></canvas>
  </div>
@endsection
