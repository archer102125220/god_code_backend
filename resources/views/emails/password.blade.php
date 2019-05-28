@extends('beautymail::templates.sunny')

@include('beautymail::templates.widgets.articleStart', ['color' => '#0000FF'])

@section('content')
    @include ('beautymail::templates.sunny.heading' , [
        'heading' => '重新設定您的密碼',
        'level' => 'h1',
    ])
    @include('beautymail::templates.sunny.contentStart')
    <p>您好，這裡是重設密碼文案放置處</p><br />
    <p>
        您可以點擊下方按鈕或是訪問此連結前往重設您的密碼：<br />
        <a href="{{$resetUrl}}">{{$resetUrl}}</a>
    </p>
    @include('beautymail::templates.sunny.contentEnd')
    @include('beautymail::templates.sunny.button', [
        'title' => '重設密碼',
        'link' => $resetUrl
    ])
@stop
