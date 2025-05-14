{{-- resources/views/admin/employer/pending.blade.php --}}
@extends('layouts.admin')

@section('content')
  <h1 class="text-2xl mb-4">Pending Employers</h1>
  @if(session('success'))<div class="bg-green-100 p-2 rounded mb-3">{{ session('success') }}</div>@endif
  @foreach($pendingEmployers as $emp)
    <div x‑data="{open:false}" class="bg-white p-4 rounded shadow mb-4">
      <div class="flex justify-between items-center">
        <button @click="open = !open">
          <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
        </button>
        <div>{{ $emp->company_name }} ({{ $emp->email }})</div>
        <div class="space-x-2">
          <form method="POST" action="{{ route('admin.employer.verify',$emp->id) }}">@csrf
            <button class="bg-green-600 text-white px-2 py-1 rounded">Verify</button>
          </form>
          <form method="POST" action="{{ route('admin.employer.reject',$emp->id) }}">@csrf
            <button class="bg-red-600 text-white px-2 py-1 rounded">Reject</button>
          </form>
        </div>
      </div>
      <div x-show="open" class="mt-2 text-sm text-gray-700">
        Registered: {{ $emp->created_at->format('M j, Y') }}<br>
        Phone: {{ $emp->phone ?? '—' }}
      </div>
    </div>
  @endforeach
@endsection
