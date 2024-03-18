<x-filament-panels::page>
    @php
        $details =  $record->load('client');
        $partners = \App\Models\Partner::where('stand_id',$record->stand_id)->get();
     @endphp
    <div class="container mx-auto shadow-lg p-3 rounded-xl">

        <div>
            Stands({{ count($record->stand) }}): &nbsp;
            @if(count($record->stand) >0)
                @foreach($record->stand as $stand)
                    {{ $stand['stand_number'] }},
                @endforeach
            @endif
        </div>

        <hr class="my-3">
        <table  style="width: 80%;">
            <tr>
                <td>Purchaser: &nbsp; </td>
                <td>
                   <b>
                       {{ $details->client['first_name']  }}
                       {{ $details->client['middle_name'] }}
                       {{ $details->client['last_name']  }}
                   </b>
                </td>

                <td>
                    <b>&nbsp;DOB</b> {{ date('d F Y',strtotime($details->client['dob'])) }}
                </td>

                <td>
                    <b>&nbsp;ID NO</b> {{  $details->client['natID'] }}
                </td>
            </tr>

            @if(count($partners) > 0)
                <tr>
                    <td style="text-align: center;" colspan="3">
                        &
                    </td>
                </tr>

                @foreach($partners as $partner)
                    <tr>
                        <td></td>
                        <td>
                            <b>
                                {{ $partner->first_name  }}
                                {{ $partner->middle_name }}
                                {{ $partner->last_name }}
                            </b>
                        </td>

                        <td>
                            <b>&nbsp;DOB</b> {{ date('d F Y',strtotime($partner->dob)) }}
                        </td>

                        <td>
                            <b>&nbsp;ID NO</b> {{  $partner->natID }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>

        <div class="mt-5">
            <b>Address:</b>
        </div>
        <div>
            <b>Phone:</b>
        </div>
    </div>
</x-filament-panels::page>
