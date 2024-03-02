<!DOCTYPE html>
<html lang="en">
<head>
    <title>Receipt</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div style="padding: 20px; font-family:'Arimo',serif"  >

                <table style="width:100%">
                    <tr style="vertical-align: center">
                        <td style="width:40%;padding-left: 13px">
                            <img
                                src="{{ asset('/images/logo.png') }}"
                                alt="logo"
                                style="width: 100px;"
                            />
                        </td>
                        <td style="width:60%;text-align: right">
                            <h3>Company Name</h3>
                            <p>Moto</p>
                            <p style="font-size: 13px">Description</p>
                        </td>
                    </tr>
                </table>

                <div style="text-align: center; padding: 5px">
                    Computer Generated, Powered By <a target="_blank" href="https://acxel.online/">Acxel Accounting</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
