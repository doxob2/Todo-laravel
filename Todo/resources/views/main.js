function setTodoOnPage(data) {
    let id = data[0];
    let title = data[1];
    let discription = data[2];
    if (data[3] == 'HIGH') {
        var priority = 'bg-primary';
    } else if (data[3] == 'NORMAL') {
        var priority = 'bg-danger';
    } else if (data[3] == 'LOW') {
        var priority = 'bg-warning';
    }
    let time = data[4];
    let title_html = '<div class="row pb-5"><div class="col-md-12 border border-secondary rounded-lg"><div class="row"><div class="col-md-12 border-bottom ' + priority + ' border-secondary"><h2 id="title" class="text-center">' + title + '</h2></div></div>';
    let discription_html = '<div class="row"><div class="col-md-12"><h4 class="py-3">' + discription + '</h4></div></div>';
    let timeAndButton_html = '<div class="row"><div class="col-md-12"><div class="row justify-content-end pb-2"><div class="col-md-4"><a class="btn btn-primary" href="#">Button</a></div><div class="col-md-4"><h5 class="text-right pt-1">' + time + '</h5></div><div class="col-md-4"><div class="btn-group w-100"> <a href="#" class="btn btn-primary">Btn 2</a> <a href="#" class="btn btn-primary">Btn 3</a> </div></div></div>';
    let div = document.createElement('div');
    //div.innerHTML = title_html + discription_html + timeAndButton_html;
    $('#content').append(title_html + discription_html + timeAndButton_html);
}
function test() {
    console.log('OK!');
}


function addTodo() {
    $.ajax({ url: '/test', dataType: "dataType" }, function () {
        alert('asdasd');
    })
};


function qwe() {
    $.get('/test', { async: false }, function (data) {
        console.log(data);
        $.each(data, function (key, value) {
            setTodoOnPage(value);
        });
    });
}

$(function () {
    qwe();
});