@extends('base')

@section('title')

<a href="{{ route('listing.student-list') }}">Students Dashboard</a>

@endsection



@section('student_infos')

<div class="list-container">
    <table id="student-list">
        <thead>
            <tr>
            <th>Nom Complet</th>
            <th>Id</th>
            <th>Age</th>
            <th>Genre</th>
            <th>Niveau</th>
            <th>Ville</th>
            <th>Université</th>
            <th>Frais</th>
            </tr>
        </thead>
        <tbody id="studentsBody">
            @foreach($students as $student)
            <tr>
            <td>{{ $student->first_name ?? '' }}{{ $student->last_name ?? '' }}</td>
            <td>{{ $student->id ?? '' }}</td>
            <td>19</td>
            <td>{{ $student->gender ?? '' }}</td>
            <td>{{ $student->level ?? '' }}</td>
            <td>{{ $student->city ?? '' }}</td>
            <td>{{ $student->university ?? '' }}</td>
            <td><span class="badge-paid">{{ $student->status ?? '' }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection