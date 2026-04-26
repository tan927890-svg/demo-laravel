@extends('layouts.admin')

@section('page-title', 'Chi tiết lợi nhuận — ' . $car->name)

@section('content')

<div style="margin-bottom:16px">
    <a href="{{ route('admin.profit.index') }}" class="btn btn-sm">← Quay lại</a>
</div>

{{-- Header xe --}}
<div class="card card-pad" style="margin-bottom:16px;display:flex;align-items:center;gap:16px">
    @if($car->main_image)
    <img src="{{ asset($car->main_image) }}" style="width:80px;height:60px;object-fit:cover;border-radius:10px;border:1px solid var(--border)">
    @endif
    <div>
        <div style="font-size:20px;font-weight:800">{{ $car->name }}</div>
        <div style="font-size:13px;color:var(--text-3)">{{ $car->brand?->name }} &middot; {{ $car->model }}</div>
    </div>
    @php $s = $car->status_label; @endphp
    <span class="badge badge-{{ $s['color'] === 'green' ? 'green' : ($s['color'] === 'red' ? 'red' : 'amber') }}" style="margin-left:auto">{{ $s['label'] }}</span>
</div>

{{-- Stat cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px">
    <div class="stat-card">
        <div class="stat-label">Giá nhập</div>
        <div class="stat-val" style="font-size:20px">
            {{ $car->cost_price ? number_format($car->cost_price,0,',','.') . ' ₫' : '—' }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Tổng chi phí</div>
        <div class="stat-val" style="font-size:20px">
            {{ $totalCost > 0 ? number_format($totalCost,0,',','.') . ' ₫' : '—' }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Giá bán</div>
        <div class="stat-val" style="font-size:20px">
            {{ $revenue > 0 ? number_format($revenue,0,',','.') . ' ₫' : '—' }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Lợi nhuận / Biên</div>
        <div class="stat-val" style="font-size:20px;color:{{ $profit >= 0 ? 'var(--success)' : 'var(--danger)' }}">
            {{ $revenue > 0 && $totalCost > 0 ? ($profit >= 0 ? '+' : '') . number_format($profit,0,',','.') . ' ₫' : '—' }}
        </div>
        @if($revenue > 0 && $totalCost > 0)
        <div class="stat-sub">Biên: {{ $margin }}%</div>
        @endif
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

    {{-- Chi phí phát sinh --}}
    <div class="card card-pad">
        <div class="section-header">
            <div class="section-title">Bảng chi phí</div>
            <button class="btn btn-sm" onclick="history.back()">Chỉnh sửa</button>
        </div>

        @if($car->expenses->count() > 0 || $car->cost_price > 0)
        <table>
            <thead>
                <tr>
                    <th>Khoản</th>
                    <th style="text-align:right">Số tiền</th>
                </tr>
            </thead>
            <tbody>
                @php $costPrice = (float)($car->cost_price ?? 0); @endphp
                @if($costPrice > 0)
                <tr>
                    <td><span class="badge badge-blue">Giá nhập xe</span></td>
                    <td style="text-align:right;font-weight:600">{{ number_format($costPrice,0,',','.') }} ₫</td>
                </tr>
                @endif
                @foreach($car->expenses as $exp)
                <tr>
                    <td>{{ $exp->name }}</td>
                    <td style="text-align:right">{{ number_format($exp->amount,0,',','.') }} ₫</td>
                </tr>
                @endforeach
                <tr style="border-top:2px solid var(--border)">
                    <td style="font-weight:800">Tổng chi phí</td>
                    <td style="text-align:right;font-weight:800">{{ number_format($totalCost,0,',','.') }} ₫</td>
                </tr>
                @if($revenue > 0)
                <tr>
                    <td style="color:var(--text-2)">Giá bán</td>
                    <td style="text-align:right;color:var(--text-2)">{{ number_format($revenue,0,',','.') }} ₫</td>
                </tr>
                <tr style="border-top:2px solid var(--border)">
                    <td style="font-weight:800;color:{{ $profit >= 0 ? 'var(--success)' : 'var(--danger)' }}">Lợi nhuận</td>
                    <td style="text-align:right;font-weight:800;color:{{ $profit >= 0 ? 'var(--success)' : 'var(--danger)' }}">
                        {{ ($profit >= 0 ? '+' : '') . number_format($profit,0,',','.') }} ₫
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        @else
            <p style="color:var(--text-3);font-size:13px">Chưa nhập chi phí nào.</p>
        @endif
    </div>

    {{-- Thông tin xe --}}
    <div class="card card-pad">
        <div class="section-header">
            <div class="section-title">Thông tin xe</div>
            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm">Chỉnh sửa xe</a>
        </div>
        <table>
            <tbody>
                <tr>
                    <td style="color:var(--text-2);font-size:13px">Thương hiệu</td>
                    <td style="font-weight:600">{{ $car->brand?->name ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-2);font-size:13px">Model</td>
                    <td>{{ $car->model ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-2);font-size:13px">Màu sắc</td>
                    <td>{{ $car->color ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-2);font-size:13px">Nhiên liệu</td>
                    <td>{{ $car->fuel_type ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-2);font-size:13px">Số ghế</td>
                    <td>{{ $car->seats ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--text-2);font-size:13px">Trạng thái</td>
                    <td>
                        @php $s = $car->status_label; @endphp
                        <span class="badge badge-{{ $s['color'] === 'green' ? 'green' : ($s['color'] === 'red' ? 'red' : 'amber') }}">{{ $s['label'] }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection