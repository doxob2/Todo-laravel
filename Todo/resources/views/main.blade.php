<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container d-flex justify-content-center"> <a class="navbar-brand" href="#">
                <i class="fa d-inline fa-lg fa-circle-o"></i>
                <b> BRAND</b>
            </a> </div>
    </nav>
    <div class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item"> <a id='addBtn' class="btn active nav-link">Add</a> </li>
                        <li class="nav-item"> <a id='completesBtn' class="nav-link" >Complete</a> </li>
                        <!-- <li class="nav-item"> <a href="#" class="nav-link disabled">Nav pill</a> </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id='formContent' class="py-3 text-center" style='display: none'>
    <div class="container">
      <div class="row">
        <div class="mx-auto p-4 col-md-7">
          <h1 class="mb-4">Форма</h1>
          <form>
            <input type="hidden" id="token" value="{{ csrf_token() }}" name="token">
            <div class="form-group"> <input type="text" class="form-control" id="Title" placeholder="Название"> </div>
            <div class="form-group"> <textarea class="form-control" id="Description" rows="3" placeholder="Напишите описание к задаче" ></textarea> </div> 
            <select class='w-100 pb-3' name="Priority" id="Priority">
                <option value='HIGH'>Высокий</option>
                <option value='MIDDLE'>Средний</option>
                <option value='LOW'>Низкий</option>
            </select>
            <button id='postNewTask' type="button" class="btn btn-outline-primary btn-block mt-3">Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>
    <div class="py-5">
    <div class="container" id='content'></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>

    <script>
        $('#Title').val('');
        $('#Description').val('');
        $('#Priority').val('');
        var token = document.head.querySelector("[name=csrf-token]").content;


        function setTodoOnPage(data){
            let id = data[0];
            let title = data[1];
            let discription = data[2];
            let status = data[5];
            let time = data[4];
            if (data[3]=='HIGH' && data[5]!=1){
                var priority = 'bg-danger';
            } else if (data[3]=='MIDDLE' && data[5]!=1){
                var priority = 'bg-warning';
            } else if (data[3]=='LOW' && data[5]!=1){
                var priority = 'bg-primary';
            } else {
                var priority = 'bg-success';
            }
            let title_html = '<div class="row pb-5"><div class="col-md-12 border border-secondary rounded-lg"><div class="row"><div class="col-md-12 border-bottom '+priority+' border-secondary"><h2 id="title" class="text-center">'+title+'</h2></div></div>';
            let discription_html = '<div class="row"><div class="col-md-12"><h4 class="py-3">' + discription + '</h4></div></div>';
            let timeAndButton_html = '<div class="row"><div class="col-md-12"><div class="row justify-content-end pb-2"><div class="col-md-4"><a onclick="completeTodo('+id+')" class="btn btn-primary">Complete</a></div><div class="col-md-4"><h6 class="text-right pt-1">'+time+'</h6></div><div class="col-md-4"><div class="btn-group w-100"> <button onclick="deleteTodo('+id+')" id="btnDelete" ' +  ' value=' +id+ ' class="btn btn-primary">Delete</button> <a class="btn btn-primary">Edit</a> </div></div></div>';
            let div = document.createElement('div');
            //div.innerHTML = title_html + discription_html + timeAndButton_html;
            $('#content').append(title_html + discription_html + timeAndButton_html);
        }

        $('#addBtn').click(function(){
            if ($('#addBtn').text()=='Add'){
                $('#formContent').css('display','');
                $('#addBtn').text('X');
            } else {
                $('#formContent').css('display','none');
                $('#addBtn').text('Add');
            }
        })
        
        function getTodoList(){
            $.get('/getTodo',{ async: false }, function(data) {
                $.each(data, function(key, value) {
                    setTodoOnPage(value);
                });
            });
        }
        
        function postAddTodo(task){
            $.post("/add", {_token: token, title: task['title'], description: task['description'], priority: task['priority'] });
            $('#content').text('');
            setTimeout(getTodoList, 1000);
        };

        function postDeleteTodo(id){
            $.post("/delete", {_token: token, id: id});
            $('#content').text('');
            setTimeout(getTodoList, 1000);
        };

        function postCompleteTodo(id){
            $.post("/complete", {_token: token, id: id});
            $('#content').text('');
            setTimeout(getTodoList, 1000);
        };
        
        
        $('#postNewTask').click(function(){
            let task = [];
            if ($('#Title').val()!='' && $('#Description').val()!='' && $('#Priority').val()!=''){
                task['title']=($('#Title').val());
                task['description']=($('#Description').val());
                task['priority']=($('#Priority').val());
                postAddTodo(task);
            } else {
                alert('Заполните поля');
            }
        });



        function deleteTodo(id){
            console.log(id);
            postDeleteTodo(id)
        }

        function completeTodo(id){
            console.log(id);
            postCompleteTodo(id);
        }



        $(function(){
            getTodoList();
        });
    </script>


</body>

</html>