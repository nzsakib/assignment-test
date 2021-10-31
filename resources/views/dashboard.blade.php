<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of users</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-200">
    <div class="container">
        <h1 class="text-4xl font-bold">Top Secret CIA Database</h1>

        <div class="search">
            <form action="/" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="year" class="form-label">Birth year</label>
                    <input type="text" placeholder="1955" name="year" class="form-control" id="year">
                </div>
                <div class="col-md-3">
                    <label for="month" class="form-label">Birth month</label>
                    <input type="text" placeholder="12" name="month" class="form-control" id="month">
                </div>

                <div class="col-md-3 mt-5">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div> <!-- end search -->

        <div class="table-data border border-2 border-light mt-3">
            <div class="row p-3">
                <div class="col-md-9">
                    <div class="float-end me-5">
                        <span class="fw-bold">{{ $data->perPage() }} people in the list</span>
                    </div>
                </div>
                <div class="col-md-3">
                    @unless ($data->onFirstPage())
                    <a href="{{ $data->appends(request()->all())->previousPageUrl() }}" class="btn btn-sm btn-secondary me-3"><i
                            class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    @endunless
                    <span class="fw-bold">{{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }}</span>
                    @if ($data->hasMorePages())
                    <a href="{{ $data->appends(request()->all())->nextPageUrl() }}" class="btn btn-sm btn-secondary ms-3"><i class="fa fa-arrow-right"
                            aria-hidden="true"></i></a>
                    @endif
                </div>
            </div> <!-- meta info -->
            <table class="table">
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
                    <td>{{ $user->email }} <span class="float-end"><i class="fa fa-angle-right" aria-hidden="true"></i></span></td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->birthday }}</td>
                    <td>{{ $user->ip }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->country }}</td>
                </tr>
                @endforeach
            </table>
            <div class="row p-3">
                <div class="col-md-9">
                    <div class="float-end me-5">
                        <span class="fw-bold">{{ $data->perPage() }} people in the list</span>
                    </div>
                </div>
                <div class="col-md-3">
                    @unless ($data->onFirstPage())
                    <a href="{{ $data->appends(request()->all())->previousPageUrl() }}" class="btn btn-sm btn-secondary me-3"><i
                            class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    @endunless
                    <span class="fw-bold">{{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }}</span>
                    @if ($data->hasMorePages())
                    <a href="{{ $data->appends(request()->all())->nextPageUrl() }}" class="btn btn-sm btn-secondary ms-3"><i class="fa fa-arrow-right"
                            aria-hidden="true"></i></a>
                    @endif
                </div>
            </div> <!-- meta info -->
        </div> <!-- end table-data -->
    </div> <!-- end container -->
</body>

</html>