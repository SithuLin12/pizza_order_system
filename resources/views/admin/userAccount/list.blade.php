@extends("admin.layouts.master")

@section("title","categoryListPage")

@section("content")
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                    </div>
                    <div class="col-4 offset-8">
                        @if (session("deleteSession"))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-circle-xmark me-2"></i>{{ session("deleteSession") }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-muted">Search Key: <span class="text-danger">{{ request('key') }}</span></h4>
                        </div>
                        <div class="col-3 offset-9">
                            <form action="" method="GET">
                                <div class="input-group">
                                    <input type="search" name="key" value="{{ request('key') }}" class="form-control" placeholder="Search Key" >
                                    <button class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>

                    </div>



                    <div class="row mt-3">
                        <div class="col-1 offset-10 bg-white shadow-sm py-1 px-2 my-1 text-center">
                            <h3><i class="fa-solid fa-database me-2"></i>{{ $users->total() }}</h3>
                        </div>
                    </div>
                    {{-- @if (count($categories) != 0) --}}
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user )

                                <tr class="tr-shadow">

                                    <td class="col-2">
                                        @if ($user->image == null)
                                            @if ($user->gender == 'male')
                                                <img src="{{ asset("image/default_user.jpeg") }}" class="img-thumbnail shadow-sm" alt="">
                                            @else
                                                <img src="{{ asset("image/female_default.png") }}" class="img-thumbnail">
                                            @endif
                                        @else
                                        <img src="{{ asset("storage/".$user->image) }}" class="img-thumbnail">
                                        @endif

                                    </td>
                                    <input type="hidden" class="userId" value="{{ $user->id }}">
                                    <td >{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>
                                            <select class="form-control me-5 changeRole" >
                                                <option value="admin" @if($user->role == "admin") selected @endif>Admin</option>
                                                <option value="user" @if($user->role == "user") selected @endif>User</option>
                                            </select>
                                    </td>
                                    <td class="col-1">

                                        <div class="table-data-feature">
                                                <a href="{{ route("admin#usersDelete",$user->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                    {{-- @else
                    <h3 class="text-secondary text-center mt-5" >There is no category</h3>
                    @endif --}}
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section("source")
    <script>
        $(document).ready(function(){
            $(".changeRole").change(function(){
                $currentStatus = $(this).val();
                $parentNote = $(this).parents("tr");
                $userId = $parentNote.find(".userId").val();

                $data = {
                    "status" : $currentStatus,
                    "userId" : $userId
                }


                $.ajax({
                    type : "get",
                    url : "http://localhost:8000/user/ajax/userChangeRole",
                    data : $data,
                    dataType : "json",
                })
                location.reload();
            })
            })

    </script>
@endsection
