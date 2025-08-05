@extends('layouts.landing.app')

@section('title', 'Riwayat Pesanan - Etukang')

@section('content')
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200 bg-white">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900">Riwayat Pesanan</h1>
            <span class="text-sm text-gray-500">{{ $transactions->count() }} pesanan</span>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="px-4 py-4">
        @forelse($transactions as $transaction)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 overflow-hidden">
            <div class="p-4">
                <!-- Transaction Header -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-tools text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm">{{ $transaction->merchant->name }}</h3>
                            <p class="text-gray-500 text-xs">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ getStatusClass($transaction->status) }}">
                        {{ getStatusText($transaction->status) }}
                    </span>
                </div>

                <!-- Transaction Details -->
                <div class="space-y-2 text-sm">
                    @foreach($transaction->transactionDetail as $detail)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ $detail->product->name }}</span>
                        <span class="font-medium">Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                    </div>
                    @endforeach

                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="font-bold text-green-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                @if($transaction->payment)
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500">Payment Code:</span>
                        <span class="font-medium">{{ $transaction->payment->code }}</span>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-4 flex space-x-2">
                    <button onclick="viewTransactionDetail({{ $transaction->id }})"
                            class="flex-1 bg-gray-100 text-gray-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                        <i class="fas fa-eye mr-1"></i>
                        Detail
                    </button>
                    @if($transaction->status === 'pending')
                    <button onclick="cancelTransaction({{ $transaction->id }})"
                            class="flex-1 bg-red-100 text-red-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-receipt text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mb-6">Anda belum memiliki riwayat pesanan</p>
            <a href="{{ route('welcome') }}"
               class="bg-green-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors inline-flex items-center">
                <i class="fas fa-tools mr-2"></i>
                Pesan Teknisi
            </a>
        </div>
        @endforelse
    </div>

    @include('layouts.landing.footer')
@endsection

@php
function getStatusClass($status) {
    switch($status) {
        case 'pending': return 'bg-yellow-100 text-yellow-800';
        case 'confirmed': return 'bg-green-100 text-green-800';
        case 'cancelled': return 'bg-red-100 text-red-800';
        case 'completed': return 'bg-blue-100 text-blue-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

function getStatusText($status) {
    switch($status) {
        case 'pending': return 'Menunggu';
        case 'confirmed': return 'Dikonfirmasi';
        case 'cancelled': return 'Dibatalkan';
        case 'completed': return 'Selesai';
        default: return 'Menunggu';
    }
}
@endphp
