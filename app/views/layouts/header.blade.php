<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Shop market</title>
    <meta name="generator" content="Shop Market" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{ asset('/resources/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/resources/bootstrap/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('/resources/css/custom.css') }}" rel="stylesheet">
</head>
<body>

@if(Auth::check())
<header class="navbar navbar-fixed-top header" style="margin-top: 0px">
    <div class="col-md-12">
        <div class="navbar-header">
            <a href="/" class="navbar-brand">Shop Market</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse1">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse1">
            @include('layouts.search')
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/" >Market+</a></li>
                <li><a href="/cart" title="cart"><i class="glyphicon glyphicon-shopping-cart"></i> @if(Session::has('cart') && count(Session::get('cart')) != 0)<div class="cart">{{count(Session::get('cart'))}}</div>@endif</a></li>
                @if(Auth::user()->is_admin==1)
                    <li><a href="/admin/categories" title="categories"><i class="glyphicon glyphicon-list-alt"></i></a></li>
                @endif
                <li><a @if(Auth::user()->is_admin==0)href="/myproducts"@elseif(Auth::user()->is_admin==1)href="/admin/myproducts"@endif title="products"><i class="glyphicon glyphicon-th-large"></i></a></li>
                <li><a href="/profile" title="profile"><i class="glyphicon glyphicon-user"></i></a></li>
                <li><a href="/logout" title="logout"><i class="glyphicon glyphicon-log-out"></i></a></li>
            </ul>
        </div>
    </div>
</header>
@else
    <header class="navbar navbar-fixed-top header" style="margin-top: 0px">
    <div class="navbar navbar-default" id="subnav" style="margin-top: 0">
        <div class="col-md-12">
            <div class="navbar-header">
                <a href="/" style="margin-left:15px;" class="navbar-btn btn btn-default " ><i class="glyphicon glyphicon-home" style="color:#dd1111;"></i> Shop market </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse2">
                @include('layouts.search')
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/cart" title="cart">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                            @if(Session::has('cart') && count(Session::get('cart')) != 0)<div class="cart">{{count(Session::get('cart'))}}</div>
                            @endif
                        </a>
                    </li>
                    <li><a href="/signin" >Sign In</a></li>
                    <li><a href="/signup">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </div>
    </header>
@endif


