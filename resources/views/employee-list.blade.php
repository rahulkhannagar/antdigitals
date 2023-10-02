<h1>Employee List</h1>

    <table class="table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
    <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->first_name }}</td>
                <td>{{ $employee->last_name }}</td>
                <td>{{ $employee->email }}</td>
                <td><a href="{{ route('leave-report', ['emp_id' => $employee->id]) }}"> details</a> </td>
            </tr>
        @endforeach
        </tbody>
    </table>