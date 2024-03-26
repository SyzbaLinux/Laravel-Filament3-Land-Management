<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" >

</head>
    <body>
        <div class="container border shadow-lg mt-5 rounded-lg p-3">
            <h1  style="text-align: center">Statement</h1>
            <br>
            <table class="table border mt-3">

                <tr style="background-color: grey">
                    <td colspan="5">
                        <h3>Purchaser Details</h3>
                    </td>
                </tr>
                <tr>
                    <td><b>Purchaser:</b>  {{ $client->first_name.' '. $client->last_name  }} </td>
                    <td><b>DOB:</b> {{ date('d-F-Y', strtotime($client->dob)) }}</td>
                    <td><b>National ID:</b> {{ $client->natID }}</td>
                </tr>
                <tr>
                    <td><b>Address:</b> {{ $client->address }}</td>
                    <td></td>
                    <td></td>
                </tr>


                <tr>
                    <td><b>Email:</b> {{ $client->email }}</td>
                    <td></td>
                    <td></td>
                </tr>


                <tr>
                    <td><b>Phone No:</b> {{ $client->mobile }}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="background-color: grey">
                    <td colspan="5">
                        <h3>Stand Details</h3>
                    </td>
                </tr>

                <tr>
                    <td> <b>Stand No: {{ $stand->stand_number }}</b> </td>
                    <td> <b> Measuring:</b> {{ $stand->square_metres }} </td>
                    <td> <b> Purchase Price:</b> {{ $stand->price }} </td>
                    <td> <b> Electrification Costs:</b>  {{ $stand->other_costs }} </td>
                </tr>

                <tr style="background-color: grey">
                    <td colspan="5">
                        <h3>Payments</h3>
                    </td>
                </tr>

                <tr>
                    <td><b>Total Paid:</b> </td>
                    <td><b>Overall Balance:</b> </td>
                    <td><b>Total In Penalty:</b> {{ $stand->price }} </td>
                    <td><b>Vat Balance:</b></td>
                    <td><b>Endowment Balance:</b></td>
                </tr>
            </table>


            <h1 class="my-5">Payments Schedule</h1>

            <table class="table">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Date Paid</th>
                        <th>Amount Paid</th>
                        <th>Received From</th>
                        <th>Installment</th>
                        <th>VAT</th>
                        <th>Endowment</th>
                        <th>Penalty</th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($payments) > 0)
                        @foreach($payments as $payment)
                            <tr>
                                <td> {{ $payment->id }} </td>
                                <td> {{ $payment->receipt_date }}</td>
                                <td>$ {{ $payment->amount_paid }}</td>
                                <td> </td>
                                <td>yes</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <div class="my-5" style="text-align: center">
                <hr>
                <p>Computer Generated, Powered By Acxel Accounting</p>
            </div>
        </div>
    </body>
</html>
