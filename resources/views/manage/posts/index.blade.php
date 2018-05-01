@extends('layouts.manage')

@section('content')
<div class="flex-container">
    <div class="columns m-t-10">
        <div class="column">
            <h1 class="title">This is post.index page</h1>
        </div>
        <div class="column">
            <a href="{{route('posts.create')}}" class="button is-primary is-pulled-right"><i class="fa fa-user-add m-r-10"></i>Create New Post</a>
        </div>
    </div>
    <hr>
    
</div>
@endsection