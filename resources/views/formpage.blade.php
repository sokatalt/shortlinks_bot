

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .main{
            margin-top:50px;
        }
    </style>
    <title>Form</title>
</head>
<body>
<div class="container main">
<div class="container">
    
    <form action="{{url('addlead')}}" method='post'>
    @csrf
    <div class="mb-3">
        <label for="username" class="form-label">username </label>
            <input type="text" name="name"  class="form-control">
            <input type="hidden" name="ip"  class="form-control" Value="<?php echo  $_SERVER['REMOTE_ADDR'];?>">
</div>
<div class="mb-3">
            <label for="phone" class="form-label">phone </label>
            <input type="text" name="phone"  class="form-control">
            <input type="hidden" name="compain_user_id" value="{{$url->user_id}}">
</div>
            <div class="mb-3">
            <label for="email" class="form-label">email </label>
            <input type="text" name="email"  class="form-control">
</div>
            <div class="mb-3">
            <label for="address" class="form-label">address </label>
            <input type="text" name="address"  class="form-control" value="">
            <input type="hidden" name="url2"  value="{{$url->destination_url}}">
</div>
            <div class="mb-3">
            <input type="submit" value='Submit'  class="form-control btn btn-success">
       
    </form>
</div>
</div>
</body>
</html>