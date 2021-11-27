<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Invoice</title>
        <style>
            *,*::after,*::before{
                box-sizing: border-box;
            }
            .container{
                width: 60%;
                margin: auto;
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
            }
            .pb-1{
                padding-bottom: 0.3rem;
            }
            .f-12 {
                font-size: 12px;
              }
              .f-14 {
                font-size: 14px;
              }
              .f-16 {
                font-size: 16px;
              }
              .f-20 {
                font-size: 20px;
              }
              .f-24 {
                font-size: 24px;
              }
            .border{
                border: 1px solid black;
            }
            .border-bottom{
                border-bottom:1px solid black;
            }
            .block-holder{
                padding: 10px 0;
                display: flex;
                justify-content: center;
            }
            .block{
                width: 47%;
                margin: 0 1%;
                height: 180px;
                padding: 20px 10px;
            }
            .flex-container{
                display: flex;
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
                border: 1px solid black;
            }
            td{
                padding: 10px;
                text-align: center;
            }
            p{
                margin: 0;
            }
            .myButton {
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
	background-color:#79bbff;
	border-radius:6px;
	border:1px solid #84bbf3;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	padding:13px 53px;
	text-decoration:none;
	text-shadow:0px 1px 0px #528ecc;
}
.myButton:hover {
	background:linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
	background-color:#378de5;
}
.myButton:active {
	position:relative;
	top:1px;
}
.borderx{
    box-shadow:0px 0px 3px 1px slategray;
    padding:30px;
    min-height:1000px;
}
        </style>
    </head>
    <body>
        <div>
            <a href="pdfcreate/{{$customer->id}}" class="myButton">Generate PDF</a>
        </div>
        <div class="container borderx">
            <div class="header">
                <h4 class="text-center mb-0">Faktura №{{$credit->unicode}} 16/10/2020.</h4>
                <p class="text-center mt-0 f-14">Shartnoma {{$credit->contractcode}}</p>
            </div>
            <div class="block-holder">
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
                  {{-- <div>Lorem ipsum dolor sit amet.</div> --}}
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
          {{-- <p class="mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, necessitatibus.</p> --}}
            <div class="flex-container">
                <div class="column">
                    <div class="mb-3">Firma rahbari: ______________ &nbsp; {{$admin->main}}</div>
                    <div class="mb-3">Hisobchi: ______________ &nbsp; {{$admin->accountant}}</div>
                </div>
                <div class="column">
                    <div class="border-bottom pb-1">Qabul qilindi <span class="text-white">zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz</span></div>
                    <p class="f-14 ">(Mijozning imzosi uchun joy.)</p>
                </div>
            </div>
        </div>
         
    </body>
</html>