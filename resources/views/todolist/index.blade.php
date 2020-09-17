<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>kanrin</title>
    <link rel="stylesheet" href="../css/jkanban.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" />

    <style>
        body {
            font-family: "Lato";
            margin: 0;
            padding: 0;
        }

        #myKanban {
            overflow-x: auto;
            padding: 20px 0;
        }

        .success {
            background: #00b961;
        }

        .info {
            background: #2a92bf;
        }

        .warning {
            background: #f4ce46;
        }

        .error {
            background: #fb7d44;
        }
    </style>
</head>

<body>
    @extends('layout')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div id="myKanban"></div>
    <!-- 導入予定機能 -->
    <!-- <button id="addDefault">Add "Default" board</button>
    <br />
    <button id="addToDo">Add element in "To Do" Board</button>
    <br />
    <button id="removeElement">Remove "My Task Test"</button> -->
    <script src="../js/jkanban.js"></script>
    <script>
        var KanbanTest = new jKanban({
        element: "#myKanban",
        gutter: "10px",
        widthBoard: "450px",
        itemHandleOptions:{
          enabled: true,
        },

        click: function(el) {

        },
        dropEl: function(el, target, source, sibling){
           const texts =  document.querySelectorAll('.kanban-item');
           console.log(texts)
           const list = [];
           texts.forEach(e => {
               list.push(e.textContent)
           });
           list.pop();
           fetch('/api/saveList', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                list :list,
                _token: '{{ csrf_token() }}'
            }),
          })
        },
        buttonClick: function(el, boardId) {

          // create a form to enter element
          var formItem = document.createElement("form");
          formItem.setAttribute("class", "itemform");
          formItem.innerHTML =
            '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">作成</button><button type="button" id="CancelBtn" class="btn btn-danger btn-xs pull-right">取消</button></div>';

          KanbanTest.addForm(boardId, formItem);
          formItem.addEventListener("submit", function(e) {
            e.preventDefault();
            var text = e.target[0].value;
            KanbanTest.addElement(boardId, {
              title: text
            });
            formItem.parentNode.removeChild(formItem);
          });
          document.getElementById("CancelBtn").onclick = function() {
            formItem.parentNode.removeChild(formItem);
          };
        },
        addItemButton: true,
        boards: [
          {
            id: "_todo",
            title: "To Do",
            class: "info,good",
            dragTo: ["_working"],
            item: [

            ]
          },
          {
            id: "_working",
            title: "Working ",
            class: "warning",
            item: [

            ]
          },
          {
            id: "_done",
            title: "Done ",
            class: "success",
            dragTo: ["_working"],
            item: [

            ]
          }
        ]
      });

      window.onload = async function() {
        const response = await fetch('/api/list',{
         headers : {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
            }
        })
        const data = await response.json();
        if (data) {
            const array = data.split(',');
            array.forEach(e => {
                KanbanTest.addElement('_todo', {title: e})
            })
        }
      }
    </script>
    <a href="{{ url('/holiday') }}" class="todo-btn">予定入力画面へ</a>

</body>

</html>
