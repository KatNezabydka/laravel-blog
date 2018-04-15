<h2>{{$title}}</h2>
<ol class="breadcrumb">
    {{--route() - именованный маршрут вот так он вызывается если в роутах прописать name--}}
    <li><a href="{{route('admin.index')}}">{{$parent}}</a></li>
    <li class="active">{{ $active }}</li>
</ol>