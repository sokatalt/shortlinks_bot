@extends('layouts.mydash')
@section('content')
<div class="container" id="downloadarea">
    {{-- <h4 class="text-left " style="float:right"><a href="" class="btn btn-primary print" style="float:right">Print Report</a></h4> --}}
<table class="table table-bordered" style='width:100%'>
    <thead class="table-dark">
        <td>id</td>
        <td>Date</td>
        <td>name</td>
        <td>phone</td>
        <td>email</td>
        <td>address</td>
        <td>ip</td>
       
    </thead>
    <tbody>
    
        @foreach ( $myleads as $lead)
        <tr>
        <td>{{$lead->id}}</td>
        <td>{{$lead->created_at}}</td>
        <td >{{$lead->name}}</td>
        <td >{{$lead->phone}}</td>
        <td >{{$lead->email}}</td>
        <td >{{$lead->address}}</td>
        <td  class="ip">{{$lead->ip}}</td>
        {{-- @if ($compain->compain_id ==1|$compain->compain_id ==2|$compain->compain_id ==3)
        <td >Short Link</td>
        @else
        <td >Form Link </td>

        @endif --}}
    </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center">{{$myleads->links()}}</div>
<div id="print">
<a href="" class="btn btn-dark Download" style="float:right">Download Report</a>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>

    // let printing =document.querySelector('.print')
    // let printingtab =document.querySelector('#print')
    // printing.addEventListener('click',function(e){
    //     e.preventDefault();
    //     printingtab.classList.add('hidden')

    //     window.print();

    // })
    
    let Download =document.querySelector('.Download')
    let Downloadtab =document.querySelector('#print')
    Download.addEventListener('click',function(e){
        e.preventDefault();
        Downloadtab.classList.add('hidden')
        window.jsPDF = window.jspdf.jsPDF;
        var doc = new jsPDF();
        window.html2canvas = html2canvas;
        var elementHTML = document.querySelector("#downloadarea");
        doc.html(elementHTML, {
            callback: function(doc) {
                // Save the PDF
                doc.save('sample-document.pdf');
            },
            x: 15,
            y: 15,
            width: 170, //target width in the PDF document
            windowWidth: 650 //window width in CSS pixels
        })
let delreq =new XMLHttpRequest();
delreq.onreadystatechange = function(){
    if(this.readyState ==4 && this.status==200){
    }
}
delreq.open('GET',"/deleteleads");
delreq.send();
// window.location.reload();
    })

    var ipAddress = document.querySelectorAll(".ip");
     let myip =Array.from(ipAddress)

     myip.forEach(function(el){
    let x=el.innerText
fetch('https://reallyfreegeoip.org/json/'+x)
// fetch('https://ipapi.co/'+ x +'/json/')
.then(function(response) {
  response.json().then(jsonData => {
    console.log(jsonData['city']);
    // let res =JSON.parse(this.responseText)
            el.innerText=jsonData['country_code']
  });
})
.catch(function(error) {
  console.log(error)
});
})

myip.forEach(function(el){
     let x=el.innerText
     var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(JSON.parse(this.responseText));
            let res =JSON.parse(this.responseText)
            el.innerText=res['country_name']
        }
    };
    xhttp1.open("GET", "https://ip-api.io/json/" + x, true);
    xhttp1.send();
})

</script>

@endsection