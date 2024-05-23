<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aguva USSD Simulator</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

<div class="container">
    <div class="row mt-3">
        <div class="col-lg-10 col-xl-10 col-md-12 col-sm-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-left">Aguva USSD Simulator</h5>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('test.show-simulator') }}" class="btn btn-primary">New Session</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{!! route('test.process-payload') !!}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="msisdn">Enter Msisdn</label>
                                <input type="text" id="msisdn" name="msisdn" value="{!! @$input['msisdn'] !!}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-md-12">
                                <label for="sessionId">Enter Session Id</label>
                                <input type="text" id="sessionId" name="sessionId" value="{!! @$input['sessionId'] !!}" required class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-md-12">
                                <label for="text">Enter User Input</label>
                                <input type="text" id="text" name="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">Send Request</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <h5>USSD Response</h5>
                    <div class="bg-success text-white">
                        @if(isset($text))
                            {!! nl2br($text) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>
</html>
