@extends('layouts.base')

@section('title', 'メール送信フォーム')

@section('main')
	<div class="mx-auto" style="width: 300px">
		{{-- 送信成功メッセージ表示 --}}
		@if (session('successMessage'))
			<div class="alert alert-success text-center">
				{{ session('successMessage') }}
			</div>
		@endif

		<div class="mt-5 mb-5">
			フォームに入力されたメールアドレス宛にmail@miyamoto.tenshoku.siteからメールが送信されます
		</div>

		{{-- エラーメッセージ表示 --}}
		@if($errors->any())
			<ul>
				@foreach ($errors->all() as $err)
					<li class="text-danger">{{ $err }}</li>
				@endforeach
			</ul>
		@endif

		<form action="" method="post">
			@csrf

			<div class="form-floating mb-3">
				<input type="email" name="email" class="form-control"
					id="floatingInput" placeholder="name@example.com">
				<label for="floatingInput">email</label>
			</div>

			<div class="mb-3">
				{!! no_captcha()->display() !!}
			</div>

			<div class="text-center">
				<button type="submit" class="btn btn-primary">メール送信</button>
			</div>
		</form>
	</div>
	{!! no_captcha()->script() !!}
@endsection
