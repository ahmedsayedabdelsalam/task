<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Phrase Analyser</title>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        .red {
            color: red
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Phrase Analyser</h1>

        <!-- start input section -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="phrase-analyser">
                    @csrf
                    <div class="form-group">
                        <label for="phrase">Phrase</label>
                        <input type="test" name="phrase" class="form-control @error('phrase') is-invalid @enderror" id="phrase" aria-describedby="phraseHelp" required maxlength="255">
                        @error('phrase')
                        <small id="phraseHelp" class="form-text red">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <!-- end input section -->

        <!-- start output section -->
        @if(session('output'))
        <div class="mt-3">
            @foreach(session('output') as $item)
            <div class="alert alert-success" role="alert">
                {{$item['symbol']}}
                <span class="red">:</span>
                {{$item['count']}}
                <span class="red">:</span>
                before: {{$item['before']}} : after: {{$item['after']}}
                @if ($item['count'] > 1) max-distance: 10 chars @endif
            </div>
            @endforeach
        </div>
        @endif
        <!-- end output section -->
    </div>
</body>

</html>