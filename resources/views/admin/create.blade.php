@extends('layouts.admin.app')

@section('content')
<div class="section-top">
  <h1 class="section-top-title">〜 投稿の新規作成 〜</h1>
</div>
  <div class="center-width">
    <form action="{{ route('admin.posts.store') }}" method="POST" class="post-item">
      @csrf
      <div class="add-title">
        <p>タイトル</p>
        <input type="text" id="title" value="{{ old('title') }}" name="title">
        @if ($errors->has('title'))
          <p class="error">{{ $errors->first('title') }}</p>
        @endif
      </div>
      <div>
        <p>本文</p>
        <textarea name="body" id="body" rows="4" value="{{ old('body') }}"></textarea>
        @if ($errors->has('body'))
          <p class="error">{{ $errors->first('body') }}</p>
        @endif
      </div>
      <button type="submit" class="btn">投稿</button>
      <a href="{{ route('admin.posts') }}" class="link">キャンセル</a>
    </form>
  </div>
@endsection