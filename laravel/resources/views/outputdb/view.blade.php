@extends('layouts.base')

@section('title', 'データベース出力')

@section('main')
	<div class="table-responsive overflow-auto" style="height: 100%;">
		<table class="table text-nowrap table-striped">
			<thead class="sticky-top table-secondary">
				<tr>
					<th>名前</th>
					<th>ふりがな</th>
					<th>性別</th>
					<th>年齢</th>
					<th>誕生日</th>
					<th>メールアドレス</th>
					<th>血液型</th>
				</tr>
			</thead>
			<tbody>
				@foreach($records as $record)
					<tr>
						<td>{{ $record->name }}</td>
						<td>{{ $record->furigana }}</td>
						<td>{{ $record->sex_name }}</td>
						<td>{{ $record->age }}</td>
						<td>{{ $record->birthday }}</td>
						<td>{{ $record->email }}</td>
						<td>{{ $record->blood }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection
