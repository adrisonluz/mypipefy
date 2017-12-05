@extends('emails.layout')
@section('content')
	<div style="padding:10px;text-align:center;font-size:20px;">
	    <h1 style="font-size: 26px;font-weight: lighter;">Olá <strong style="font-weight: bold;font-style: italic;">Fulano de tal</strong>.</h1><p><strong>Fulano de tal2</strong> está te convidando para o time dele. </p><p>Deseja participar?</p>
	    <div><br>
	        <a href="#recusar" style="font-size:24px;border:1px solid;margin-top:5px;margin-right:10px;padding:0px 10px;border-radius:3px;margin-bottom:5px;text-decoration:none;border-color:#420605;color:#fff;background: #a94442;">Recusar</a>
	        <a href="#aceitar" style="font-size:25px;border:1px solid;margin-top:5px;margin-right:10px;padding:0px 10px;border-radius:3px;margin-bottom:5px;text-decoration:none;color:#ffffff;border-color:#003901;background: #50ae52;">Aceitar</a>
	    </div><br>
	</div>
@endsection
