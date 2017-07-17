<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bug viewer</title>
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap-theme.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap-table.min.css') }}">
    <script src="{{ URL::to('js/jquery-3.2.0.min.js') }}"></script>
    <script src="{{ URL::to('js/bootstrap.js') }}"></script>
    <script src="{{ URL::to('js/bootstrap-table.min.js') }}"></script>
</head>
<body>
<div class="container">
    <h1>Bugs submitted through the ingame form</h1>
    <div class="input-group">
        <input id="api-key" type="text" class="form-control" placeholder="API key">
        <div class="input-group-btn">
            <input id="get-data-btn" class="btn btn-default" type="button" value="Get data">
        </div>
    </div>
    <table id="table" class="table table-striped"
           data-toggle="table"
           data-ajax="getData"
           data-page-list="[5, 10, 20, 50, 100, 200]"
           data-pagination="true"
           data-detail-view="true"
           data-detail-formatter="detailFormatter"
    >
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="created_at">Date</th>
                <th data-field="client_os">OS</th>
                <th data-field="game_version">Version</th>
                <th data-formatter="happeningColFormater" data-field="happening">Bug</th>
                <th data-formatter="expectedColFormater" data-field="supposed">Expected behavior</th>
                <th data-formatter="reproduceColFormater" data-field="reproduce">How to reproduce</th>
                <th data-field="contact">Contact info</th>
                <th data-formatter="editColFormatter"></th>
            </tr>
        </thead>
    </table>
</div>
<script>
    var $table = $('#table'),
        $refreshBtn = $('#get-data-btn');

    $(function () {
        if(window.localStorage) {
            var apikey = window.localStorage.getItem('apikey');
            if (apikey) {
                $('#api-key').val(apikey);
            }
        }
        $refreshBtn.click(function () {
            $table.bootstrapTable('refresh');
            if(window.localStorage) {
                window.localStorage.setItem('apikey', $('#api-key').val());
            }
        });
    });

    function deleteBug(id) {
        console.log(id);
        jQuery.ajax({
            method: 'DELETE',
            headers: {
                'x-api-key': window.localStorage.getItem('apikey')
            },
            url: '/bugs/'+id
        }).done(function (data, textStatus, jqXHR) {
            console.log('delete succeeded! id: ', id);
            console.log($table.bootstrapTable('remove', {field:'id', values: [id]}));
        }).fail(function (jqXHR, textStatus, err) {

        });
    }

    function getData(params) {
        jQuery.extend(params,
            {
                headers: {
                    "x-api-key": window.localStorage.getItem('apikey')
                },
                url: "/bugs"
            }
        );
        return jQuery.ajax(params);
    }
    function editColFormatter(value, row, index) {
        return '<button class="btn"><span onclick="deleteBug(' + row.id + ')" class="glyphicon glyphicon-remove"></span></button>' +
            '<button class="btn"><span class="glyphicon glyphicon-share"></span></button>';
    }
    function happeningColFormater (value, row, index) {
        var words = value.split(' ');
        if (words.length > 10) {
            var part = words.slice(0, 10);
            part.push('(....)');
            return part.join(' ');
        } else {
            return value;
        }
    }
    function expectedColFormater (value, row, index) {
        var words = value.split(' ');
        if (words.length > 10) {
            var part = words.slice(0, 10);
            part.push('(....)');
            return part.join(' ');
        } else {
            return value;
        }
    }
    function reproduceColFormater (value, row, index) {
        var words = value.split(' ');
        if (words.length > 25) {
            var part = words.slice(0, 25);
            part.push('(....)');
            return part.join(' ');
        } else {
            return value;
        }
    }
    function detailFormatter(index, row) {
        var html = [];
        $.each(row, function (key, value) {
            switch (key){
                case "id":
                case "date":
                    break;
                case "happening":
                    html.push('<div><b>Bug: </b>' + value + '</div>');
                    break;
                case "supposed":
                    html.push('<div><b>Expected Behavior: </b>' + value + '</div>');
                    break;
                case "reproduce":
                    html.push('<div><b>How to reproduce: </b>' + value + '</div>');
                    break;
                case "contact":
                    break;
            }
        });
        return html.join('');
    }
</script>
</body>
</html>