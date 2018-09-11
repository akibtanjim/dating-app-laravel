@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    User List
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Distance</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Age</th>
                                <th scope="col">Like/Dislike</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $i=>$user)
                                @php
                                    $birthDate = explode("-", date('m-d-Y',strtotime($user->dob)));
                                    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                                        ? ((date("Y") - $birthDate[2]) - 1)
                                        : (date("Y") - $birthDate[2]));
                                @endphp
                                <tr>
                                    <th scope="row">{{ ++$i }}</th>
                                    <td><img class="img img-responsive img-sm" height="50" width="50" src="{{ $user->user_image }}"></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ number_format($user->distance,2) }} KM</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $age }}</td>
                                    <td>
                                        @if(!in_array($user->id, $liked_persons))
                                            <span class="btn btn-sm btn-success like_btn" data-id="{{ $user->id }}" data-type="like">
                                                Like
                                            </span>
                                        @else
                                            <span class="btn btn-sm btn-danger like_btn" data-id="{{ $user->id }}" data-type="dislike">
                                                Dislike
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4 offset-md-5">
                            <nav aria-label="Page navigation example">

                                <ul class="pagination">
                                    @if($page_count>1)
                                        @for ($i = 1; $i <= $page_count; $i++)
                                            <li class="page-item @if($current_page == $i){{ "active" }}@endif">
                                                <a class="page-link" href="{{ url('/') }}?page={{ $i }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal')

@push('scripts')
    <script src='{{ asset('public/js/home.js')}}'></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var liked_by = "{{ isset($liked_by->user->name) ? $liked_by->user->name : '' }}";
            if(liked_by != ''){
                $('body').find('#match_name').text(liked_by);
                var url = "{{url('/notification/seen')}}";
                var data = {
                    "_token": "{{ csrf_token() }}"
                }
                notification_update(url,data);
            }
            $('.table').on('click','.like_btn',function(){
                var url = "{{url('/user/like')}}";
                var data = {
                    "_token": "{{ csrf_token() }}",
                    "user_id":$(this).data('id'),
                    "type":$(this).data('type')
                }
                like_dislike(url,data);
            });
        });
        
    </script>
@endpush
@endsection
