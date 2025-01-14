<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widgets</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Widgets List</h1>
        <a href="{{ route('widgets.create') }}" class="btn btn-primary">Create New Widget</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($widgets as $widget)
                    <tr>
                        <td>{{ $widget->id }}</td>
                        <td>{{ $widget->name }}</td>
                        <td>{{ $widget->description }}</td>
                        <td>
                            <a href="{{ route('widgets.edit', $widget->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('widgets.destroy', $widget->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>