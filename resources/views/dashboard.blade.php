<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>File Browser (Vue.js Edition)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="{{asset('dropbox/css/style.css')}}">
      <link rel="stylesheet" href="{{asset('css/style.css')}}">


</head>

<body>
    @if(Session::has('message'))
        <div class="custom-flash {{ Session::get('message')['class'] }}">{{ Session::get('message')['value'] }}</div>
    @endif

  <div class="ui upload-drop" id="app">
    <aside class="ui__sidebar">

        <!-- <input type="text" @keyup.enter="addItem"> -->
        <input type="text">

        <ul class="file-tree">
        @foreach($data['directories'] as $folder)
            <li class="file-tree__item">
                {{-- <div class="folder">{{ json_encode(str_replace('/', '_', $folder)) }}<i class="fa fa-trash"></i></div> --}}
                <a class="folder" href="/folders/{{$folder['path']}}">{{$folder['name']}}</a> <a class="delete" href="/folders/delete/{{$folder['path']}}"> <i class="fa fa-trash"></i></a>
            </li>
        </ul>
        @endforeach
        <!-- /.file-tree -->

    </aside>
    <!-- /.sidebar -->

    <main class="ui__main">

        <div class="ui__menu">

            <a href="javascript:void(0);" class="ui__btn sidebar-toggle"></a>
            <a href="javascript:void(0);" data-modal="upload-modal" class="ui__btn upload-btn"></a>

            <ul class="file-path">
                @if(count($data['current']))
                    @foreach($data['current'] as $key => $path)
                        <li><a href='{{$key}}'>{{ $path }}</a></li>
                    @endforeach
                @else
                    <li><a href="/folders">public</a></li>
                @endif
            </ul>
            <!-- /.file-path -->

            <div class="ui__dropdown ui__btn options-toggle ">
                <a href="javascript:void(0);" class="ui__dropbtn"></a>
                <div class="ui__dropbtn-content">
                  <a href="javascript:void(0)" data-modal="create-folder-modal">Create new folder</a>
                </div>
            </div>
            <a href="javascript:void(0);" class="ui__btn help-btn" data-overlay="help"></a>

        </div>
        <!-- /.ui__menu -->

        <div class="ui__info info-modal" id="create-folder-modal">
            <h2>Add new folder</h2>
            {{-- <p>Simply drag & drop a file here or select one with the button below.</p> --}}
            <form action="/folders/{{$data['path']}}" method="POST">
                <div><input type="text" name="name" id="name" required></div>
                <button type="submit" class="btn">Create</button>
                {{ csrf_field() }}
            </form>

        </div>

        <div class="ui__info info-modal" id="upload-modal">
            <h2>Upload</h2>
            <p>Simply drag & drop a file here or select one with the button below.</p>
            <form action="/files/upload/{{$data['path']}}" enctype="multipart/form-data" method="POST">
                <div><input type="file" name="file" id="file" required></div>
                <button type="submit" class="btn">Upload</button>
                {{ csrf_field() }}
            </form>

        </div>
        <!-- /.ui__info -->

        <table class="file-list" id="file-table">

            <tr class="file-list__header">
                <th onClick="sortTable(0)">Name <i class="fa fa-long-arrow-down"></i></th>
                <th onClick="sortTable(1)">Type</th>
                <th onClick="sortTable(2, '123')">Size</th>
                <th>Download</th>
                <th>Delete</th>
            </tr>
            @foreach($data['folders'] as $folder)
                <tr class="file-list__file">
                    <td><a class="folder folder-in-folder" href="/folders/{{$folder['path']}}">{{$folder['name']}}</a></td>
                    <td>{{$folder['type']}}</td>
                    <td>{{$folder['size']}}</td>
                    <td><a href="/download/folders/{{$folder['path']}}" class="ui__btn download"></a></td>
                    <td><a class="delete" href="/folders/delete/{{$folder['path']}}"> <i class="fa fa-trash"></i></a></td>
                </tr>
            @endforeach

            @foreach($data['files'] as $file)
                <tr class="file-list__file">
                    <td>{{$file['name']}}</td>
                    <td>{{$file['type']}}</td>
                    <td>{{$file['size']}}</td>
                    <td><a href="/download/files/{{$file['path']}}" class="ui__btn download"></a></td>
                    <td><a class="delete" href="/files/delete/{{$file['path']}}"> <i class="fa fa-trash"></i></a></td>
                </tr>
            @endforeach
        </table>
        <!-- /.file-list -->

    </main>
    <!-- /.ui__main -->

</div>
<!-- /.ui -->

<div class="ui__overlay overlay" id="help">
    <div class="overlay__inner">

        <h2>🎂</h2>
        <p>The cake is a lie...</p>

        <a href="javascript:void(0)" class="btn overlay__close">Oh no!</a>

    </div>
    <!-- /.overlay__inner -->
</div>
<!-- /.overlay -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.3/vue.min.js'></script>
    <script  src="{{asset('dropbox/js/index.js')}}"></script>
    <script  src="{{asset('js/flashmessage.js')}}"></script>
</body>

</html>
