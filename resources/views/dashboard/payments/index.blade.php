@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Metode <span
                        class="text-brand-neon">Pembayaran</span></h1>
                <p class="text-gray-500 font-medium mt-1">Kelola bank, e-wallet, dan QRIS untuk pembayaran.</p>
            </div>
            <a href="{{ route('dashboard.payments.create') }}"
                class="btn-metal py-3 px-8 rounded-xl font-black uppercase tracking-widest text-[10px] flex items-center gap-3 w-fit md:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Metode
            </a>
        </div>

        <!-- Payment Methods Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($payments as $payment)
                <div class="stat-card group relative overflow-hidden">
                    <!-- Type Badge -->
                    <div class="absolute top-4 right-4">
                        <span
                            class="text-[9px] font-black uppercase tracking-widest px-2 py-1 bg-white/5 rounded-md text-gray-500 border border-white/5">
                            {{ $payment->type }}
                        </span>
                    </div>

                    <div class="flex items-start gap-5">
                        <div
                            class="w-14 h-14 rounded-xl bg-white/[0.03] border border-white/5 flex items-center justify-center overflow-hidden">
                            @if($payment->image)
                                <img src="{{ asset('storage/' . $payment->image) }}" class="w-full h-full object-contain">
                            @else
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-white truncate">{{ $payment->name }}</h3>
                            <p class="text-xs text-gray-500 font-medium truncate">
                                @if($payment->type === 'bank' && $payment->bank_name)
                                    {{ $payment->bank_name }} ({{ $payment->bank_code }}) - 
                                @endif
                                {{ $payment->account_number ?? $payment->code }}</p>
                            <p class="text-[10px] text-gray-600 truncate mt-1 ">
                                {{ $payment->account_name ?? 'Digital System' }}</p>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-between border-t border-white/5 pt-6">
                        <!-- Status Toggle -->
                        <label class="switch">
                            <input type="checkbox" 
                                class="status-toggle"
                                data-id="{{ $payment->id }}"
                                onchange="togglePaymentStatus(this)" 
                                {{ $payment->is_active ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>

                        <script>
                        async function togglePaymentStatus(checkbox) {
                            const id = checkbox.dataset.id;
                            const originalState = !checkbox.checked;
                            
                            try {
                                const response = await fetch(`/dashboard/payments/${id}/toggle-status`, {
                                    method: 'PATCH',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                });

                                const data = await response.json();

                                if (!response.ok) {
                                    throw new Error(data.message || 'Gagal mengubah status');
                                }

                                showToast(data.message);

                            } catch (error) {
                                checkbox.checked = originalState;
                                showToast(error.message, 'error');
                            }
                        }
                        </script>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard.payments.edit', $payment) }}"
                                class="p-2 bg-white/5 rounded-lg text-gray-400 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('dashboard.payments.destroy', $payment) }}" method="POST"
                                onsubmit="return confirm('Hapus metode ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-2 bg-white/5 rounded-lg text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center stat-card border-dashed">
                    <p class="text-gray-500 ">Belum ada metode pembayaran.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <div class="stat-card !p-0 overflow-hidden">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection