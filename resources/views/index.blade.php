<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invillia API</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-top sm:pt-0">

        <div class="container-form max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1>Import XML</h1>

            <form action="{{ action('IndexController@upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="text-lg leading-7 font-semibold">Upload XML</div>
                            </div>
                            <div>
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    <input type="file" name="xml" id="xml" class="input-file" accept="text/xml">
                                </div>
                            </div>
                            <br>
                            <div>
                                <div class="text-gray-600 dark:text-gray-400 text-sm">
                                    <button type="submit" class="btn fill mt-2">
                                        PROCESS
                                    </button>
                                </div>
                            </div>
                            @if (session('error'))
                            <div class="mt-2 alert alert-warning">

                                @if (session('title'))
                                <div class="title">
                                    <img src="{{ asset('images/warning.svg') }}" class="icon" alt="warning">
                                    {{ session('title') }}
                                </div>
                                @endif
                                <span class="message">{{ session('error') }}</span>
                            </div>
                            @endif

                            @if (session('info'))
                            <div class="mt-2 alert alert-info">
                                @if (session('title'))
                                <div class="title">
                                    <img src="{{ asset('images/info.svg') }}" class="icon" alt="info">
                                    {{ session('title') }}
                                </div>
                                @endif

                                <span class="message">{{ session('info') }}</span>
                            </div>
                            @endif

                            @if (session('success'))
                            <div class="mt-2 alert alert-success">
                                @if (session('title'))
                                <div class="title">
                                    <img src="{{ asset('images/success.svg') }}" class="icon" alt="success">
                                    {{ session('title') }}
                                </div>
                                @endif
                                <div class="message">{!! session('success') !!}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </div>
</body>

</html>