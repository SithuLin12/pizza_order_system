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
                                <h2 class="title-1">Contact List</h2>
                            </div>
                        </div>
                    </div>



                    <div class="row mt-3">
                        <div class="col-1 offset-10 bg-white shadow-sm py-1 px-2 my-1 text-center">
                            <h3><i class="fa-solid fa-database me-2"></i>{{ count($contact) }}</h3>
                        </div>
                    </div>
                    {{-- @if (count($categories) != 0) --}}
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User_ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contact as $c )

                                <tr class="tr-shadow">
                                    <td >{{ $c->id }}</td>
                                    <td>{{ $c->user_id }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->email }}</td>
                                    <td>
                                    <div class="table-data-feature">
                                        <a href="{{ route("admin#contactDetails",$c->id) }}">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="view">
                                                <i class="fa-solid fa-eye me-2"></i>
                                            </button>
                                        </a>

                                        <a href="{{ route("admin#contactBlock",$c->user_id) }}">
                                            <button class="item ms-2 text-danger" data-toggle="tooltip" data-placement="top" title="ban account">
                                                <i class="fa-solid fa-ban text-danger"></i>
                                            </button>
                                        </a>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{-- {{ $users->appends(request()->query())->links() }} --}}
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


