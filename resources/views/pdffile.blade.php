<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Invoice</title>
        <style>
            body{
                font-family: DejaVu Sans, sans-serif;
            }
            *,*::after,*::before{
                box-sizing: border-box;
            }
          
            .text-center{
                text-align: center;
            }
            .text-left{
                text-align: left;
            }
            .text-right{
                text-align: right;
            }
            .text-underline{
                text-decoration: underline;
            }
            .text-white{
                color: white;
            }
            .mt-0{
                margin-top: 0;
            }
            .mb-0{
                margin-bottom: 0;
            }
            .mt-1{
                margin-top: 0.5rem;
            }
            .mb-3{
                margin-bottom: 1rem;
                font-size: 12px!important;
            }
            .pb-1{
                padding-bottom: 0.3rem;
            }
            .f-12{
                font-size: 12px!important;
            }
            .f-10 {
                font-size: 10px!important;
              }
              .f-14 {
                font-size: 14px!important;
              }
              .f-16 {
                font-size: 16px!important;
              }
              .f-20 {
                font-size: 20px!important;
              }
              .f-24 {
                font-size: 24px!important;
              }
            .border{
                border: 1px solid black;
            }
            .border-bottom{
                border-bottom:1px solid black;
            }
            .block-holder{
                padding: 10px 0;
              
                justify-content: center;
            }
            .block{
                width: 45%;
                min-height: 180px;
                padding: 20px 10px;
                display: inline-block;
            }
            .flex-container{
                /* display: flex; */
            }
            .column{
                width: 47%;
                margin: 20px 1%;
            }
            table{
                width: 100%;
                border-collapse: collapse!important;
            }
            th,td{
                font-size:12px!important;
                border: 1px solid black;
            }
            td{
              
                padding: 5px;
                text-align: center;
            }
            p{
                margin: 0;
            }
            .block div{
                font-size: 12px!important;
            }
            .position{
               float:right;
               margin-top:-100px;
            }
        </style>
    </head>
    <body>
       <div>
                <p class="text-center mb-0 f-12" >Faktura №{{$credit->unicode}} 16/10/2020.</p>
                <p class="text-center mt-0 f-10">Shartnoma {{$credit->contractcode}}</p>
            </div>
         <div class="block-holder" style="margin-top:30px!important;">
                <div class="block border">
                    <div>Yetkazib beruvchi: MCHJ "{{$admin->name}}" </div>
                    <div>Adres: {{$admin->address}}</div>
                    <div>Yetkazib beruvchining Identifikatsiya raqami:</div>
                    <div>(INN) {{$admin->inn_number}}</div>
                    <div>Yetkazib beruvchining registratsiya raqami:</div>
                    <div>NDS {{$admin->nds_number}}</div>
                </div>
                <div class="block border">
                    <div>Ism Familiya: {{ $customer->fullname }}</div>
                    <div>Adres: {{ $customer->address }}</div>
                    <div>Passport seriyasi: {{ $customer->series }}</div>
                    <div>Berilgan sana: {{ $customer->givendate }}</div>
                    <div>Kim tomonidan berilgan: {{ $customer->bywhom }}</div>
                  <div style="color:white">Lorem ipsum dolor sit amet.</div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">№</th>
                        <th rowspan="2">Mahsulot Nomi</th>
                        <th rowspan="2">Miqdori</th>
                        <th rowspan="2">m<sup>2</sup> narxi</th>
                        
                        <th rowspan="2">Umumiy qiymati</th>
                        <th colspan="2">QQS</th>
                        <th rowspan="2">Umumiy qiymati(NDS bilan)</th>
                    </tr>
                    <tr>
                        <th>%</th>
                        <th>summa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                       
                    </tr>
                    @php
                    $a=1;
                @endphp
                    @foreach ($credit->solds as $sold)
                    <tr>
                        <td>{{$a}}</td>
                        <td>{{$sold->name}}</td>
                        <td>{{$sold->volume}} m<sup>2</sup> </td>
                        <td>{{number_format(($sold->price/$sold->volume), 1, '.', '')}}</td>
                        <td>{{$sold->price}}</td>
                        <td>{{$credit->qqs}}</td>
                        <td>{{$sold->price*$credit->qqs/100}}</td>
                        <td>{{$sold->price+$sold->price*$credit->qqs/100}}</td>
                    </tr> 
                    @php
                 $a+=1;
             @endphp
                    @endforeach
                
                    <tr>
                        <td colspan="3" class="text-left">Jami summa</td>
                        <td></td>
                        <td>{{$credit->debt_amount}}</td>
                        <td></td>
                        <td>{{$credit->debt_amount*$credit->qqs/100}}</td>
                        <td>{{$credit->debt_amount+$credit->debt_amount*$credit->qqs/100}}</td>
                    </tr>
                </tbody>
            </table>
   {{-- <h4 class="mt-1 f-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, necessitatibus.</h4> --}}
           
                <div class="column">
                    <div class="mb-3">Firma rahbari: ______________ &nbsp; {{$admin->main}}</div>
                    <div class="mb-3">Hisobchi: ______________ &nbsp; {{$admin->accountant}}</div>
                </div>
               <div class="column position">
                 <div class="border-bottom f-12">Qabul qilindi</div>
                    <h4 class="f-10 ">(Mijozning imzosi uchun joy.)</p>
                </div>
           
        
       
    </body>
</html>