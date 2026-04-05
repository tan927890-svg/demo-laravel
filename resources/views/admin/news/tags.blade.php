{{-- resources/views/admin/news/tags.blade.php --}}
@extends('layouts.admin')

@section('title', 'Quản Lý Tags')

@section('content')
<div style="padding:32px;max-width:700px">

  <div style="margin-bottom:24px">
    <a href="{{ route('admin.news.index') }}"
       style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#555;text-decoration:none;display:inline-flex;align-items:center;gap:6px;margin-bottom:10px">
      ← QUAY LẠI
    </a>
    <h1 style="font-family:'Bebas Neue';font-size:32px;letter-spacing:2px;color:#f0ebe4">TAGS TIN TỨC</h1>
  </div>

  @if(session('success'))
    <div style="background:rgba(232,25,44,.1);border:1px solid rgba(232,25,44,.3);color:#f0ebe4;padding:12px 16px;font-size:13px;margin-bottom:20px">
      {{ session('success') }}
    </div>
  @endif

  <div style="background:#111;border:1px solid #1c1c1c;padding:24px;margin-bottom:24px">
    <div style="font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#555;margin-bottom:16px">THÊM TAG MỚI</div>
    <form method="POST" action="{{ route('admin.news.tags.store') }}">
      @csrf
      <div style="display:flex;gap:10px">
        <input type="text" name="name"
               placeholder="Tên tag (vd: BMW)"
               style="flex:1;background:#141414;border:1px solid #2a2a2a;color:#f0ebe4;padding:11px 16px;font-size:13px;font-family:'Barlow',sans-serif;outline:none">
        <button type="submit"
                style="background:#E8192C;color:#fff;border:none;padding:11px 20px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;cursor:pointer;font-family:'Barlow',sans-serif">
          THÊM
        </button>
      </div>
      @error('name') <div style="font-size:11px;color:#E8192C;margin-top:6px">{{ $message }}</div> @enderror
    </form>
  </div>

  <div style="background:#111;border:1px solid #1c1c1c;overflow:hidden">
    <table style="width:100%;border-collapse:collapse">
      <thead>
        <tr style="background:#141414;border-bottom:1px solid #1c1c1c">
          <th style="padding:12px 20px;text-align:left;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">TÊN</th>
          <th style="padding:12px 20px;text-align:left;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">SLUG</th>
          <th style="padding:12px 20px;text-align:center;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">BÀI VIẾT</th>
          <th style="padding:12px 20px;text-align:center;font-size:10px;font-weight:700;letter-spacing:2px;color:#555;text-transform:uppercase">XÓA</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tags as $tag)
        <tr style="border-bottom:1px solid #1a1a1a">
          <td style="padding:14px 20px;font-size:13px;color:#f0ebe4">{{ $tag->name }}</td>
          <td style="padding:14px 20px;font-size:12px;color:#555">{{ $tag->slug }}</td>
          <td style="padding:14px 20px;text-align:center;font-size:13px;color:#888">{{ $tag->news_count }}</td>
          <td style="padding:14px 20px;text-align:center">
            <form method="POST" action="{{ route('admin.news.tags.destroy', $tag) }}"
                  onsubmit="return confirm('Xóa tag này?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      style="background:transparent;border:1px solid #2a2a2a;color:#555;padding:5px 12px;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;font-family:'Barlow',sans-serif"
                      onmouseover="this.style.color='#E8192C';this.style.borderColor='#E8192C'"
                      onmouseout="this.style.color='#555';this.style.borderColor='#2a2a2a'">
                XÓA
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>
@endsection