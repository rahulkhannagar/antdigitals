<h1>{{$empName->first_name}} {{$empName->last_name}} Attendance</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Attendance</th>
                <th>Applied</th>                
            </tr>
        </thead>
    <tbody>
        @foreach($reportData['attendance'] as $attendance)
            <tr>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->day }}</td>
                <td>{{ $attendance->absent_present }}</td>
                <td>{{ $attendance->leave_applied }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

<table style="    width: 100%;">
    <tr>
        <td>
            <h3>Leave Summary Sandwich system cases:- </h3>
            <h4>Absent Days:</h4>
            <p>{{$reportData['absent_days']}}</p>
            <h4>Leave Without Pay (LWP) Days:</h4>
            <p>{{ $reportData['lwp_days'] }} days</p>
        </td>
        <td>
            <h3>Leave Summary Without sandwich system:- </h3>
            <h4>Absent Days:</h4>
            <p>{{$daysLeave10['absent_days']}}</p>
            <h4>Leave Without Pay (LWP) Days:</h4>
            <p>{{ $daysLeave10['lwp_days'] }} days</p>
        </td>
    </tr>
</table>
