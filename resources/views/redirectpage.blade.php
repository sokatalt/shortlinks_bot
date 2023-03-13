<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="{{ config('settings.loading_duration2') }}; url=/{{ $url }}">
    <title>Redirect To My Link</title>
    <style>
    #loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #fff;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    }
    
    .loading-text {
    font-size: 2em;
    color: #000;
    margin-right: 20px;
    }
    
    .loading-spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
    }
    
    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }
    </style>
</head>
<body>
    <div id="loader">
        <div class="loading-text">Loading...</div>
        <div class="loading-spinner"></div>
    </div>


</body>
</html>
