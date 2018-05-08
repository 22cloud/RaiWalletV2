
@extends('layouts.pay')

@section('content')
    <div class="container main-container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8 login-square">
                <div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-xs-8">
                                <img src="apple-icon.png" class="img-responsive pay-logo" />
                                <h3 class="logo-name">NANOWALLET</h3>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-xs-12">
                                <h3>Authorize a new IP address</h3>
                                    @if($status == 'info')
                                        <div class="col-xs-12">
                                            <div class="alert alert-info">
                                                Check that you recognize both IP addresses and locations. <b>Do not authorize</b> this login attempt if the IP address trying to log in looks suspicious or you do not recognize it.
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <h4>Login IP:</h4>
                                            <p>
                                                <code>{{$attempt->ip}}</code> <br/>
                                                This is the IP trying to login into your wallet. It is from <b>{{$attempt->location}}</b>.
                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <h4>Your current IP:</h4>
                                            <p>
                                                <code>{{$current->ip}}</code><br/>
                                                This is your current IP address. You seem to be at <b>{{$current->location}}</b>.
                                            </p>
                                        </div>
                                        <div class="col-xs-12">
                                            <form method="post" class="text-center">
                                                @csrf
                                                <input type="submit" class="btn btn-primary btn-lg" style="padding:20px; margin:10px" value="Authorize this IP address"/>
                                            </form>
                                        </div>
                                    @elseif ($status == 'success')
                                        <div class="col-xs-12">
                                            <div class="alert alert-success">
                                                <p>
                                                    This IP address has been successfully authorized. <a href="https://nanowallet.io/"><b>You can now proceed to login.</b></a> 
                                                </p>
                                            </div>
                                        </div>
                                    @elseif($status == 'error')
                                        <div class="col-xs-12">
                                            <div class="alert alert-danger">
                                                <p>
                                                    {{$msg}}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
