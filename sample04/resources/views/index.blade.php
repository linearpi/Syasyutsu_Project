<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        /* Your custom CSS styles go here */
    </style>
</head>
<body>
    <div class="container">
        <table class="rwd-table">
            <thead>
                <th colspan="8">
                    <a href="{{ route('export') }}" class="btn btn-success">Export CSV</a>
                </th>
            </thead>
            <tbody>
                <tr>
                <th>first name</th>
                <th>last name</th>
                <th>email</th>
                <th>phone no.</th>
                <th>date of birth</th>
                <th>gender</th>
                <th>skills</th>
                <th>basic salary</th>
                </tr>
                
                @foreach ($employees as $list)
                <tr>
                    <td>{{ $list->first_name }}</td>
                    <td>{{ $list->last_name }}</td>
                    <td>{{ $list->email }}</td>
                    <td>{{ $list->phone }}</td>
                    <td>{{ $list->date_of_birth }}</td>
                    <td>{{ $list->gender }}</td>
                    <td>
                        <ul>
                            @foreach (json_decode($list->skills) as $skills)
                                <li>
                                    {{ $skills }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $list->basic_salary }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>