@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black  uppercase tracking-tight text-white">Semua <span class="text-brand-neon">Pesanan</span></h1>
            <p class="text-gray-500 font-medium mt-1">Daftar seluruh transaksi yang masuk ke Ventuz Store.</p>
        </div>
        <div class="text-sm text-gray-500 font-medium">
            Total: <span class="text-white font-black">{{ $orders->total() }}</span> transaksi
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('dashboard.orders') }}" class="flex flex-col md:flex-row gap-3">
        <!-- Search -->
        <div class="relative flex-1">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-neon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari invoice, game, atau metode bayar..."
                class="w-full bg-white/[0.03] border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm font-medium focus:outline-none focus:border-brand-neon/50 transition-all">
        </div>
        <!-- Status Filter -->
        <select name="status" onchange="this.form.submit()"
            class="bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-sm font-bold focus:outline-none focus:border-brand-neon/50 transition-all text-white appearance-none cursor-pointer min-w-[160px]">
            <option value="">Semua Status</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>⏳ Pending</option>
            <option value="verif"    {{ request('status') === 'verif'    ? 'selected' : '' }}>🔍 Verifikasi</option>
            <option value="success"  {{ request('status') === 'success'  ? 'selected' : '' }}>✅ Success</option>
            <option value="failed"   {{ request('status') === 'failed'   ? 'selected' : '' }}>❌ Failed</option>
        </select>
        <!-- Search Button -->
        <button type="submit" class="btn-metal px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Cari</button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('dashboard.orders') }}" class="px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors whitespace-nowrap flex items-center">Reset</a>
        @endif
    </form>

    <!-- Table Card -->
    <div class="stat-card overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Invoice</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Game / Produk</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Harga</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Bukti</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Status</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($orders as $order)
                        <tr x-data="{ 
                            deliveryStatus: '{{ $order->delivery_status }}',
                            paymentStatus: '{{ $order->payment_status }}',
                            isLoading: false,
                            async updateStatus(newStatus) {
                                if(!confirm(newStatus === 'success' ? 'Tandai pesanan ini sebagai SUCCESS dan PAID?' : 'Tandai pesanan ini sebagai FAILED/BATAL?')) return;
                                
                                this.isLoading = true;
                                try {
                                    const response = await fetch('{{ route('dashboard.orders.update-status', $order) }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            _method: 'PATCH',
                                            status: newStatus
                                        })
                                    });
                                    const data = await response.json();
                                    if(response.ok) {
                                        this.deliveryStatus = newStatus;
                                        this.paymentStatus = newStatus === 'success' ? 'paid' : 'failed';
                                    } else {
                                        alert(data.message || 'Terjadi kesalahan!');
                                    }
                                } catch (error) {
                                    alert('Terjadi kesalahan jaringan.');
                                }
                                this.isLoading = false;
                            }
                        }" class="hover:bg-white/[0.01] transition-colors" :class="{ 'opacity-50 pointer-events-none': isLoading }">
                            <td class="p-6">
                                <div class="font-bold text-white">{{ $order->order_id }}</div>
                                <div class="text-[10px] text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="p-6">
                                <div class="font-bold text-white">{{ $order->game_name ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $order->variant_name ?? '-' }}</div>
                            </td>
                            <td class="p-6 font-mono text-sm font-bold text-white">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                <div class="text-[10px] text-gray-500 font-sans font-normal mt-1">{{ $order->payment_method ?? '-' }}</div>
                            </td>
                            <td class="p-6">
                                @if($order->proof_of_payment)
                                    <a href="{{ asset('storage/' . $order->proof_of_payment) }}" target="_blank" class="block w-12 h-12 rounded-lg overflow-hidden border border-white/10 hover:border-brand-neon/50 transition-colors group relative">
                                        <img src="{{ asset('storage/' . $order->proof_of_payment) }}" class="w-full h-full object-cover" alt="Bukti Pembayaran">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </div>
                                    </a>
                                @else
                                    <span class="text-xs text-gray-600 ">Belum ada</span>
                                @endif
                            </td>
                            <td class="p-6">
                                <template x-if="deliveryStatus === 'success'">
                                    <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase tracking-widest border border-emerald-500/20">SUCCESS</span>
                                </template>
                                <template x-if="deliveryStatus === 'failed' || paymentStatus === 'failed'">
                                    <span class="px-3 py-1 rounded-full bg-red-500/10 text-red-500 text-[10px] font-black uppercase tracking-widest border border-red-500/20">FAILED</span>
                                </template>
                                <template x-if="deliveryStatus !== 'success' && deliveryStatus !== 'failed' && paymentStatus === 'paid'">
                                    <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-500 text-[10px] font-black uppercase tracking-widest border border-blue-500/20">PROCESSING</span>
                                </template>
                                <template x-if="deliveryStatus !== 'success' && deliveryStatus !== 'failed' && paymentStatus === 'verif'">
                                    <span class="px-3 py-1 rounded-full bg-brand-neon/10 text-brand-neon text-[10px] font-black uppercase tracking-widest border border-brand-neon/20">VERIFY</span>
                                </template>
                                <template x-if="deliveryStatus !== 'success' && deliveryStatus !== 'failed' && paymentStatus !== 'paid' && paymentStatus !== 'failed' && paymentStatus !== 'verif'">
                                    <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-500 text-[10px] font-black uppercase tracking-widest border border-amber-500/20">PENDING</span>
                                </template>
                            </td>
                            <td class="p-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <template x-if="deliveryStatus !== 'success' && deliveryStatus !== 'failed'">
                                        <div class="flex items-center gap-2">
                                            <button @click="updateStatus('success')" :class="{ 'btn-loading': isLoading }" :disabled="isLoading" type="button" class="p-2 bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white rounded-lg transition-colors" title="Tandai Sukses">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                            <button @click="updateStatus('failed')" :class="{ 'btn-loading': isLoading }" :disabled="isLoading" type="button" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-colors" title="Tandai Batal">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </template>
                                    <template x-if="deliveryStatus === 'success' || deliveryStatus === 'failed'">
                                        <span class="text-xs text-gray-500 font-bold " x-text="deliveryStatus.toUpperCase()"></span>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-600 font-medium ">Belum ada transaksi yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        {{ $orders->links() }}
    </div>
</div>
@endsection
