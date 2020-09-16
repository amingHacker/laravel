{{-- <p>
    {{ $params['say'] }}
</p> --}}


<style>
    .table7_11 table {
        width:100%;
        margin:15px 0
    }
    .table7_11 th {
        background-color:#1E90FF;
        background:-o-linear-gradient(90deg, #1E90FF, #7ebffe);
        background:-moz-linear-gradient( center top, #1E90FF 5%, #7ebffe 100% );
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #1E90FF), color-stop(1, #7ebffe) );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#1E90FF', endColorstr='#7ebffe');
        color:#FFFFFF
    }
    .table7_11,.table7_11 th,.table7_11 td
    {
        font-size:0.95em;
        text-align:center;
        padding:4px;
        border-bottom:1px solid #efefef;
        border-collapse:collapse
    }
    .table7_11 tr:nth-child(odd){
        background-color:#b4dafe;
        background:-o-linear-gradient(90deg, #b4dafe, #f0f7fe);
        background:-moz-linear-gradient( center top, #b4dafe 5%, #f0f7fe 100% );
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #b4dafe), color-stop(1, #f0f7fe) );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#b4dafe', endColorstr='#f0f7fe');
    }
    .table7_11 tr:nth-child(even){
        background-color:#fdfdfd;
    }
    </style>
    <table class=table7_11>
    <tr>
        <th>編號</th><th>品名</th><th>等級</th><th>批號</th><th>設備名稱</th><th>異常事件</th>
    </tr>
    <tr>
        <td>{{ $params['id'] }}</td><td>{{ $params['product_name'] }}</td><td>{{ $params['level'] }}</td>
        <td>{{ $params['batch_number'] }}</td><td>{{ $params['equipment_name'] }}</td><td>{{ $params['JudgeComment'] }}</td>
    </tr>
    </table>
    請至<a href="http://twka1w0002.ap.merckgroup.com:8080/AbnormalEvent">Merck KH | SPC System</a> 