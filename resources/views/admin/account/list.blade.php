@extends("admin.layouts.master")

@section("title","categoryListPage")

@section("content")
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

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
                                    <input type="search" name="key" value="{{ request('key') }}" class="form-control" placeholder="Search for name or email" >
                                    <button class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-1 offset-10 bg-white shadow-sm py-1 px-2 my-1 text-center">
                            <h3><i class="fa-solid fa-database me-2"></i>{{ $admin->total() }}</h3>
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
                                    <th>Created Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $a )
                                <tr class="tr-shadow">
                                    <td class="col-2">
                                        @if ($a->image == null)
                                            @if ($a->gender == 'male')
                                                <img src="{{ asset("image/default_user.jpeg") }}" class="img-thumbnail shadow-sm" alt="">
                                            @else
                                                <img src="{{ asset("image/female_default.png") }}" class="img-thumbnail">
                                            @endif
                                        @else
                                        <img src="{{ asset("storage/".$a->image) }}" class="img-thumbnail">
                                        @endif

                                    </td>
                                    <input type="hidden" class="userId" value="{{ $a->id }}">
                                    <td >{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->gender }}</td>
                                    <td>{{ $a->phone }}</td>
                                    <td>{{ $a->address }}</td>
                                    <td>{{ $a->created_at->format("d-M-Y") }}</td>
                                    <td>
                                        @if (Auth::user()->id == $a->id)

                                        @else

                                            <select class="form-control me-5" id="changeRole">
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>


                                        @endif
                                    </td>
                                    <td class="col-1">
                                        @if (Auth::user()->id == $a->id)

                                        @else
                                        <div class="table-data-feature">
                                                <a href="{{ route("admin#delete",$a->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                        </div>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $admin->appends(request()->query())->links() }}
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
            $("#changeRole").change(function(){
                $currentStatus = $(this).val();
                $parentNote = $(this).parents("tr");
                $userId = $parentNote.find(".userId").val();

                $data = {
                    "status" : $currentStatus,
                    "userId" : $userId
                }
                $.ajax({
                    type: "get",
                    url: "http://localhost:8000/admin/ajax/change/role",
                    data: $data,
                    dataType: "json",
                    success : function(response){
                        if(response.status == "success"){
                            location.reload()
                        }
                    }
                    })
                })
            })

    </script>
@endsection
