<x-filament-panels::page>
    @php
        $installments = \App\Models\Installment::where('agreement_of_sale_id',$this->record->id)->get()
     @endphp
    <div class="container mx-auto shadow-lg p-3 rounded-xl">
        <h1>
            Installments
        </h1>
        <hr class="my-3">
        <table   class="p-2 w-full  text-left table-auto border-collapse border " >
            <thead class="text-md text-gray-700 uppercase dark:text-gray-400">
                <tr >
                    <th class="p-2 border">Month & Year </th>
                    <th  class="p-2 border"> Is Paid </th>
                    <th  class="p-2 border"> Amount </th>
                    <th  class="p-2 border"> balance_bf </th>
                    <th  class="p-2 border"> balance </th>
                    <th  class="p-2 border">Full Payment?</th>
                    <th  class="p-2 border">penalty </th>
                </tr>
            </thead>

            <tbody>

            @if(count($installments) > 0)
                @foreach($installments as $installment)
                    <tr class="bg-white  hover:bg-gray-200  ">

                    <td  class="p-2 border text-sm">
                        {{ date('M',mktime(0, 0, 0, $installment->month, 10)) }} - {{  $installment->year }}

                    </td>
                        <td  class="p-2 border text-sm">
                             @if($installment->payment_id)
                                 Yes
                                @else
                                 No
                             @endif
                        </td>
                        <td  class="p-2 border text-sm"> $ {{ $installment->amount }} </td>
                        <td  class="p-2 border text-sm">  {{ $installment->balance_bf }} </td>
                        <td  class="p-2 border text-sm">  {{ $installment->balance }} </td>
                        <td  class="p-2 border text-sm">
                            @if($installment->is_paid_infull)
                                YES
                            @else
                                NO
                            @endif
                        </td>
                        <td  class="p-2 border text-sm">  {{ $installment->penalty }} </td>
                    </tr>
                @endforeach

            @endif

            </tbody>
        </table>
    </div>
</x-filament-panels::page>
