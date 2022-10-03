<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Short URL</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <form method="POST" action="/">
                <div class="input-group rounded">
                    @csrf
                    <input type="text" name="link" class="form-control" placeholder="Enter URL">
                    <input type="submit" class="btn btn-success" value="Send URL">
                </div>
            </form>
            <h1 class="mt-5"> URL List</h1>
            @if (Session::has('success'))
            <div class="alert alert-success">
                <p>{{ Session::get('success') }}</p>
            </div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger">
                <p>{{ Session::get('error') }}</p>
            </div>
            @endif
            <table class="table ">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Short link</th>
                        <th scope="col">Original</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Date Delete</th>
                        <th scope="col">Statistik click</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($shortLinks ?? '' as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td><a href="{{ route('shorten.link', $row->code) }}"
                                target="_blank">{{ route('shorten.link', $row->code) }}</a></td>
                        <td>{{ $row->link }}</td>
                        <td> {{ date('G:i F d', strtotime($row->created_at))}}</td>
                        <td > {{ date('G:i F d', strtotime($row->date_del))}} </td>

                        <td class="text-center">{{ $row->stats }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>

</body>

</html>
