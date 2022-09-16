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
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route("product#createPage") }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
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
                            <form action="{{ route("product#list") }}" method="GET">
                                <div class="input-group">
                                    <input type="search" name="key" value="{{ request('key') }}" class="form-control" placeholder="Search Key" >
                                    <button class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-1 offset-10 bg-white shadow-sm py-1 px-2 my-1 text-center">
                            <h3><i class="fa-solid fa-database me-2"></i>{{ $pizza->total() }}</h3>
                        </div>
                    </div>

                    @if (count($pizza) != 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>View Count</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pizza as $p)
                                <tr class="tr-shadow">
                                    <td class="col-2"><img class="img-thumbnail" src="{{ asset("storage/" . $p->image) }}" ></td>
                                    <td class="col-3" class="col-6">{{ $p->name }}</td>
                                    <td class="col-2">{{ $p->price }}</td>
                                    <td class="col-2">{{ $p->category_name }}</td>
                                    <td class="col-2"><i class="fa-solid fa-eye"></i>{{ $p->view_count }}</td>
                                    <td class="col-2">
                                        <div class="table-data-feature">
                                                <a href="{{ route("product#edit",$p->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="view">
                                                        <i class="fa-solid fa-eye me-2"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route("product#updatePage",$p->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            <a href="{{ route("product#delete",$p->id) }}">
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
                        <div class="">
                            {{ $pizza->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @else
                        <h4 class="mt-5 text-center">There is no pizza here...</h4>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
