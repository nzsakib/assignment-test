<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of users</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-200">
    <div class="container">
        <h1 class="text-4xl font-bold">Top Secret CIA Database</h1>

        <div class="search">
            <form action="" method="GET">
                <div class="input-field">
                    <label for="year">Birth year</label>
                    <input type="text" placeholder="1955" name="year" class="" id="year">
                </div>
                <div class="input-field">
                    <label for="month">Birth month</label>
                    <input type="text" placeholder="12" name="month" class="" id="month">
                </div>

                <button type="submit" class="">Filter</button>
            </form>
        </div> <!-- end search -->

        <div class="table-data">
            <div class="meta">
                <span class="font-bold">{{ $data->perPage() }} people in the list</span>
                <a href="" class=""><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                {{ $data->firstItem() }}- {{ $data->lastItem() }} of {{ $data->total() }}
                <a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <table>
                <tr>
                    <th>Email</th>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Birthday</th>
                    <th>IP</th>
                    <th>Phone</th>
                    <th>Country</th>
                </tr>

                @foreach ($data as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->birthday }}</td>
                    <td>{{ $user->ip }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->country }}</td>
                </tr>
                @endforeach
            </table>
            <div class="meta">
                <span class="font-bold">60 people in the list</span>
                <a href="" class=""><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                20-40 of 148
                <a href=""><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div> <!-- end table-data -->
    </div> <!-- end container -->
</body>
</html>