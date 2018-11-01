<h1>Users</h1>

<table class="table">
	<tr>
		<th>User Id</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Status</th>
	</tr>

	@foreach($users as $user)
	<tr>
	<td>{{$user->id}}</td>
	<td>{{$user->firstname}}</td>
	<td>{{$user->lastname}}</td>
	<td>{{$user->email}}</td>
	<td>@if($user->status==1)Active @else Inactive @endif</td>
	
	</tr>
	@endforeach


</table>
<style type="text/css">
	table,th,td{
		border:1px solid;

	}
	th,td{
		width:100%;
	}
</style>